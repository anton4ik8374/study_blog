<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\Storage;

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
        'name', 'email', 'is_admin', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
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
        $user->password = bcrypt($user->password);
        $user->save();
        return $user;
    }

    public function generatePassword($password)
    {
        if($password !== null) {
            $this->password = bcrypt($password);
            $this->save();
        }
    }

    public function edit($fields)
    {
        $this->fill($fields);
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

        if($this->avatar !== null) {
            Storage::delete($this->avatar);
        }
        $fileName = $image->store('user');
        $newName = explode('/',$fileName);
        $this->avatar = $newName[1];
        $this->save();
        return $newName[1];

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

            $this->makeNormal();

            return $this;

        }

        $this->makeAdmin();

        return $this;

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

            $this->makeStatusUnBan();

            return $this;

        }

        $this->makeStatusBan();

        return $this;

    }

    public function getImages()
    {
        if($this->avatar == null ){
            return '/img/users/default_user.png';
        }

        return '/storage/user/' . $this->avatar;

    }

    public function getImagesMini()
    {
        if($this->avatar == null ){
            return '/img/users/default_user.png';
        }

        return '/storage/user/mini/' . $this->avatar;

    }

    public function deleteImages($name)
    {
        $path = '/user/';

        return Storage::delete($path . $name);
    }

    public function deleteMiniImages($name)
    {
        $path = '/user/mini/';

        return Storage::delete($path . $name);
    }

}
