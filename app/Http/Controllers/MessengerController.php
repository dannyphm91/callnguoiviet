<?php

namespace App\Http\Controllers;

use App\Events\ChatMessage;
use App\Models\Messenger;
use App\Models\MessengerUser;
use App\Models\User;
use Illuminate\Http\Request;

class MessengerController extends Controller
{
    public function index()
    {
        $users = $this->fetchUserList();

        return view('frontend.message', compact('users'));
    }

    protected function fetchUserList()
    {
        $auth_id = auth()->id();

        return MessengerUser::whereHas('messages')->with('from:id,name,username,image', 'to:id,name,username,image')
            ->where('to_id', $auth_id)
            ->orWhere('from_id', $auth_id)
            ->withCount(['messages as latest_message_time' => function ($query) {
                $query->select(\DB::raw('max(created_at)'));
            }])
            ->orderByDesc('latest_message_time')
            ->get()
            ->map(function ($user) {
                $user->human_time = \Carbon\Carbon::parse($user->latest_message_time)->diffForHumans(null, null, true);
                $user->my_user_id = auth()->id();
                $user->recipient_user_id = $user->from_id == auth()->id() ? $user->to_id : $user->from_id;

                return $user;
            });
    }

    public function fetchMessages($username)
    {
        $user = User::whereUsername($username)->firstOrFail();

        if ($user->id != auth()->id()) {
            Messenger::where(function ($query) use ($user) {
                $query->where(function ($q) use ($user) {
                    $q->where('from_id', auth()->id());
                    $q->where('to_id', $user->id);
                })
                    ->orWhere(function ($q) use ($user) {
                        $q->where('to_id', auth()->id());
                        $q->where('from_id', $user->id);
                    });
            })
                ->update(['read' => 1]);
        }

        return Messenger::where(function ($query) use ($user) {
            $query->where(function ($q) use ($user) {
                $q->where('from_id', auth()->id());
                $q->where('to_id', $user->id);
            })
                ->orWhere(function ($q) use ($user) {
                    $q->where('to_id', auth()->id());
                    $q->where('from_id', $user->id);
                });
        })
            ->get();
    }

    public function sendMessage(Request $request)
    {
        try {
            $request->validate(['message' => 'required']);

            $message = Messenger::create([
                'from_id' => auth()->id(),
                'to_id' => $request->to,
                'body' => $request->message ?? 'No message',
                'messenger_user_id' => $request->chat_id,
                'read' => 0,
            ]);

            broadcast(new ChatMessage($message))->toOthers();

            return $message;
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => $th->getMessage()]);
        }
    }

    public function syncUserList()
    {
        return $this->fetchUserList();
    }

    public function sendMessageWebsite(Request $request)
    {
        try {
            if (! $request->body || ! $request->to_id || ! $request->ad_id) {
                flashError('Please enter message');

                return back();
            }

            $messenger_user = MessengerUser::where(function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('from_id', auth()->id());
                    $q->where('to_id', $request->to_id);
                })
                    ->orWhere(function ($q) use ($request) {
                        $q->where('to_id', auth()->id());
                        $q->where('from_id', $request->to_id);
                    });
            })->first();

            if (! $messenger_user) {
                $messenger_user = MessengerUser::create([
                    'from_id' => auth()->id(),
                    'to_id' => $request->to_id,
                    'ad_id' => $request->ad_id ?? null,
                ]);
            }

            Messenger::create([
                'from_id' => auth()->id(),
                'to_id' => $request->to_id,
                'body' => $request->body ?? 'No message',
                'messenger_user_id' => $messenger_user->id,
            ]);

            flashSuccess('Message sent successfully');

            return back();
        } catch (\Throwable $th) {
            flashError('An error occurred:'.$th->getMessage());

            return back();
        }
    }
}
