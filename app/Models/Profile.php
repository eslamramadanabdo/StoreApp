<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    protected $table = 'profiles';

    protected $primaryKey = 'user_id';
    
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'birthday',
        'gender',
        'street_address',
        'city',
        'state',
        'postal_code',
        'country',
        'locale'
    ];

    // create relation one to one with profile (one person has one profile )
    public function user(){
        return $this->belongsTo(User::class , 'user_id' , 'id');
    }
}
