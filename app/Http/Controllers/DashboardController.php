<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserMessage;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    public function index()
    {
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
        ]) -> with('senderName', Auth::user()->name);
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

    // Fetch the sender's name
    $sender = User::find($request->input('sender_id'));
    $senderName = $sender->name;

    // Fetch all messages between the sender and receiver
    $messages = UserMessage::where(function ($query) use ($request) {
        $query->where('sender_id', $request->input('sender_id'))
              ->where('receiver_id', $request->input('receiver_id'));
    })->orWhere(function ($query) use ($request) {
        $query->where('sender_id', $request->input('receiver_id'))
              ->where('receiver_id', $request->input('sender_id'));
    })->orderBy('created_at', 'asc')->get();

    return response()->json([
        'success' => true,
        'senderName' => $senderName, // Pass the sender's name in the response
        'message' => $message,
        'messages' => $messages,
    ]);
}


    public function fetchMessages($userId)
{
    $user = auth()->user();

    // Fetch all messages between the authenticated user and the selected user
    $messages = UserMessage::where(function ($query) use ($userId, $user) {
        $query->where('sender_id', $user->id)
            ->where('receiver_id', $userId);
    })->orWhere(function ($query) use ($userId, $user) {
        $query->where('sender_id', $userId)
            ->where('receiver_id', $user->id);
    })->orderBy('created_at', 'asc')->get();

    $senderName = $user->name; // Get the sender's name

    return response()->json([
        'success' => true,
        'senderName' => $senderName, // Pass the sender's name in the response
        'messages' => $messages,
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
