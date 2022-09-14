<?php

namespace App\Orchid\Layouts;

use Orchid\Screen\TD;
use App\Models\Product;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;

class ProductListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'products';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('Name', 'Title')
                ->render(function (Product $product) {
                    return Link::make($product->Name)
                        ->route('platform.product.edit', $product);
                }),

            //TD::make('Cost_Price','Cost Price')->filter(Input::make())->sort(),
            TD::make('Price','Price'),
            TD::make('Sale_Price','Sale Price'),
            TD::make('Quantity','Quantity'),
            TD::make('Category_id','Product Category id'),
            TD::make('Brand_id','Product Brand id'),
            TD::make('Status','Status')
,
        ];
    }
}
