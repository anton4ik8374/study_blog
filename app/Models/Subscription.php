<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    //Атрибуты которые можно массово присваивать
    protected $fillable = [
        'email','token'
    ];

    //Все поля разрешено менять
    protected $guarded = [];
}
