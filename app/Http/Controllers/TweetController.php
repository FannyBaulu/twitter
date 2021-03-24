<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class TweetController extends Controller
{
    /**
     * List tweets ordered by date of creation, it is also checking if the authenticated
     * user followed the author's of tweets or not in the database and stocking it in
     * the datas regarding tweets sent to the view.
     *
     * @return void
     */
    public function index(){
        $tweets= Tweet::with([
            'user' => fn($query) => $query->withCount([
                'followers as is_followed' => fn($query) 
                => $query->where('follower_id',auth()->user()->id)
            ])
            ->withCasts(['is_followed'=>'boolean'])
        ])
        ->orderBy('created_at','DESC')
        ->get();

        return Inertia::render('Tweets/Index',[
            'tweets'=>$tweets
        ]);
    }

    /**
     * Stocking in database the tweet created by the user including the tweet's content
     * and the user's id. 
     *
     * @param Request $request
     * @return void
     */
    public function store (Request $request){
        $request->validate([
            'content'=> ['required','max:255'],
            'user_id' => ['exists:users,id']
        ]);

        Tweet::create([
            'content' => $request->input('content'),
            'user_id' => auth()->user()->id
        ]);

        return Redirect::route('tweets.index');
    }

    /**
     * A COMMENTER
     *
     */
    public function followings(){
        $followings = Tweet::with('user')
        ->whereIn('user_id',auth()->user()->followings->pluck('id')->toArray())
        ->orderBy('created_at','DESC')
        ->get();
        return Inertia::render('Tweets/Followings',[
            'followings'=>$followings
        ]);
    }

    /**
     * Store in the database the user followed after the authenticated user choosed it.
     *
     * @param User $user
     */
    public function follows(User $user){
        auth()->user()->followings()->attach($user->id);
        return redirect()->back();
    }

    /**
     * Update the database, detaching the author from the list of authors the authenticated user follows.
     *
     * @param User $user
     * @return void
     */
    public function unfollows(User $user){
        auth()->user()->followings()->detach($user->id);
        return redirect()->back();
    }

    /**
     * A Commenter
     *
     * @param User $user
     */
    public function profile(User $user){
        $profileUser = $user->loadCount([
            'followings as is_following_you'
            => fn($query) => $query->where('following_id',auth()->user()->id)
            ->withCasts(['is_following_you' => 'boolean']),
            'followers as is_followed'
            => fn($query) => $query->where('follower_id',auth()->user()->id)
            ->withCasts(['is_followed' => 'boolean']),
        ]);

        $tweets = $user->tweets;

        return Inertia::render('Tweets/Profile',[
            'profileUser' => $profileUser,
            'tweets' => $tweets,
        ]);


    }
}
