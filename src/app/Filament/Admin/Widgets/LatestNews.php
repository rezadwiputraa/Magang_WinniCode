<?php

namespace App\Filament\Widgets;

use App\Filament\Admin\Resources\NewsResource as ResourcesNewsResource;
use App\Filament\Resources\NewsResource;
use App\Models\News;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestNews extends BaseWidget
{

    protected static ?int $sort = 4;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(ResourcesNewsResource::getEloquentQuery())

            ->defaultPaginationPageOption(5)

            ->defaultSort('created_at', 'desc')

            ->columns([
                Tables\Columns\TextColumn::make('author.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->limit(40)
                    ->searchable()
                    ->sortable(),
                Tables\Columns\ImageColumn::make('thumbnail'),
                Tables\Columns\ToggleColumn::make('is_featured'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('author.id')
                    ->relationship('author', 'name')
                    -> label('Select Author'),
                Tables\Filters\SelectFilter::make('category.id')
                    ->relationship('category', 'title')
                    -> label('Select Category'),
            ]
        );
    }
}
