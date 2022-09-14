<?php

namespace App\Orchid\Layouts;

use Orchid\Screen\TD;
use App\Models\Category;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;

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
    protected $target = 'categories';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [

            TD::make('id', 'Category Id')->filter(Input::make())->sort(),

            TD::make('Name', 'Title')
                ->render(function (Category $category) {
                    return Link::make($category->Name)
                        ->route('platform.category.edit', $category);
                }),

            //TD::make('Description', 'Description')->filter(Input::make())->sort(),
           // TD::make('Image', 'Image')->filter(Input::make())->sort(),
            TD::make('Parent','Parent')
                ->render(function (Category $category) {
                    return e($category->Parent_id);
                }),

            TD::make('Status', 'Category Status'),
        ];
    }
}
