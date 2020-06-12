<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

use App\Ticket;
use App\Role;

class TicketPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * users can only view roles that they created
     */
    public function show(User $user, Ticket $ticket){
        return $user->is($ticket->submitting_user);
    }

    /**
     * user needs to have customer role to create ticket
     */
    public function create(User $user){
        return $user->role->name === Role::CUSTOMER;
    }
}
