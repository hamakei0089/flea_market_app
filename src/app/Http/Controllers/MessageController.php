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
    public function index(Item $item)
{
    $user = auth()->user();

    $messages = Message::where('item_id', $item->id)
        ->orderBy('created_at', 'asc')
        ->with('sender')
        ->get();

    if ($messages->count() > 0) {
        $firstMessage = $messages->first();
        $firstMessageSenderId = $firstMessage->sender_id;

        $partner = auth()->id() === $firstMessage->sender_id
            ? User::find($firstMessage->receiver_id)
            : User::find($firstMessage->sender_id);

        Message::where('item_id', $item->id)
            ->where('receiver_id', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);
    } else {
        $partner = User::find($item->user_id);
        $firstMessageSenderId = Message::where('item_id', $item->id)
            ->orderBy('created_at', 'asc')
            ->first()?->sender_id ?? auth()->id();
    }

    $messageItems = Message::where(function ($query) use ($user) {
        $query->where('sender_id', $user->id)
            ->orWhere('receiver_id', $user->id);
    })
        ->with('item')
        ->orderBy('created_at', 'desc')
        ->get()
        ->unique('item_id');

    $otherDealItems = $messageItems->reject(function ($messageItem) use ($item) {
        return $messageItem->item_id == $item->id;
    });

    return view('message', compact('item', 'messages', 'partner','messageItems', 'firstMessageSenderId', 'otherDealItems'));
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
        $firstMessageSenderId = Message::where('item_id', $item->id)
        ->orderBy('created_at', 'asc')
        ->first()?->sender_id ?? auth()->id();;

        return redirect()->route('item.deal' , ['item' => $item->id , 'firstSenderId' => $firstMessageSenderId])
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

        $firstMessageSenderId = Message::where('item_id', $message->item_id)
        ->orderBy('created_at', 'asc')
        ->first()?->sender_id ?? auth()->id();
    }
    return redirect()->route('item.deal', ['item' => $message->item_id, 'firstSenderId' => $firstMessageSenderId])
        ->with('success', 'メッセージを編集しました。');

    }


    public function destroy(Message $message){

    if($message->sender_id !== auth()->id()){
        abort(403);
    }

        $message->delete();

        $firstMessageSenderId = Message::where('item_id', $message->item_id)
        ->orderBy('created_at', 'asc')
        ->first()?->sender_id ?? auth()->id();

        return redirect()->route('item.deal' , ['item' => $message->item_id , 'firstSenderId' => $firstMessageSenderId])
        ->with('success' , 'メッセージを削除しました。');
    }


    public function dealDone($itemId)
    {
        Message::where('item_id', $itemId)->update(['is_deal_complete' => true]);

        $firstMessageSenderId = Message::where('item_id', $itemId)
            ->orderBy('created_at', 'asc')
            ->first()?->sender_id ?? auth()->id();

        return redirect()->route('item.deal', ['item' => $itemId, 'firstSenderId' => $firstMessageSenderId])
            ->with('evaluation_modal', true);
    }

}
