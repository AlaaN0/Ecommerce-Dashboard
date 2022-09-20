<?php

namespace App\Orchid\Layouts;

use App\Models\Brand;
use Orchid\Screen\TD;
use App\Models\Product;
use App\Models\Category;
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
    public $target = 'products';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        
        return [

            TD::make('id', 'Id'),

            TD::make('', 'Featured Image')
                ->width('60')
                ->render(function (Product $product) {
                    return "<img src='{$product->featured_image}' class='mw-100 d-block img-fluid'>";
                }),

            TD::make('name', 'Name')
                ->render(function (Product $product) {
                    return Link::make($product->name)
                        ->route('platform.product.edit', $product);
                }),

            //TD::make('cost_price','Cost Price')
            //    ->render(function (Product $product) {
            //        return $product->cost_price.'$';
            //    }),

            TD::make('price','Price')
                ->render(function (Product $product) {
                    return $product->price.'$';
                }),

            TD::make('sost_price','Sost Price')
                ->render(function (Product $product) {
                    return $product->sale_price.'$';
                }),

            TD::make('sku','SKU')
                ->render(function (Product $product) {
                    return $product->sku;
                }),

            TD::make('quantity','Quantity')
                ->render(function (Product $product) {
                    return $product->quantity;
                }),

            TD::make('category_id','Category')
                ->render(function (Product $product) {
                    return Category::find($product->category_id)->name;
                }),

            TD::make('brand_id','Brand')
                ->render(function (Product $product) {
                    return Brand::find($product->brand_id)->name;
                }),

            TD::make('status', 'Category Status')
                ->render(function (Product $product) {
                    return $product->status;
                }),

            TD::make('', 'Images')
                ->render(function (Product $product) {
                    $img='';
                    if(count($product->attachment)!=0)
                    { //in case the product has many images
                        foreach ($product->attachment as $value) {
                            $img.="<div style='padding:5px;'><img src='$value->url' style='width:50px'></div>";
                        }
                    return "<div style='display: flex;'>.$img.</div>";
                    } else {
                        return "<span></span>";
                    }
                }),
        ];
    }
}
