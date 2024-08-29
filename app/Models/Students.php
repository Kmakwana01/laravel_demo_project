<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'email', 'roll_no'];

    function setNameAttribute($val){
        $this->attributes['name'] = ucwords($val);
    }
    function setEmailAttribute($val){
        $this->attributes['email'] = strtolower($val);
    }

    function getNameAttribute($val){
        return ucwords($val);
    }
}
