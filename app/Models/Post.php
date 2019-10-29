<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use App\Models\User;
use App\Models\Tag;
use Carbon\Carbon;

class Post extends Model
{
    protected const IS_PUBLIC = 1;

    protected const IS_DRAFT = 0;

    use Sluggable;

    //Атрибуты которые можно массово присваивать
    protected $fillable = [
        'title','slug', 'content', 'views', 'date'
    ];

    //Все поля разрешено менять
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class);
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
        $post->user_id = 1;
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

        if($this->image !== null) {

            $this->deleteImages($this->image);

            $this->deleteMiniImages($this->image);
        }

        $this->deleteTag();

        $this->delete();
    }

    public function deleteTag()
    {
        $this->tags->delete();
    }

    public function uploadImage($image)
    {
        if ($image == null) { return;}

        if($this->image !== null) {
            Storage::delete($this->image);
        }
        $fileName = $image->store('posts');
        $newName = explode('/',$fileName);
        $this->image = $newName[1];
        $this->save();
        return $newName[1];

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

    public function toggleStatus($value = null)
    {
        if($value == null){

            return $this->setPublic();

        }

        return $this->setDraft();

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

    public function toggleFetured($value = null)
    {
        if($value == null){

            return $this->setStandsrt();

        }

            return $this->setFetured();

    }

    public function getImage()
    {

        if($this->image == null ){
            return '/img/posts/default_user.webp';
        }

        return '/storage/posts/' . $this->image;

    }
    public function getImageMini()
    {

        if($this->image == null ){
            return '/img/posts/default_user.webp';
        }

        return '/storage/posts/mini/' . $this->image;

    }

    public function getCategoryTitle()
    {
        if($this->category !== null) {
            return $this->category->title;
        }

        return 'Нет категорий';
    }

    public function getTagsTitles()
    {
        if(!$this->tags->isEmpty()) {
            return implode(', ', $this->tags->pluck('title')->all());
        }

        return 'Нет тегов';
    }

    /**
     * Mutator srt pluck date
     * @param $value
     */
    public function setDateAttribute($value)
    {
        $this->attributes['date'] = Carbon::createFromFormat('d/m/y',$value)->format('Y-m-d');
    }

    /**
     * Mutatur get pluck date
     * @param $value
     * @return string
     */
    public function getDateAttribute($value)
    {
       return Carbon::createFromFormat('Y-m-d',$value)->format('d/m/y');
    }

    /**
     * Mutator set pluck Status
     * @param $value
     */
    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = $value == 'on' ? 1 : 0;
    }

    public function getCategoryID()
    {
        if($this->category !== null) {
            return $this->category->id;
        }

        return null;
    }

    public function deleteImages($name)
    {
        $path = '/posts/';

        return Storage::delete($path . $name);
    }

    public function deleteMiniImages($name)
    {
        $path = '/posts/mini/';

        return Storage::delete($path . $name);
    }

}
