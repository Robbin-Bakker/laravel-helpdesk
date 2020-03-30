<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{

    public function submitting_user(){
        return $this->belongsTo('App/User', 'user_id');
    }
    public function assigned_users(){
        return $this->belongsToMany('App/User');
    }
    public function status(){
        return $this->belongsTo('App/Status');
    }
    public function comments(){
        return $this->hasMany('App/Comment');
    }
    
}
