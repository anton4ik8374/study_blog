<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use App\Models\User;
use App\Models\Tag;

class Post extends Model
{
    protected const IS_PUBLIC = 1;

    protected const IS_DRAFT = 0;

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

    public static function add($filds)
    {
        $post = new static;
        $post->fill($filds);
        $post->save();

        return $post;
    }

    public function edit($filds)
    {
        $this->fill($filds);
        $this->save($filds);

    }

    public function remove()
    {
        Storage::delete($this->image);
        $this->delete();
    }

    public function uploadImage($image)
    {
        if ($image == null) { return;}

            Storage::delete($this->image);
            $fileName = $image->store('uplode');
            $this->image = $fileName;
            $this->save();

    }

    public function setCategory($id)
    {
        if ($id == null) { return;}

        $this->category_id = $id;
        $this->save();
    }

    public function setTags($ids)
    {
        if ($ids == null) { return;}
        $this->tags()->sync($ids);
    }

    public function setDraft()
    {
        $this->status = Post::IS_DRAFT;
        $this->save();
    }

    public function setPublic()
    {
        $this->status = Post::IS_PUBLIC;
        $this->save();
    }

    public function toggleStatus($value)
    {
        if($value == null){

            return $this->setDraft();

        }

            return $this->setPublic();

    }

    public function setFetured()
    {
        $this->is_featured = Post::IS_PUBLIC;
        $this->save();
    }

    public function setStandsrt()
    {
        $this->is_featured = Post::IS_DRAFT;
        $this->save();
    }

    public function toggleFetured($value)
    {
        if($value == null){

            return $this->setStandsrt();

        }

            return $this->setFetured();

    }

    public function getImages($images)
    {
        if($images == null ){
            return '/storage/uplode/defaul_post.png';
        }

        return $images;

    }

}
