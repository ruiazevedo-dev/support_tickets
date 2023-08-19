<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets  = Ticket::all()->where('user_id', auth()->id());
        return view('ticket.index',['tickets' => $tickets]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ticket.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketRequest $request)
    {

        $ticket = Ticket::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => auth()->id(),
        ]); 

        if($request->file('attachment')){
            $this->store_attachment($request,$ticket);
        }
        

        

        return response()->redirectTo(route('ticket.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        return view('ticket.show',['ticket' => $ticket]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        return view('ticket.edit',['ticket' => $ticket]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
        
        if($request->file('attachment') == NULl){
            $ticket->update(['title' => $request->title,'description' => $request->description]);
        }
        else{
            if($ticket->attachment == NULl && $request->file('attachment') != NULL){
                
                $ticket->update(['title' => $request->title,'description' => $request->description]);
                $this->store_attachment($request,$ticket);
            }
            if($ticket->attachment && $request->file('attachment'))
            {
                Storage::disk('public')->delete($ticket->attachment);
                $this->store_attachment($request,$ticket);
            }
            
            
        }

        return redirect(route('ticket.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        //
    }

    protected function store_attachment($request,$ticket){
        $ext = ($request->file('attachment')->extension());

        $contents = file_get_contents($request->file('attachment'));

        $filename = Str::random(25);      
        
        $path = "attachments/$filename.$ext";

        Storage::disk('public')->put($path,$contents);

        $ticket->update(['attachment' => $path]);
    }
}
