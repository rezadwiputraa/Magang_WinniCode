<?php

namespace App\Filament\Admin\Resources\ReplyCommentResource\Pages;

use App\Filament\Admin\Resources\ReplyCommentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReplyComments extends ListRecords
{
    protected static string $resource = ReplyCommentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
