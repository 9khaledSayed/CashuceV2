<?php

namespace App\Http\Controllers\Dashboard;

use App\Conversation;
use App\Employee;
use App\Http\Controllers\Controller;
use App\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:employee,company,provider');
    }

    public function index()
    {
        //
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'message' => 'required|string',
            'receiver_id' => 'required|numeric|exists:employees,id',
            'conversation_id' => 'required|numeric|exists:conversations,id'
        ]);
        Message::create([
            'sender_id' => auth()->user()->id,
            'receiver_id' => $data['receiver_id'],
            'conversation_id' => $data['conversation_id'],
            'content' => $data['message'],
        ]);
        //TODO::send database notification with email to the receiver
        return redirect()->back();
    }


    public function show($id)
    {

    }


    public function edit(Message $message)
    {
        //
    }


    public function update(Request $request, Message $message)
    {
        //
    }


    public function destroy(Message $message)
    {
        //
    }
}
