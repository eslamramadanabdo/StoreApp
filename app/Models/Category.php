<?php

namespace App\Models;

use App\Rules\Filter;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;

class Category extends Model
{
    use HasFactory , SoftDeletes;
    protected $table = 'categories';

    protected $fillable = [ 'parent_id' , 'name' , 'slug'  , 'description' , 'parent_id'  , 'image' , 'status' ];

    public static function rules($id = 0): array{
        return [
            'name' => [
                'required' , 'string' , 'min:3' , 'max:255' ,
                Rule::unique('categories' , 'name')->ignore($id),
                'filter:laravel,php,html'
            ],
            'parent_id'  => [
                'nullable' , 'int', 'exists:categories,id' 
            ],
            'image'      => [
                'image' , 'max:1048576' , 'dimensions:min_width=100,min_height=200' ,
            ],
            'status'      => 'in:active,archived',
            'description' => 'nullable|string'
        ];
    }


    public function scopeFilter(Builder $builder , $filter){
        if($filter['name'] ?? false){
            $builder->where('categories.name' , 'LIKE' , "%{$filter['name']}%" );
        }

        if($filter['status'] ?? false){
            $builder->where('categories.status' , '=' , $filter['status'] );
        }
    }


    // create relation with table product (one category has many products)
    public function products(){
        return $this->hasMany(Product::class , 'category_id' , 'id');
    }


    // create relation with table categories and categories ( one parent has many child )
    public function parent(){
        return $this->belongsTo(Category::class , 'parent_id' , 'id')
                    ->withDefault([
                        'name' => ' - '
                    ]);
    }

    public function children(){
        return $this->hasMany(Category::class , 'parent_id' , 'id');
    }
}


