<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    
    protected $table = 'tags';

    // public $timestamps = false;
    
    protected $fillable = [
        'name',
        'slug', 
    ];

    // create relation with table products  (one tag has many product)
    public function products(){
        return $this->belongsToMany(Product::class , 'product_tag','product_id','tag_id','id','id');
        }
    
}
