<?php

namespace App\Orchid\Screens\Products;

use App\Models\Product;
use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Link;
use App\Orchid\Layouts\ProductListLayout;

class ProductListScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'products' => Product::paginate()
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Product';
    }

    public function description(): ?string
    {
        return 'All Products';
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
                ->icon('pencil')
                ->route('platform.product.edit')
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
            ProductListLayout::class
        ];
    }
}
