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
        $product->load('attachment');
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
                ->icon('plus')
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
                Input::make('product.name')
                    ->title('Name')
                    ->placeholder('Product Name')
                    ->help('Specify a short descriptive title for this product.'),

                TextArea::make('product.description')
                    ->title('Description')
                    ->rows(3)
                    ->maxlength(200)
                    ->placeholder('Brief description for your product'),

                Input::make('product.cost_price')
                    ->title('Cost price')
                    ->type('number'),

                Input::make('product.price')
                    ->title('Product Price')
                    ->type('number')
                    ->check('product.price' > 'product.cost_price'),
            
                Input::make('product.sale_price')
                    ->title('Sale Price')
                    ->type('number'),
                
                Input::make('product.sku')
                    ->title('SKU')
                    ->type('string'),

                Input::make('product.quantity')
                    ->title('Available quantity')
                    ->type('number'),

                Cropper::make('product.featured_image')
                    ->title('Upload a featured image for your product')//->targetRelativeUrl()
                    ->required(),

                Upload::make('product.attachment')
                    ->title('Upload images for your product')
                    ->acceptedFiles('image/*')
                    ->targetRelativeUrl(),

                Relation::make('product.category_id')
                    ->title('Category')
                    ->fromModel(Category::class, 'name'),
                    
                Relation::make('product.brand_id')
                    ->title('Brand')
                    ->fromModel(Brand::class, 'name'),

                Select::make('product.status')
                    ->title('Product Status')
                    ->options([
                        'Active'=>'Active',
                        'Inactive'=>'Inactive'
                    ]),

            ])
        ];
    }

    public function createOrUpdate(Product $product, Request $request)
    {
        $product->fill($request->get('product'))->save();

        $product->attachment()->syncWithoutDetaching(
            $request->input('product.attachment', [])
        );

        Alert::info('You have successfully created a product.');

        return redirect()->route('platform.product.list');
    }

    public function remove(Product $product)
    {
        $product->delete();

        Alert::info('You have successfully deleted the product.');

        return redirect()->route('platform.product.list');
    }
}
