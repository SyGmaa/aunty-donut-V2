<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    public static function canCreate(): bool
    {
        return false; // Order creation is handled by the frontend app
    }

    // "Read Only" usually means we can view but not just edit fields willy-nilly. 
    // However, status updates might be needed? User said "Read-only for the staff" regarding items.
    // I will allow Edit but make the form ReadDisabled or use Infolist for the view.

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Order Details')
                    ->schema([
                        Forms\Components\TextInput::make('id')
                            ->label('Order ID')
                            ->disabled(),
                        Forms\Components\TextInput::make('customer_name')->disabled(),
                        Forms\Components\TextInput::make('customer_phone')->disabled(),
                        Forms\Components\Textarea::make('address')->columnSpanFull()->disabled(),
                        Forms\Components\Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'processing' => 'Processing',
                                'completed' => 'Completed',
                                'cancelled' => 'Cancelled',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('total_price')
                            ->prefix('Rp')
                            ->disabled(),
                        Forms\Components\TextInput::make('payment_status')
                            ->disabled(),
                        Forms\Components\Textarea::make('notes')
                            ->columnSpanFull()
                            ->disabled(),
                    ])->columns(2),

                // We display items using a Repeater, but disabled
                Forms\Components\Repeater::make('items') // Uses the 'items' relationship
                    ->relationship()
                    ->schema([
                        Forms\Components\TextInput::make('product_name')
                            ->label('Product'),
                        Forms\Components\TextInput::make('quantity'),
                        Forms\Components\TextInput::make('total_price')
                            ->label('Total'),

                        // Custom View Field to show the specific flavors (JSON) nicely
                        Forms\Components\ViewField::make('selected_variants')
                            ->label('Selected Flavors')
                            ->view('filament.forms.components.order-items-variants')
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull()
                    ->disabled() // Makes the repeater read-only
                    ->deletable(false)
                    ->addable(false)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('customer_name')
                    ->label('Customer')
                    ->searchable(),
                Tables\Columns\TextColumn::make('customer_phone')->label('Phone'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'gray',
                        'processing' => 'warning',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        default => 'info',
                    }),
                Tables\Columns\TextColumn::make('total_price')->money('idr'),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(), // Prefer View over Edit for read-only feel
                Tables\Actions\EditAction::make(), // Allow editing status
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Order Information')
                    ->schema([
                        Infolists\Components\TextEntry::make('id'),
                        Infolists\Components\TextEntry::make('customer_name')->label('Name'),
                        Infolists\Components\TextEntry::make('customer_phone')->label('Phone'),
                        Infolists\Components\TextEntry::make('address')->columnSpanFull(),
                        Infolists\Components\TextEntry::make('status')
                            ->badge(),
                        Infolists\Components\TextEntry::make('total_price')
                            ->money('idr'),
                        Infolists\Components\TextEntry::make('notes')->columnSpanFull(),
                    ])->columns(2),

                Infolists\Components\RepeatableEntry::make('items')
                    ->schema([
                        Infolists\Components\TextEntry::make('product_name'),
                        Infolists\Components\TextEntry::make('quantity'),
                        Infolists\Components\TextEntry::make('total_price')->money('idr'),

                        // Custom entry to render the variants list
                        Infolists\Components\TextEntry::make('selected_variants')
                            ->label('Chosen Flavors')
                            ->formatStateUsing(function ($state, $record) {
                                // $record is the OrderItem model here
                                if (empty($state)) return '-';
                                // Assuming we use our helper 'resolved_variants' or just parse the array
                                $variants = $record->resolved_variants;
                                return $variants->pluck('name')->join(', ');
                            })
                            ->columnSpanFull(),
                    ])
                    ->columns(3)
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            // 'create' => Pages\CreateOrder::route('/create'), // Disabled
            'view' => Pages\ViewOrder::route('/{record}'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
