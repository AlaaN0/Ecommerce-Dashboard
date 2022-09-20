<?php

namespace App\Orchid\Layouts;

use storage;
use Orchid\Screen\TD;
use App\Models\Category;
use Orchid\Attachment\File;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\Client\Request;

class CategoryListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    public $target = 'categories';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
        
            TD::make('id', 'Id'),

            TD::make('', 'Image')
                ->width('80')
                ->render(function (Category $category) {
                    return "<img src='{$category->image}' class='mw-100 d-block img-fluid'>";
                }),
            

            TD::make('name', 'Name')
                ->render(function (Category $category) {
                    return Link::make($category->name)
                        ->route('platform.category.edit', $category);
                }),

            TD::make('description', 'Description'),
            TD::make('parent','Parent')
                ->render(function (Category $category) {
                    if($category->parent_id!=0)
                    {
                        $parentCategory = Category::find($category->parent_id);
                    return $parentCategory->name;
                   }
                    else { return "NULL";}
                }),

            TD::make('status', 'Category Status')
                ->render(function (Category $category) {
                    return Link::make($category->status);
                }),
        ];
    }
}
