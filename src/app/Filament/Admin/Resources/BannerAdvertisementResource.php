<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\BannerAdvertisementResource\Pages;
use App\Filament\Admin\Resources\BannerAdvertisementResource\RelationManagers;
use App\Models\BannerAdvertisement;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BannerAdvertisementResource extends Resource
{
    protected static ?string $model = BannerAdvertisement::class;

    protected static ?string $navigationIcon = 'heroicon-o-paper-airplane';

    public static function getNavigationGroup(): ?string
    {
        return 'Media & Advertisement';
    }

    public static function getNavigationSort(): ?int
    {
        return 3;
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    protected static ?string $navigationLabel = 'Banner Advertisement';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')->required(),
                Forms\Components\fileUpload::make('thumbnail')->required(),
                Forms\Components\TextInput::make('url')->required(),
                Forms\Components\Select::make('status')->options([
                    'active' => 'Active',
                    'not_active' => 'Not Active',
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\ImageColumn::make('thumbnail'),
                Tables\Columns\TextColumn::make('url'),
                Tables\Columns\TextColumn::make('status'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListBannerAdvertisements::route('/'),
            'create' => Pages\CreateBannerAdvertisement::route('/create'),
            'edit' => Pages\EditBannerAdvertisement::route('/{record}/edit'),
        ];
    }
}
