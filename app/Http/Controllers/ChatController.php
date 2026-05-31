<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('info', 'Будь ласка, увійдіть, щоб розпочати чат з адміністратором.');
        }
        $user = Auth::user();
        $admin = User::where('role', 'admin')->first();
        if (!$admin) {
            return back()->with('error', 'Адміністратор поки недоступний.');
        }
        $messages = Message::where(function($q) use ($user, $admin) {
            $q->where('sender_id', $user->id)->where('receiver_id', $admin->id);
        })->orWhere(function($q) use ($user, $admin) {
            $q->where('sender_id', $admin->id)->where('receiver_id', $user->id);
        })->orderBy('created_at', 'asc')->get();
        Message::where('sender_id', $admin->id)->where('receiver_id', $user->id)->update(['is_read' => true]);
        return view('chat.index', compact('messages', 'admin'));
    }

    public function store(Request $request)
    {
        $request->validate(['content' => 'required|string']);
        $admin = User::where('role', 'admin')->first();
        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $admin->id,
            'content' => $request->input('content'),
            'is_read' => false,
        ]);
        return back();
    }

    public function adminIndex()
    {
        $adminId = Auth::id();
        $userIds = Message::where('sender_id', $adminId)
            ->pluck('receiver_id')
            ->merge(
                Message::where('receiver_id', $adminId)
                    ->pluck('sender_id')
            )
            ->unique()
            ->reject(fn ($id) => $id == $adminId);
        $chats = User::whereIn('id', $userIds)->get()->map(function($user) use ($adminId) {
            $user->unread_count = Message::where('sender_id', $user->id)
                ->where('receiver_id', $adminId)
                ->where('is_read', false)
                ->count();
            $user->last_message = Message::where(function($q) use ($user, $adminId) {
                $q->where('sender_id', $user->id)->where('receiver_id', $adminId);
            })->orWhere(function($q) use ($user, $adminId) {
                $q->where('sender_id', $adminId)->where('receiver_id', $user->id);
            })->latest()->first();
            return $user;
        })->sortByDesc(fn($u) => $u->last_message?->created_at);

        return view('admin.chat.index', compact('chats'));
    }

    public function adminShow($userId)
    {
        $user = User::findOrFail($userId);
        $adminId = Auth::id();
        $messages = Message::where(function($q) use ($user, $adminId) {
            $q->where('sender_id', $user->id)->where('receiver_id', $adminId);
        })->orWhere(function($q) use ($user, $adminId) {
            $q->where('sender_id', $adminId)->where('receiver_id', $user->id);
        })->orderBy('created_at', 'asc')->get();

        return view('admin.chat.show', compact('messages', 'user'));
    }

    public function adminStore(Request $request, $userId)
    {
        $request->validate(['content' => 'required|string']);
        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $userId,
            'content' => $request->input('content')
        ]);
        Message::where('sender_id', $userId)
            ->where('receiver_id', Auth::id())
            ->update(['is_read' => true]);
        return back();
    }
}
