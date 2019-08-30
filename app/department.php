<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class department extends Model
{
    public function income_source(){
        return $this->hasMany(income_source::class,'department_id');
    }

    public function credit(){
        return $this->hasMany(credit::class,'department_id');
    }

    public function debit(){
        return $this->hasMany(debit::class,'department_id');
    }
}
