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

                Forms\Components\Repeater::make('items')
                    ->relationship()
                    ->schema([
                        Forms\Components\TextInput::make('product_name')
                            ->label('Product'),
                        Forms\Components\TextInput::make('quantity'),
                        Forms\Components\TextInput::make('total_price')
                            ->label('Total'),

                        Forms\Components\Placeholder::make('selected_variants')
                            ->label('Selected Flavors')
                            ->content(function ($record) {
                                return view('filament.forms.components.order-items-variants', [
                                    'variants' => $record?->resolved_variants->pluck('name') ?? [],
                                ]);
                            })
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull()
                    ->disabled()
                    ->deletable(false)
                    ->addable(false)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn($query) => $query->with(['items']))
            ->defaultSort('created_at', 'desc')
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
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('chat')
                    ->label('WhatsApp')
                    ->icon('heroicon-o-chat-bubble-left-ellipsis')
                    ->color('success')
                    ->url(fn(Order $record) => $record->getWhatsAppUrl())
                    ->openUrlInNewTab(),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('pending')
                        ->label('Kembalikan ke Pending')
                        ->icon('heroicon-o-clock')
                        ->color('gray')
                        ->visible(fn(Order $record) => $record->status !== 'pending')
                        ->action(function (Order $record) {
                            $record->update(['status' => 'pending']);
                        }),

                    Tables\Actions\Action::make('process')
                        ->label('Proses')
                        ->icon('heroicon-o-arrow-path')
                        ->color('warning')
                        ->visible(fn(Order $record) => $record->status !== 'processing')
                        ->action(function (Order $record) {
                            $record->update(['status' => 'processing']);
                        }),

                    Tables\Actions\Action::make('complete')
                        ->label('Selesai')
                        ->icon('heroicon-o-check')
                        ->color('success')
                        ->visible(fn(Order $record) => $record->status !== 'completed')
                        ->action(function (Order $record) {
                            $record->update(['status' => 'completed']);
                        }),

                    Tables\Actions\Action::make('cancel')
                        ->label('Batal')
                        ->icon('heroicon-o-x-mark')
                        ->color('danger')
                        ->visible(fn(Order $record) => $record->status !== 'cancelled')
                        ->action(function (Order $record) {
                            $record->update(['status' => 'cancelled']);
                        }),
                ])
                    ->label('Ubah Status')
                    ->icon('heroicon-m-ellipsis-vertical')
                    ->color('info'),
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
                        Infolists\Components\TextEntry::make('selected_variants')
                            ->label('Chosen Flavors')
                            ->formatStateUsing(function ($state, $record) {
                                if (empty($state)) return '-';
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
            'view' => Pages\ViewOrder::route('/{record}'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
