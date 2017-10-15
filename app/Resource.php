<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $fillable=[
        'name',
        'lastname',
        'middlename',
        'title',
        'phone',
        'email',
        'birthdate',
        'company_name'
    ];

    public function checkpoints(){
        return $this->hasMany(Checkpoint::class, 'resource_id',
            'id');
    }
}

