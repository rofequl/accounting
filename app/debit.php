<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class debit extends Model
{
    public function department(){
        return $this->belongsTo(department::class);
    }

    public function expenditure(){
        return $this->belongsTo(expenditure::class);
    }
}
