<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        
    }
    
    /**
     * Create new ticket
     * 
     * return view with form to create ticket
     */
    public function create(){
        return view('ticket.create');
    }
    
    /**
     * Save new ticket
     * 
     * validate data from request and either:
     *    redirect to ticket_create with error message
     *    save ticket and redirect to ticket_index with succes message
     */
    public function save(){
        
    }
    
    /**
     * Show single ticket and corresponding comments
     * 
     * @param int $id
     */
    public function show($id){
        
    }
    
    /**
     * Update single ticket and reditect to ticket_index
     * 
     * @param int $id
     */
    public function update($id){
        
    }

}
