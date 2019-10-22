<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Post;
use App\Models\Comment;

class User extends Authenticatable
{
    use Notifiable;

    const IS_BANNED = 1;

    const IS_ACTIV = 0;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'is_admin', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public static function add($fields)
    {
        $user = new static;
        $user->fill($fields);
        $user->password = bcrypt($fields->password);
        $user->save();
        return $user;
    }

    public function edit($fields)
    {
        $this->fill($fields);
        $this->password = bcrypt($fields->password);
        $this->save();
    }

    public function remove()
    {
        Storage::delete($this->image);
        $this->delete();
    }

    public function uploadAvatar($image)
    {
        if ($image == null) { return;}

        Storage::delete($this->image);
        $fileName = $image->store('user');
        $this->image = $fileName;
        $this->save();

    }

    public function makeAdmin()
    {
        $this->is_admin = 1;
        $this->save();
    }

    public function makeNormal()
    {
        $this->is_admin = 0;
        $this->save();
    }

    public function toggleUser($value)
    {
        if($value == null){

            return $this->makeNormal();

        }

        return $this->makeAdmin();

    }

    public function makeStatusBan()
    {
        $this->status = User::IS_BANNED;
        $this->save();
    }

    public function makeStatusUnBan()
    {
        $this->status = User::IS_ACTIV;
        $this->save();
    }

    public function toggleBan($value)
    {
        if($value == null){

            return $this->makeStatusUnBan();

        }

        return $this->makeStatusBan();

    }

    public function getImages()
    {
        if($this->images == null ){
            return '/img/users/default_user.png';
        }

        return '/storage/users/' . $this->images;

    }

}
