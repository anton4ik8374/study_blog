<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Post;

class Category extends Model
{

    use Sluggable;

    //Атрибуты которые можно массово присваивать
    protected $fillable = [
        'title','slug'
    ];

    //Все поля разрешено менять
    protected $guarded = [];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
