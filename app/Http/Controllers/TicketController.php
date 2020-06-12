<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Validator;

use App\Ticket;
use App\Status;

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
        $tickets = Auth::user()->submitted_tickets()->orderBy('created_at', 'DESC')->get();

        return view('ticket.index', ['tickets' => $tickets]);
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

        return redirect()->route('ticket_index')->with('success', 'Ticket succesvol opgeslagen');
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
    
    /**
     * Update single ticket and reditect to ticket_index
     * 
     * @param int $id
     */
    public function update($id){
        
    }

}
