<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use EloquentImageMutatorTrait;
use App\Project;

class User extends Authenticatable
{

    /**
     * The photo fields should be listed here.
     *
     * @var array
     */
    protected $image_fields = ['profile_picture', 'cover_photo'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'is_admin', 'company', 'profile_picture', 'cover_photo'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id','id');

    }
    public function resources()
    {
        return $this->hasMany(Resource::class, 'owner_id','id');

    }
    public function projects()
    {
        return $this->hasMany(Project::class, 'user_id','id');

    }
}
