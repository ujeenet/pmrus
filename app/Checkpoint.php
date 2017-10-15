<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checkpoint extends Model
{
    public $fillable=['project_id','title','resource_id','estimated_duration','real_duration','status','priority','finish_date','start_date'];

    public function resources (){
        return $this->hasOne(Resource::class, 'id','resource_id');
    }
}
