<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmail;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Events\SendMessage;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Show the application dashboard.
     *
     * @return array
     *
     */
    public function getUsers()
    {
        return User::all()->except(Auth::id());
    }

    /**
     * Show the application dashboard.
     *
     * @return array
     */
    public function getMessages()
    {
        return Message::with(['from_user', 'to_user'])->where('from_user_id', 1)->get();
    }

    /**
     * Show the application dashboard.
     * @var Request $request
     * @var int $to_user_id
     *
     * @return Message
     */
    public function sendMessage(Request $request, $to_user_id)
    {
        $auth_user = Auth::user();
        $from_user = User::find($auth_user->id);
        $to_user = User::find($to_user_id);

        $message = Message::create([
            'message' => $request->get('message'),
            'from_user_id' => $from_user->id,
            'to_user_id' => $to_user->id,
        ]);

        broadcast(new SendMessage($from_user, $message))->toOthers();

        if(!$to_user->isOnline()){
            SendEmail::dispatch($to_user->email);
        }

        return $message;
    }
}
