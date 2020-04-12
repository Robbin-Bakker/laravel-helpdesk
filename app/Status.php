<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{

    const FIRST_LINE = 'eerstelijn';
    const FIRST_LINE_DESC = 'ticket wacht op een eerstelijns medewerker';

    const FIRST_LINE_ASSIGNED = 'eerstelijn_toegewezen';
    const FIRST_LINE_ASSIGNED_DESC = 'ticket is toegewezen aan eerstelijns medewerker';
    
    const SECOND_LINE = 'tweedelijn';
    const SECOND_LINE_DESC = 'ticket wacht op een tweedelijns medewerker';

    const SECOND_LINE_ASSIGNED = 'tweedelijn_toegewezen';
    const SECOND_LINE_ASSIGNED_DESC = 'ticket is toegewezen aan tweedelijns medewerker';
    
    const CLOSED = 'afgehandeld';
    const CLOSED_DESC = 'ticket is afgehandeld';
    
    public function tickets(){
        return $this->hasMany('App/Ticket');
    }

}
