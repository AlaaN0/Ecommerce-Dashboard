<?php

namespace App\Models;

use App\Models\Product;
use Orchid\Screen\AsSource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brand extends Model
{
    use HasFactory, AsSource;

    protected $fillable = [
        'name',
        'description',
        'website',
        'status',
    ];

    //Brand HasMany Products
    public function products() 
    {
        return $this->hasMany(Product::class,'Brand_id');
    }

}

