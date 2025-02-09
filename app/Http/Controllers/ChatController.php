<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Inertia\Inertia;

class ChatController extends Controller
{
    public function index()
    {
        return Inertia::render('chat');
    }

    public function messages(): Collection
    {
        return Message::with('user')->latest()->take(10)->get();
    }

    /**
     * @param Request $request
     * @return Message
     */
    public function sendMessage(Request $request): Message
    {
        $message = auth()->user()->messages()->create([
            'message' => $request->message,
        ]);

        broadcast(new MessageSent($message->load('user')))->toOthers();

        return $message;
    }
}
