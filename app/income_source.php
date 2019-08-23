<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class income_source extends Model
{
    public function department(){
        return $this->belongsTo(department::class);
    }
}
