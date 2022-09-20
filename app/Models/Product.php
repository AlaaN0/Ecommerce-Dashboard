<?php

namespace App\Models;

use App\Models\Brand;
use App\Models\Category;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Models\Attachment;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, AsSource, Attachable;

    protected $fillable = [
        'name',
        'description',
        'cost_price',
        'price',
        'sale_price',
        'sku',
        'quantity',
        'featured_image',
        'images',
        'category_id',
        'brand_id',
        'status',
        
    ];

    //Product BelongsToOne Category
    public function category() 
    {
        return $this->belongsTo(Category::class, 'Category_id');
    }

    //Product BelongsToOne Brand
    public function brand() 
    {
        return $this->belongsTo(Brand::class, 'Brand_id');
    }
}
