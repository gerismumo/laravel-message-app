<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserMessage;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class DashboardController extends Controller
{
    public function index(){

       // Get the authenticated user
       $user = auth()->user();

       // Get all registered users except the authenticated user
       $users = User::where('id', '!=', $user->id)->get();

       // Simulating the messages for demonstration purposes
       $messages = [];

       return view('contents.dashboard', [
           'user' => $user,
           'users' => $users,
           'messages' => $messages
       ]);
   }

   public function sendMessage(Request $request)
   {
       // Validate the request data
       $request->validate([
           'sender_id' => 'required|exists:users,id',
           'receiver_id' => 'required|exists:users,id',
           'message' => 'required|string|max:255',
       ]);

       // Create a new message
       $message = new UserMessage();
       $message->sender_id = $request->input('sender_id');
       $message->receiver_id = $request->input('receiver_id');
       $message->text = $request->input('message');
       $message->save();

       return response()->json([
           'success' => true,
           'message' => $message
       ]);
   }

   public function deleteMessage($messageId)
   {
       // Find the message
       $message = UserMessage::find($messageId);

       if (!$message) {
           return response()->json([
               'success' => false,
               'message' => 'Message not found'
           ], 404);
       }

       // Delete the message
       $message->delete();

       return response()->json([
           'success' => true,
           'message' => 'Message deleted successfully'
       ]);
   }
    
}
