<?php

namespace App\Orchid\Layouts;

use App\Models\Brand;
use Orchid\Screen\TD;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;

class BrandListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    public $target = 'brands';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('id', 'Id'),

            TD::make('name', 'Name')
                ->render(function (Brand $brand) {
                    return Link::make($brand->name)
                        ->route('platform.brand.edit', $brand);
                }),

                TD::make('website', 'Website')
                    ->render(function (Brand $brand) {
                        return Link::make($brand->website);
                }),

                //TD::make('Description', 'Description')->filter(Input::make())->sort(),
                
                TD::make('status', 'Brand Status')
                    ->render(function (Brand $brand) {
                        return Link::make($brand->status);
                    }),
        ];
    }
}
