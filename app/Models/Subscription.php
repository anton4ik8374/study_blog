<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Subscription extends Model
{
    //Атрибуты которые можно массово присваивать
    protected $fillable = [
        'email','token'
    ];

    //Все поля разрешено менять
    protected $guarded = [];

    public static function add($email)
    {
        $sub = new static;
        $sub->email = $email;
        $sub->token = Str::random(100);
        $sub->save();

        return $sub;
    }


    public function remove()
    {
        $this->delete();
    }
}
