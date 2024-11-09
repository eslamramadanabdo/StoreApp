<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\StoreScope; 
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;



class Product extends Model
{
    use HasFactory , SoftDeletes;
    protected $table = 'products';
    protected $fillable = [
        'name',
        'store_id',
        'category_id',
        'slug',
        'description', 
        'image', 
        'price', 
        'compare_price', 
        'options', 
        'rating', 
        'featured', 
        'status', 
    ];

    public static function rules($id= 0){
        return [
            'name' => [
                'required', 'string', 'min:3', 'max:255',
                Rule::unique( 'products', 'name' )->ignore($id),
            ],
            'store_id'  => [
                'required', 'int', 'exists:stores,id'
            ],
            'category_id'  => [
                'required', 'int', 'exists:categories,id'
            ],
            'description' => 'nullable|string',
            'image'      => [
                'image', 'max:1048576', 'dimensions:min_width=100,min_height=200',
            ],
            'price'      => [
                'required', 'numeric'
            ],

            'compare_price'      => [
                'nullable', 'numeric'
            ],

            'rating'      => [
                'nullable', 'numeric'
            ],

            'status'      => 'in:active,draft,archived',

        ];
    }


    protected static function booted(){
        static::addGlobalScope('store' , new StoreScope() );
    }

    // create relation with table categories (one product has one category)
    public function category(){
        return $this->belongsTo(Category::class , 'category_id' , 'id');
    }

    // create relation with table stores (one product has one store)
    public function store(){
        return $this->belongsTo(Store::class , 'store_id' , 'id');
    }


    // create relation with table tags  (one product has many tages)
    public function tags(){
        return $this->belongsToMany(Tag::class , 'product_tag','product_id','tag_id','id','id');
    }


    public function scopeActive(Builder $builder ){
        $builder->where('status' , '=' , 'active');
    }


    // accessors
        // return image url
    public function getImageUrlAttribute(){
         if(!$this->image){
            return "https://www.incathlab.com/images/products/default_product.png";
         }
         if(Str::startsWith($this->image, ['http://' , 'https://']  )){
            return $this->image;
         }
         if(Str::startsWith($this->image, ['uploades']  )){
            return asset('storage/' . $this->image);
         }
    }

    // return sale after calculate discount 
    public function getSalePercentAttribute(){
        return intval(( ( $this->compare_price - $this->price)/ $this->price ) * 100)  ; 
    }

}