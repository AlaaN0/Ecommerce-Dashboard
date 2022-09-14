<?php

namespace App\Models;

use App\Models\Product;
use Orchid\Screen\AsSource;
use Orchid\Filters\Filterable;
use Orchid\Attachment\Attachable;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Models\Attachment;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory, AsSource, Attachable, Filterable;

    protected $fillable = [
        'Name',
        'Description',
        'Image',
        'Parent_id',
        'Status',
    ];

    //Category hasMany Products
    public function products() {
        return $this->hasMany(Product::class,'Category_id');
    }

    public function parent()
    {
        return $this->belongsTo(self::class,'Parent_id');
    }

    public function children()
    {
        return $this->belongsTo(self::class,'Parent_id');
    }
}
