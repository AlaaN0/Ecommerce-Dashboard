<?php

namespace App\Orchid\Screens\Products;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Cropper;
use Orchid\Screen\Fields\Picture;
use Orchid\Support\Facades\Alert;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\TextArea;
use Orchid\Support\Facades\Layout;

class ProductEditScreen extends Screen
{

    public $product;
    /**
     * Query data.
     *
     * @return array
     */
    public function query(Product $product): array
    {
        return [
            'product' => $product
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->product->exists ? 'Edit product' : 'Creating a new product';
    }

    public function description(): ?string
    {
        return "Products";
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('Create product')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->product->exists),

            Button::make('Update')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->product->exists),

            Button::make('Remove')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->product->exists),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::rows([
                Input::make('product.Name')
                    ->title('Title')
                    ->placeholder('Product Title')
                    ->help('Specify a short descriptive title for this product.'),

                TextArea::make('product.Description')
                    ->title('Description')
                    ->rows(3)
                    ->maxlength(200)
                    ->placeholder('Brief description for preview'),

                Input::make('product.Cost_Price')
                    ->title('Cost price')
                    ->type('number'),

                Input::make('product.Price')
                    ->title('Product Price')
                    ->type('number'),
            
                Input::make('product.Sale_Price')
                    ->title('Sale Price')
                    ->type('number'),
                
                Input::make('product.SKU')
                    ->title('SKU')
                    ->type('string'),

                Input::make('product.Quantity')
                    ->title('Available quantity')
                    ->type('number'),

                Picture::make('product.Featured_Image')
                    ->title('Featured Image')->targetId()
                    ->required(),

                Picture::make('product.Images')
                    ->title('Image'),

                Relation::make('product.Category_id')
                    ->title('Category')
                    ->fromModel(Category::class, 'Name'),
                    
                Relation::make('product.Brand_id')
                    ->title('Brand')
                    ->fromModel(Brand::class, 'Name'),

                Select::make('product.Status')
                    ->title('Product Status')
                    ->options([
                        'active'=>'Active',
                        'inactive'=>'Inactive'
                    ]),

            ])
        ];
    }

    public function createOrUpdate(Product $product, Request $request)
    {
        $product->fill($request->get('product'))->save();

        Alert::info('You have successfully created an product.');

        return redirect()->route('platform.product.list');
    }

    public function remove(Product $product)
    {
        $product->delete();

        Alert::info('You have successfully deleted the product.');

        return redirect()->route('platform.product.list');
    }
}
