<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Validator;

use App\Ticket;
use App\Status;
use App\Role;

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
                ->with('fail', 'Ticket niet opgeslagen');
        }
        
        $status = Status::where('name', Status::FIRST_LINE)->first();

        $ticket = new Ticket();

        $ticket->title = $request->title;
        $ticket->description = $request->description;

        $ticket->status()->associate($status);

        $request->user()->submitted_tickets()->save($ticket);

        return redirect()->route('ticket_index')->with('success', __('Ticket succesvol opgeslagen.'));
    }
    
    /**
     * Show single ticket and corresponding comments
     * 
     * @param int $id
     */
    public function show(Ticket $ticket){
        $this->authorize('show', $ticket);
        return view('ticket.show', ['ticket' => $ticket]);
    }

    public function close(Ticket $ticket){

        $this->authorize('close', $ticket);

        $newStatus = Status::where('name', Status::CLOSED)->first();

        $ticket->status()->associate($newStatus);

        $ticket->save();

        return redirect()->back()->with('success', __('Ticket succesvol gesloten.'));
    }

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
        
        return redirect()->back()->with('success', __('Ticket succesvol geclaimd.'));
    }

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
        
        return redirect()->back()->with('success', __('Ticket claim succesvol ingetrokken.'));
    }

}
