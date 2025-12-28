<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-cake';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state))),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true),
                        Forms\Components\FileUpload::make('image')
                            ->image()
                            ->directory('products')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('description')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('price')
                            ->numeric()
                            ->prefix('Rp')
                            ->required(),
                        Forms\Components\Toggle::make('is_active')
                            ->default(true),
                    ])->columns(2),

                Forms\Components\Section::make('Bundle Settings')
                    ->schema([
                        Forms\Components\Toggle::make('is_bundle')
                            ->label('Is this a Bundle?')
                            ->helperText('Enable if this product is a box of multiple items.')
                            ->live(),
                        Forms\Components\TextInput::make('bundle_size')
                            ->label('Bundle Size')
                            ->numeric()
                            ->helperText('How many items can be selected? (e.g. 6 or 12)')
                            ->required(fn(Get $get) => $get('is_bundle'))
                            ->hidden(fn(Get $get) => ! $get('is_bundle')),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->money('idr')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_bundle')
                    ->boolean(),
                Tables\Columns\TextColumn::make('bundle_size')
                    ->placeholder('-'),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
                Tables\Filters\TernaryFilter::make('is_bundle'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\VariantsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
