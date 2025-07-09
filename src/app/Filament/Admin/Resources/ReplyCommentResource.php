<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ReplyCommentResource\Pages;
use App\Filament\Admin\Resources\ReplyCommentResource\RelationManagers;
use App\Models\ReplyComment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReplyCommentResource extends Resource
{
    protected static ?string $model = ReplyComment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationGroup(): ?string
    {
        return 'Comment Management';
    }

    public static function getNavigationSort(): ?int
    {
        return 3;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->defaultSort('created_at', 'desc')
        ->columns([
            TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),
            TextColumn::make('review')
                    ->label('Review')
                    ->searchable()
                    ->limit(25)
                    ->sortable(),
            TextColumn::make('Comment.name')
                    ->label('Comment Name')
                    ->searchable()
                    ->sortable(),
            TextColumn::make('Comment.review')
                    ->label('Comment Review')
                    ->searchable()
                    ->limit(25)
                    ->sortable(),
            TextColumn::make('created_at')
                    ->label('Created At')
                    ->searchable()
                    ->sortable(),
        ])
        ->filters([
            //
        ])
        ->actions([
            Tables\Actions\DeleteAction::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReplyComments::route('/'),
            'create' => Pages\CreateReplyComment::route('/create'),
            'edit' => Pages\EditReplyComment::route('/{record}/edit'),
        ];
    }
}
