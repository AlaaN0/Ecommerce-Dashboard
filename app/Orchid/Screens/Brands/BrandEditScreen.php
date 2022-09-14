<?php

namespace App\Orchid\Screens\Brands;

use App\Models\Brand;
use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Alert;
use Orchid\Screen\Fields\TextArea;
use Orchid\Support\Facades\Layout;
use Illuminate\Http\Request;

class BrandEditScreen extends Screen
{

    public $brand;
    /**
     * Query data.
     *
     * @return array
     */
    public function query(Brand $brand): array
    {
        return [
            'brand' => $brand
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->brand->exists ? 'Edit brand' : 'Creating a new brand';
    }

    public function description(): ?string
    {
        return "Brands Of Product";
    }
    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('Create brand')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->brand->exists),

            Button::make('Update')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->brand->exists),

            Button::make('Remove')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->brand->exists),
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
            Layout::rows([
                Input::make('brand.Name')
                    ->title('Title')
                    ->placeholder('Brand Title')
                    ->help('Specify a short descriptive title for this brand.'),

                TextArea::make('brand.Description')
                    ->title('Description')
                    ->rows(3)
                    ->maxlength(200)
                    ->placeholder('Brief description for preview'),

                Input::make('brand.Website')
                    ->title('Brand Website')
                    ->type('url'),

                Select::make('brand.Status')
                    ->title('Brand Status')
                    ->options([
                        'active'=>'Active',
                        'inactive'=>'Inactive'
                    ]),

            ])
        ];
    }


    public function createOrUpdate(Brand $brand, Request $request)
    {
        $brand->fill($request->get('brand'))->save();

        Alert::info('You have successfully created an brand.');

        return redirect()->route('platform.brand.list');
    }

    public function remove(Brand $brand)
    {
        $brand->delete();

        Alert::info('You have successfully deleted the brand.');

        return redirect()->route('platform.brand.list');
    }
}
