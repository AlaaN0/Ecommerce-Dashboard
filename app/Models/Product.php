<?php

namespace App\Models;

use App\Models\Brand;
use App\Models\Category;
use Orchid\Screen\AsSource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, AsSource;

    protected $fillable = [
        'Name',
        'Description',
        'Cost_Price',
        'Price',
        'Sale_Price',
        'SKU',
        'Quantity',
        'Featured_Image',
        'Images',
        'Category_id',
        'Brand_id',
        'Status',
        
    ];

    //Product BelongsToOne Category
    public function category() {
        return $this->belongsTo(Category::class, 'Category_id');
    }

    //Product BelongsToOne Brand
    public function brand() {
        return $this->belongsTo(Brand::class, 'Brand_id');
    }
}
