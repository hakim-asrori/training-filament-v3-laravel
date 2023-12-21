<?php

namespace App\Filament\Resources\ArticleResource\Pages;

use App\Enums\ArticleEnum;
use App\Filament\Resources\ArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListArticles extends ListRecords
{
    protected static string $resource = ArticleResource::class;
    protected static ?string $title = ArticleEnum::TITLE;
    protected static ?string $breadcrumb = 'List';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
