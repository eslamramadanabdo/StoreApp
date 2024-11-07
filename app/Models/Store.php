<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'stores';
    protected $primaryKey = 'id';

    // public $incrementing = true;
    // public $timestamps = true;
    
    protected $fillable = [
        'name',
        'slug',
        'description', 
        'logo_image', 
        'cover_image', 
        'status', 
    ];

    // create relation with table product (one store has many products)
    public function products(){
        return $this->hasMany(Product::class , 'store_id' , 'id');
    }

}
