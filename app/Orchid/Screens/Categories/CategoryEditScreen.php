<?php

namespace App\Orchid\Screens\Categories;

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
use Orchid\Attachment\Models\Attachment;

class CategoryEditScreen extends Screen
{

    public $category;
    /**
     * Query data.
     *
     * @return array
     */
    public function query(Category $category): array
    {
        $category->load('attachment');

        return [
            'category' => $category
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->category->exists ? 'Edit category' : 'Creating a new category';
    }

    public function description(): ?string 
    {
        return "Categories Of Product";
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('Create category')
                ->icon('plus')
                ->method('createOrUpdate')
                ->canSee(!$this->category->exists),

            Button::make('Update')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->category->exists),

            Button::make('Remove')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->category->exists),
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
            layout::rows([
                Input::make('category.name')
                    ->title('Name')
                    ->placeholder('Category Name')
                    ->help('Specify a short descriptive title for this category.'),

                TextArea::make('category.description')
                    ->title('Description')
                    ->rows(3)
                    ->maxlength(200)
                    ->placeholder('Brief description for your category'),


                Cropper::make('category.image')
                    ->title('Category Image')
                    ->maxFiles(1),
            

                Relation::make('category.parent_id')
                    ->title('Category Parent')
                    ->fromModel(Category::class, 'name'),

                Select::make('category.status')
                    ->title('Category Status')
                    ->options([
                        'Active'=>'Active',
                        'Inactive'=>'Inactive'
                    ]),

            ])
        ];
    }


    public function createOrUpdate(Category $category, Request $request)
    {
        $category->fill($request->get('category'))->save();
        $category->attachment()->syncWithoutDetaching(
            $request->input('category.attachment', [])
        );

        Alert::info('You have successfully created an category.');

        return redirect()->route('platform.category.list');
    }


    public function remove(Category $category)
    {
        $category->delete();

        Alert::info('You have successfully deleted the category.');

        return redirect()->route('platform.category.list');
    }
}
