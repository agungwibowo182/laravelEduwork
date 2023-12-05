<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalog extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    //relasi one to many table publisher ke table mbook
    public function books()
    {
        return $this->hasMany('App\Models\Book', 'catalog_id');
    }
}
