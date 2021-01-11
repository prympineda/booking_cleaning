<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $guarded = [];

    public function employee(){
        return $this->hasOne('App\User', 'id', 'employee_id');
    }

    public function customer(){
        return $this->hasOne('App\User', 'id', 'customer_id');
    }
}
