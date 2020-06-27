<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

use App\Ticket;
use App\Role;
use App\Status;

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
        $roleName = $user->role->name;
        return ( $user->is($ticket->submitting_user) || $roleName === Role::FIRST_HELPER || $roleName === Role::SECOND_HELPER );
    }

    /**
     * user needs to have customer role to create ticket
     */
    public function create(User $user){
        return $user->role->name === Role::CUSTOMER;
    }

    public function assign(User $user){
        $roleName = $user->role->name;
        return ( $roleName === Role::FIRST_HELPER || $roleName === Role::SECOND_HELPER );
    }

    public function comment(User $user, Ticket $ticket){
        return ( ($user->is($ticket->submitting_user) || $user->assigned_tickets->contains($ticket) ) && $ticket->isOpen() );
    }

    public function close(User $user, Ticket $ticket){
        return ( ($user->is($ticket->submitting_user) || $user->assigned_tickets->contains($ticket) ) && $ticket->isOpen() );
    }

    public function claim(User $user, Ticket $ticket){
        $statusName = $ticket->status->name;
        $roleName = $user->role->name;

        $isFirst = $statusName === Status::FIRST_LINE && $roleName === Role::FIRST_HELPER;
        $isSecond = $statusName === Status::SECOND_LINE && $roleName === Role::SECOND_HELPER;

        return $isFirst || $isSecond;
    }

    public function free(User $user, Ticket $ticket){
        $statusName = $ticket->status->name;
        $roleName = $user->role->name;

        $isFirst = $statusName === Status::FIRST_LINE_ASSIGNED && $roleName === Role::FIRST_HELPER;
        $isSecond = $statusName === Status::SECOND_LINE_ASSIGNED && $roleName === Role::SECOND_HELPER;

        return ($isFirst || $isSecond) && $user->assigned_tickets->contains($ticket);
    }

    public function escalate(User $user, Ticket $ticket){
        $isFirst = $ticket->status->name === Status::FIRST_LINE_ASSIGNED && $user->role->name === Role::FIRST_HELPER;

        return $isFirst && $user->assigned_tickets->contains($ticket);
    }

    public function deescalate(User $user, Ticket $ticket){
        $isSecond = $ticket->status->name === Status::SECOND_LINE_ASSIGNED && $user->role->name === Role::SECOND_HELPER;

        return $isSecond && $user->assigned_tickets->contains($ticket);
    }

    public function delegate(User $user, Ticket $ticket){
        $statusName = $ticket->status->name;
        $roleName = $user->role->name;

        $isFirst = $statusName === Status::FIRST_LINE_ASSIGNED && $roleName === Role::FIRST_HELPER;
        $isSecond = $statusName === Status::SECOND_LINE_ASSIGNED && $roleName === Role::SECOND_HELPER;

        $hasDelegatableUsers = $user->role->users->count() > 1;

        return ($isFirst || $isSecond) && $user->assigned_tickets->contains($ticket) && $hasDelegatableUsers;
    }
}
