<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use SahusoftCom\EloquentImageMutator\EloquentImageMutatorTrait;

class Profile extends Model
{
    use EloquentImageMutatorTrait;

    protected $fillable = ['name', 'middlename', 'lastname', 'title', 'user_id', 'birthdate', 'email', 'phone', 'cover_photo', 'profile_picture', 'photo'];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function userphoto()
    {
        return $this->hasOne(UserPhoto::class, 'user_id', 'id');

    }

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The photo fields should be listed here.
     *
     * @var array
     */
    protected $image_fields = ['profile_picture'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'profiles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     * */
}