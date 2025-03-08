<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\User;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class MessageController extends Controller
{
    public function index(Item $item){


        $messages=Message::where('item_id',$item->id)
        ->orderBy('created_at' , 'asc')
        ->with('sender')
        ->get();

        if($messages->count()>0){
            $firstMessage=$messages->first();

            $partner=auth()->id() === $firstMessage->sender_id ? User::find($firstMessage->receiver_id) : User::find($firstMessage->sender_id);

        }else{

            $partner = User::find($item->user_id);
        }

        return view('message' , compact('item', 'messages', 'partner'));
    }

    public function store(Request $request, $item_id){

        $image_path = $request->hasFile('thumbnail') ? $request->file('thumbnail')->store('images', 'public') : null;

        $item = Item::findOrFail($item_id);
        if(Auth::id() === $item->user_id){
                $receiver_id = $request->input('receiver_id');
            }else{
                $receiver_id = $item->user_id;
            }

        Message::create([
            'item_id' => $item->id,
            'sender_id' => Auth::id(),
            'receiver_id' =>$receiver_id,
            'message' => $request->input('message'),
            'thumbnail' => $image_path,
        ]);

        return redirect()->route('item.deal' , ['item' => $item->id])
        ->with('success' , 'メッセージを送信しました。');
    }


    public function edit(Message $message){

    if($message->sender_id !== auth()->id()){
        abort(403);
    }

        return view('edit_message' , compact('message'));
    }


    public function update(Request $request, Message $message){

    if($message->sender_id !== auth()->id()){
        abort(403);
    }

        $message->update([
        'message' => $request->input('message')
    ]);

    if ($request->has('delete_thumbnail') && $request->delete_thumbnail) {

            if ($message->thumbnail) {
                Storage::delete('public/' . $message->thumbnail);
            }
            $message->update(['thumbnail' => null]);
        }

    if ($request->hasFile('thumbnail')) {

        if ($message->thumbnail) {
            Storage::delete('public/' . $message->thumbnail);
        }
        $path = $request->file('thumbnail')->store('messages', 'public');

        $message->update(['thumbnail' => $path]);
    }
    return redirect()->route('item.deal', ['item' => $message->item_id])
        ->with('success', 'メッセージを編集しました。');

    }

    public function destroy(Message $message){

    if($message->sender_id !== auth()->id()){
        abort(403);
    }

        $message->delete();

        return redirect()->route('item.deal' , ['item' => $message->item_id])
        ->with('success' , 'メッセージを削除しました。');
    }
}
