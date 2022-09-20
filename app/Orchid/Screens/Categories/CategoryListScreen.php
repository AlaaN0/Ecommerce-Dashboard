<?php

namespace App\Orchid\Screens\Categories;

use App\Models\Category;
use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Link;
use Illuminate\Http\UploadedFile;
use Orchid\Attachment\File;
use App\Orchid\Layouts\CategoryListLayout;

class CategoryListScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(Category $category): array
    {
        $category->load('attachment');

        return [
            'categories' => Category::paginate()
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Categories Of Product';
    }

    public function description(): ?string
    {
        return "All Categories";
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Link::make('Create new')
                ->icon('plus')
                ->route('platform.category.edit')
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [
            CategoryListLayout::class
        ];
    }
}
