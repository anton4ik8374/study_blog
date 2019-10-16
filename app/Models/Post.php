<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\User;
use App\Models\Tag;

class Post extends Model
{
    use Sluggable;

    //Атрибуты которые можно массово присваивать
    protected $fillable = [
        'title','slug', 'content', 'category_id', 'user_id', 'status', 'views', 'is_featured'
    ];

    //Все поля разрешено менять
    protected $guarded = [];

    public function category()
    {
        return $this->hasOne(Category::class);
    }

    public function author()
    {
        return $this->hasOne(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

}
