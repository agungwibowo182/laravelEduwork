<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    //relasi one two one table member ke table user
    public function user()
    {
        return $this->hasOne('App\Models\User', 'member_id');
    }
}
