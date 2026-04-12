<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    public function book(){
        return $this->hasMany(Book::class);
    }   
    public function books(){
        return $this->hasMany(Book::class);
    } 
}
