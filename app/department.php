<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class department extends Model
{
    public function income_source(){
        return $this->hasMany(income_source::class,'department_id');
    }
}
