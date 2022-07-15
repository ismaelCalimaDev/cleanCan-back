<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuestionResource\Pages;
use App\Filament\Resources\QuestionResource\RelationManagers;
use App\Models\Question;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class QuestionResource extends Resource
{
    protected static ?string $model = Question::class;
    protected static ?string $navigationGroup = 'Aplicación';
    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';
    protected static ?string $label = 'Interrogante';
    protected static ?string $pluralLabel = 'Preguntas Comunes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('ask')
                    ->label('Pregunta')
                    ->columnSpan(2)
                    ->required(),
                TinyEditor::make('answer')
                    ->label('Respuesta')
                    ->columnSpan(2)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('ask')->label('Pregunta')->searchable(),
            ])
            ->filters([
                //
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
            'index' => Pages\ListQuestions::route('/'),
            'create' => Pages\CreateQuestion::route('/create'),
            'edit' => Pages\EditQuestion::route('/{record}/edit'),
        ];
    }
}
