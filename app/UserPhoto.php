<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use SahusoftCom\EloquentImageMutator\EloquentImageMutatorTrait;

class UserPhoto extends Model
{

    use EloquentImageMutatorTrait;

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
    protected $image_fields = ['photo'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_photos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'photo'];


}
