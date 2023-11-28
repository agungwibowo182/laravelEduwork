<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;
    //relasi one to many table publisher ke table mbook
    public function books()
    {
        return $this->hasMany('App\Models\Author', 'author_id');
    }
}
