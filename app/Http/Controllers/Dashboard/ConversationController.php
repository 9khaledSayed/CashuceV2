<?php

namespace App\Http\Controllers\Dashboard;

use App\Conversation;
use App\Employee;
use App\Http\Controllers\Controller;
use App\Message;
use App\Scopes\ParentScope;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:employee,company,provider');
    }

    public function index(Request $request)
    {
        $this->authorize('view_conversations');
        $this->authorize('not-company');
        if($request->ajax()){
            $userID = auth()->user()->id;
            $conversations = Conversation::where('hr_id', $userID)
                ->orWhere('employee_id', $userID)
                ->with(['hr', 'employee'])->get();

            return response()->json($conversations);
        }
        return view('dashboard.conversations.index');
    }


    public function create()
    {
        $this->authorize('create_conversations');
        $this->authorize('not-company');
        $employees = Employee::get();
        return view('dashboard.conversations.create', compact('employees'));
    }


    public function store(Request $request)
    {
        $this->authorize('create_conversations');
        $this->authorize('not-company');

        if(!auth()->user()->isHR()){
            return redirect()->back()->withErrors(['massage' => __("Sorry You can\'t use this service because you are not an HR")]);
        }

        $request->validate([
            'employee_id' => 'required|numeric|exists:employees,id',
        ]);
        $conversation =  Conversation::firstOrCreate([
            'employee_id' => $request->employee_id,
            'hr_id' => auth()->user()->id,
        ]);
        return redirect(route('dashboard.conversations.show', $conversation->id));

    }


    public function show(Conversation $conversation)
    {
        $this->authorize('show_my_conversations', $conversation);
        $this->authorize('not-company');

//        $receiver_id = (auth()->user()->id == $conversation->hr_id)?$conversation->employee_id:$conversation->hr_id;
//        $receiver = Employee::withoutGlobalScope(ParentScope::class)->find($receiver_id);
        $messages = Message::with(['receiver', 'sender'])->where('conversation_id', $conversation->id)->get();
        return view('dashboard.conversations.show', compact('messages','conversation'));
    }


    public function destroy(Request $request, Conversation $conversation)
    {
        $this->authorize('delete_conversations');
        $this->authorize('not-company');

        if($request->ajax()){
            $conversation->delete();
            return response()->json([
                'status' => true,
                'message' => 'Item Deleted Successfully'
            ]);
        }
        return redirect(route('dashboard.conversations.index'));
    }
}
