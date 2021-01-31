<?php

namespace App\Http\Controllers;

use App\Models\Messages;
use App\Models\User;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    protected Request $request;

    /**
     * MessagesController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index() {
        $messages = Messages::where('to_id', \Auth::user()->id)->with('fromUser')->get()->toArray();
        if(strpos(\Auth::user()->menuroles, 'admin')) {
            $messages = Messages::with('fromUser')->with('toUser')->get()->toArray();
        }
        return view('dashboard.messages.messagesList')->with(['messages' => $messages]);
    }

    public function createMessage() {
        $users = User::select('id','name')->where('id', '<>', \Auth::user()->id)->orderBy('name')->get()->toArray();
        return view('dashboard.messages.createMessage')->with(['users'=>$users]);
    }

    public function postCreateMessage() {
        $data = $this->request->all();

        $message = new Messages();
        $message->to_id = $data['to_user'];
        $message->from_id = \Auth::user()->id;
        $message->text = $data['message-text'];
        $message->save();

        return redirect()->route('messages.index');
    }

    public function deleteMessage($id) {
        Messages::find($id)->delete();
        return redirect()->route('messages.index');
    }

    public function getSentMessages() {
        $messages = Messages::where('from_id', \Auth::user()->id)->with('toUser')->get()->toArray();
        return view('dashboard.messages.sentMessages')->with(['messages' => $messages]);
    }

}
