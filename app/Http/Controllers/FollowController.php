<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;
use App\Events\NewNotification;
use App\Http\Requests\StoreFollowRequest;
use App\Http\Requests\UpdateFollowRequest;

class FollowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // In FollowController.php
public function toggle(User $user)
{
    if (auth()->user()->isFollowing($user)) {
        auth()->user()->unfollow($user);
    } else {
        auth()->user()->follow($user);

        $user->notifications()->create([
            'type' => 'follow',
            'message' => auth()->user()->username . ' started following you'
        ]);

        event(new NewNotification($user));
    }

    return back();
}
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFollowRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Follow $follow)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Follow $follow)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFollowRequest $request, Follow $follow)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Follow $follow)
    {
        //
    }

}
