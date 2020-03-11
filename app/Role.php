<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    const ADMIN = 'administrator';
    const CUSTOMER = 'klant';
    const FIRST_HELPER = 'eerstelijns medewerker';
    const SECOND_HELPER = 'tweedelijns medewerker';
    
    public function users(){
        return $this->hasMany('App/User');
    }

}
