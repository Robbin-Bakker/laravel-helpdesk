<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    const UNASSIGNED = 'niet_toegewezen';

    const FIRST_LINE = 'eerstelijn';

    const FIRST_LINE_ASSIGNED = 'eerstelijn_toegewezen';
        
    const SECOND_LINE = 'tweedelijn';

    const SECOND_LINE_ASSIGNED = 'tweedelijn_toegewezen';
    
    const CLOSED = 'afgehandeld';
    
    public function tickets(){
        return $this->hasMany('App\Ticket');
    }

}
