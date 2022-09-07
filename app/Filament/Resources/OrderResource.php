<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-list';
    protected static ?string $navigationGroup = 'Administración';
    protected static ?string $label = 'Pedido';
    protected static ?string $pluralLabel = 'Pedidos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DateTimePicker::make('date')
                    ->label('Hora del lavado')
                    ->columnSpan(2),
                Forms\Components\BelongsToSelect::make('user_id')
                    ->relationship('user', 'email')
                    ->label('Correo del usuario')
                    ->disabled(),
                Forms\Components\BelongsToSelect::make('user_id')
                    ->relationship('user', 'phone_number')
                    ->label('Teléfono de contacto')
                    ->disabled(),
                Forms\Components\BelongsToSelect::make('product_id')
                    ->relationship('product', 'title')
                    ->label('Producto')
                    ->disabled(),
                Forms\Components\Card::make()
                ->schema([
                    Forms\Components\BelongsToSelect::make('car_id')
                        ->relationship('car', 'model')
                        ->label('Modelo')
                        ->disabled(),
                    Forms\Components\BelongsToSelect::make('car_id')
                        ->relationship('car', 'brand')
                        ->label('Marca')
                        ->disabled(),
                    Forms\Components\BelongsToSelect::make('car_id')
                        ->relationship('car', 'plate')
                        ->label('Matrícula')
                        ->disabled(),
                    Forms\Components\BelongsToSelect::make('car_id')
                        ->relationship('car', 'color')
                        ->label('Color')
                        ->disabled(),
                ])->label('H')->columns(2),
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\BelongsToSelect::make('location_id')
                            ->relationship('location', 'province')
                            ->label('Provincia')
                            ->disabled(),
                        Forms\Components\BelongsToSelect::make('location_id')
                            ->relationship('location', 'postal_code')
                            ->label('Código Postal')
                            ->disabled(),
                        Forms\Components\BelongsToSelect::make('location_id')
                            ->relationship('location', 'street')
                            ->label('Calle')
                            ->disabled(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.email')
                    ->label('Correo del usuario')
                    ->searchable(),
                Tables\Columns\TextColumn::make('product.title')
                    ->label('Pedido')
                    ->searchable(),
            ])
            ->filters([
                Filter::make('date')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')->label('Fecha inicial'),
                        Forms\Components\DatePicker::make('created_until')->label('Fecha final'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('date', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('date', '<=', $date),
                            );
                    })
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
