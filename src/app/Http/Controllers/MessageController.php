<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use App\Models\Message;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\MessageRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\DealCompleteNotification;


class MessageController extends Controller
{
    public function index(Item $item)
{
        $user = auth()->user();

        $messages = Message::where('item_id', $item->id)
            ->orderBy('created_at', 'asc')
            ->with('sender')
            ->get();

        if ($user->id === $item->user_id) {

        $partner = Purchase::where('item_id', $item->id)->first()?->user;

        } else {

        $partner = $item->user;
        }

        Message::where('item_id', $item->id)
            ->where('receiver_id', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $evaluationModal = $messages->contains('is_deal_complete', true);

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

        return view('message', compact('item', 'messages', 'partner','messageItems','otherDealItems'))
        ->with('evaluation_modal', $evaluationModal);
    }


    public function store(MessageRequest $request, $item_id){

        $validated = $request->validated();

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
            'message' => $validated['message'],
            'thumbnail' => $image_path,
        ]);

        return redirect()->route('item.deal' , ['item' => $item->id ])
        ->with('success' , 'メッセージを送信しました。');
    }


    public function edit(Message $message){

        return view('edit_message' ,  compact('message'));
    }


    public function update(MessageRequest $request, Message $message){

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
        return redirect()->route('item.deal', ['item' => $message->item_id])
            ->with('success', 'メッセージを編集しました。');

        }


    public function destroy(Message $message){

        if($message->sender_id !== auth()->id()){
            abort(403);
        }

            $message->delete();


            return redirect()->route('item.deal' , ['item' => $message->item_id ])
            ->with('success' , 'メッセージを削除しました。');
        }


    public function dealDone($itemId){

        Message::where('item_id', $itemId)->update(['is_deal_complete' => true]);

        $item = Item::findOrFail($itemId);
        $seller = $item->user;

        Mail::to($seller->email)->send(new DealCompleteNotification($item));

        return redirect()->route('item.deal', ['item' => $itemId ])
            ->with('evaluation_modal', true);
    }

}
