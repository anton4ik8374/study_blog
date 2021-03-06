<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Post;

class Comment extends Model
{
    //Атрибуты которые можно массово присваивать
    protected $fillable = [
        'text','user_id','post_id'
    ];

    //Все поля разрешено менять
    protected $guarded = [];

    public function author()
    {
        return $this->hasOne(User::class);
    }

    public function posts()
    {
        return $this->hasOne(Post::class);
    }

    public function allow()
    {
        $this->status = 1;
        $this->save();
    }

    public function ban()
    {
        $this->status = 0;
        $this->save();
    }

    public function toggleStatud()
    {
        if($this->status == 0){
            return $this->allow();
        }

        return $this->ban();

    }

    public function remove()
    {
        $this->delete();
    }
}
