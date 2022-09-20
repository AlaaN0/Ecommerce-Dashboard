<?php

namespace App\Orchid\Screens\Brands;

use App\Models\Brand;
use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Link;
use App\Orchid\Layouts\BrandListLayout;

class BrandListScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'brands'=> Brand::paginate()
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Brand Of Products';
    }

    public function description(): ?string 
    {
        return 'All Available Brands';
    }
    

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Link::make('Create new Brand')
                ->icon('plus')
                ->route('platform.brand.edit')
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
            BrandListLayout::class
        ];
    }
}
