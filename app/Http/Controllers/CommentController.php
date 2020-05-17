<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
     * 
     * @param int $ticket_id
     */
    public function save($ticket_id){
        
    }

}
