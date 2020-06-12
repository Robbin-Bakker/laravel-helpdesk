<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;

use App\Comment;
use App\Ticket;

class CommentController extends Controller
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
     * Save comment with corresponding ticket
     * 
     * validate data from request and either:
     *    redirect to ticket_show with error message
     *    save comment and redirect to ticket_show with success message
     * @todo method needs to be protected by policy, not every user is allowed to comment
     * 
     * @param int $ticket_id
     */
    public function save(Request $request, Ticket $ticket){
        $ticket = Ticket::findOrFail($ticket->id);

        $validator = Validator::make(
            $request->all(),
            [
                'contents' => 'required'
            ]
        );
        if($validator->fails()){
            return redirect()
                ->route('ticket_show', ['ticket' => $ticket, '#form'])
                ->withErrors($validator)
                ->withInput()
                ->with('fail', 'Reactie niet verzonden');
        }

        $comment = new Comment();
        $comment->contents = $request->contents;
        $comment->ticket()->associate($ticket);

        $request->user()->comments()->save($comment);

        return redirect()
            ->route('ticket_show', ['ticket' => $ticket, '#comments'])
            ->with('success', 'Reactie succesvol verzonden');
    }

}
