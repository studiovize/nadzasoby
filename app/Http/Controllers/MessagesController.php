<?php

namespace App\Http\Controllers;

use App\Events\MessageReceived;
use App\Models\Listing;
use App\Models\User;
use Carbon\Carbon;
use Cmgmyr\Messenger\Models\Message;
use Cmgmyr\Messenger\Models\Participant;
use Cmgmyr\Messenger\Models\Thread;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class MessagesController extends Controller
{
    /**
     * Show all of the message threads to the user.
     *
     * @return mixed
     */
    public function index()
    {
        // All threads, ignore deleted/archived participants
        // $threads = Thread::getAllLatest()->get();

        // All threads that user is participating in
        $threads = Thread::forUser(Auth::id())->latest('updated_at')->get();

        // All threads that user is participating in, with new messages
        // $threads = Thread::forUserWithNewMessages(Auth::id())->latest('updated_at')->get();

        return view('messenger.index', compact('threads'));
    }

    /**
     * Shows a message thread.
     *
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
//        $user = User::where('id', 7)->first();
//        Auth::login($user);

        try {
            $thread = Thread::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Session::flash('error_message', 'The thread with ID: ' . $id . ' was not found.');
            return redirect()->route('messages');
        }

        // all threads
        $threads = Thread::forUser(Auth::id())->latest('updated_at')->get();

        // show current user in list if not a current participant
        // $users = User::whereNotIn('id', $thread->participantsUserIds())->get();

        // don't show the current user in list
        $userId = Auth::id();
//        $users = User::whereNotIn('id', $thread->participantsUserIds($userId))->get();

        $listing = Listing::where('id', $thread->listing_id)->first();

        $thread->markAsRead($userId);

        return view('messenger.show', compact('thread', 'threads', 'listing'));
    }

    /**
     * Creates a new message thread.
     *
     * @return mixed
     */
    public function create()
    {
        $users = User::where('id', '!=', Auth::id())->get();

        return view('messenger.create', compact('users'));
    }


    /**
     * Stores a new message thread.
     *
     * @return mixed
     */
    public function store(Request $request)
    {

        // validate
        $request->validate([
            'listing_id' => 'required|exists:listings,id',
            'message' => 'required'
        ]);

        $user = Auth::user();
        $input = $request->all();

        $listing = Listing::where('id', $input['listing_id'])->first();

        if (!$user->hasUnlocked($listing)) {
            return redirect(route('listings.show', ['listing' => $listing]));
        }

        $thread = Thread::create([
            'subject' => 'Odpověď na ' . $listing->title,
        ]);


        $a = DB::table('threads')->where('id', $thread->id)->update([
            'listing_id' => $listing->id
        ]);;

        // Message
        Message::create([
            'thread_id' => $thread->id,
            'user_id' => Auth::id(),
            'body' => $input['message'],
        ]);

        // Sender
        Participant::create([
            'thread_id' => $thread->id,
            'user_id' => Auth::id(),
            'last_read' => new Carbon,
        ]);


        $thread->addParticipant($listing->user->id);

        event(new MessageReceived($thread));

        return redirect()->route('messages.index');
    }


    /**
     * Adds a new message to a current thread.
     *
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        try {
            $thread = Thread::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Session::flash('error_message', 'The thread with ID: ' . $id . ' was not found.');

            return redirect()->route('messages');
        }

        $thread->activateAllParticipants();

        // Message
        Message::create([
            'thread_id' => $thread->id,
            'user_id' => Auth::id(),
            'body' => $request->input('message'),
        ]);

        // Add replier as a participant
        $participant = Participant::firstOrCreate([
            'thread_id' => $thread->id,
            'user_id' => Auth::id(),
        ]);

        $participant->last_read = new Carbon;
        $participant->save();

        // Recipients
        if ($request->has('recipients')) {
            $thread->addParticipant($request->input('recipients'));
        }

        return redirect()->route('messages.show', $id);
    }
}
