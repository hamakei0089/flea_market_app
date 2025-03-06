<?php

namespace App\Http\Controllers;

use Illuminate\Http\MessageRequest;
use App\Models\Item;
use App\Models\User;
use App\Models\Message;

class MessageController extends Controller
{
    public function index(Item $item){


        $messages=Message::where('item_id',$item->id)
        ->orderBy('created_at' , 'asc')
        ->with('sender')
        ->get();

        if($messages->count()>0){
            $firstMessage=$message->first();

            $partner=auth()->id() === $firstMessage->sender_id ? User::find($firstMessage->receiver_id) : User::find($firstMessage->sender_id);

        }else{

            $partner = User::find($item->user_id);
        }

        return view('message' , compact('item', 'messages', 'partner'));
    }
}
