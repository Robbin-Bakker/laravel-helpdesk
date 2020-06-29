<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Validator;

use App\Ticket;
use App\Status;
use App\Role;
use App\User;

class TicketController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show all tickets from user
     * 
     */
    public function index(){
        $this->authorize('create', Ticket::class);

        $tickets = Auth::user()->submitted_tickets()->orderBy('created_at', 'DESC')->get();

        return view('ticket.index', ['tickets' => $tickets]);
    }

    /**
     * Show all tickets for helpdesk
     * 
     */
    public function index_helpdesk(){
        $this->authorize('assign', Ticket::class);

        $rolename = Auth::user()->role->name;

        if($rolename === Role::FIRST_HELPER){

            $status = Status::where('name', Status::FIRST_LINE)->first();

        } else {

            $status = Status::where('name', Status::SECOND_LINE)->first();

        }

        $assigned_tickets = Auth::user()->assigned_tickets;

        $unassigned_tickets = $status->tickets->sortByDesc('created_at');

        return view('ticket.index_helpdesk', [
            'assigned_tickets' => $assigned_tickets,
            'unassigned_tickets' => $unassigned_tickets
            ]);
    }
    
    /**
     * Create new ticket
     * 
     * return view with form to create ticket
     */
    public function create(){
        $this->authorize('create', Ticket::class);
        return view('ticket.create');
    }
    
    /**
     * Save new ticket
     * 
     * validate data from request and either:
     *    redirect to ticket_create with error message
     *    save ticket and redirect to ticket_index with succes message
     */
    public function save(Request $request){
        
        $this->authorize('create', Ticket::class);
        
        $validator = Validator::make(
            $request->all(),
            [
                'title'         => 'required|max:191',
                'description'   => 'required',
            ]
        );

        if($validator->fails()){
            return redirect()
                ->route('ticket_create')
                ->withErrors($validator)
                ->withInput()
                ->with('fail', __('Ticket not saved, invalid input.'));
        }
        
        $status = Status::where('name', Status::FIRST_LINE)->first();

        $ticket = new Ticket();

        $ticket->title = $request->title;
        $ticket->description = $request->description;

        $ticket->status()->associate($status);

        $request->user()->submitted_tickets()->save($ticket);

        return redirect()->route('ticket_index')->with('success', __('Ticket successfully saved.'));
    }
    
    /**
     * Show single ticket and corresponding comments
     * 
     * @param int $id
     */
    public function show(Ticket $ticket){
        $this->authorize('show', $ticket);

        $vars['ticket'] = $ticket;

        $user = Auth::user();
        if($user->can('delegate', $ticket)){
            $vars['delegatable_users'] = $user->role->users->except($user->id);
        }

        return view('ticket.show', $vars);
    }

    /**
     * 
     */
    public function close(Ticket $ticket){

        $this->authorize('close', $ticket);

        $newStatus = Status::where('name', Status::CLOSED)->first();

        $ticket->status()->associate($newStatus);

        $ticket->save();

        return redirect()->back()->with('success', __('Ticket successfully closed.'));
    }

    /**
     * 
     */
    public function claim(Ticket $ticket){

        $this->authorize('claim', $ticket);

        if($ticket->status->name === Status::FIRST_LINE){

            $newStatus = Status::where('name', Status::FIRST_LINE_ASSIGNED)->first();

        } else {

            $newStatus = Status::where('name', Status::SECOND_LINE_ASSIGNED)->first();

        }

        $ticket->status()->associate($newStatus);

        $ticket->save();

        Auth::user()->assigned_tickets()->attach($ticket);
        
        return redirect()->back()->with('success', __('Ticket successfully claimed.'));
    }

    /**
     * 
     */
    public function free(Ticket $ticket){

        $this->authorize('free', $ticket);

        if($ticket->status->name === Status::FIRST_LINE_ASSIGNED){

            $newStatus = Status::where('name', Status::FIRST_LINE)->first();

        } else {

            $newStatus = Status::where('name', Status::SECOND_LINE)->first();

        }

        $ticket->status()->associate($newStatus);

        $ticket->save();

        Auth::user()->assigned_tickets()->detach($ticket);
        
        return redirect()->back()->with('success', __('Ticket successfully unclaimed.'));
    }

    /**
     * 
     */
    public function escalate(Ticket $ticket){

        $this->authorize('escalate', $ticket);

        $newStatus = Status::where('name', Status::SECOND_LINE)->first();

        $ticket->status()->associate($newStatus);

        $ticket->save();
        
        return redirect()->back()->with('success', __('Ticket successfully escalated.'));
    }

    /**
     * 
     */
    public function deescalate(Ticket $ticket){

        $this->authorize('deescalate', $ticket);

        $newStatus = Status::where('name', Status::FIRST_LINE_ASSIGNED)->first();

        $ticket->status()->associate($newStatus);

        $ticket->save();

        Auth::user()->assigned_tickets()->detach($ticket);
        
        return redirect()->back()->with('success', __('Ticket successfully deescalated.'));
    }

    /**
     * 
     */
    public function delegate(Request $request, Ticket $ticket){

        $this->authorize('delegate', $ticket);

        $user = Auth::user();

        $request->validate([
            'delegatable_user' => 'required|numeric',
        ]);

        if(User::where('id', $request->delegatable_user)->exists()){

            $userToDelegateTo = User::find($request->delegatable_user);

        } else {
            return redirect()->back()->with('fail', __('Ticket not delegated. target user does not exist.'));
        }

        if($userToDelegateTo->role->isNot($user->role)){
            return redirect()->back()->with('fail', __('Ticket not delegated. target user does not have correct role.'));
        } else if($user->is($userToDelegateTo)){
            return redirect()->back()->with('fail', __('Ticket not delegated. target user is self.'));
        }

        $ticket->assigned_users()->detach($user);
        
        $ticket->assigned_users()->attach($userToDelegateTo);

        return redirect()->back()->with('success', __('Ticket successfully delegated to :name.', ['name' => $userToDelegateTo->name]));
    }

}
