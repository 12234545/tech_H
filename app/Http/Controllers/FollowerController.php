<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follower;

use Illuminate\Http\Request;

class FollowerController extends Controller
{
    public function toggle(Request $request, $userId)
{
    $currentUser = auth()->user();
    $userToFollow = User::findOrFail($userId);

    $existingFollow = Follower::where('creator_id', $userId)
        ->where('follower_id', $currentUser->id)
        ->first();

    if ($existingFollow) {
        $existingFollow->delete();
        $userToFollow->decrement('followers_count');
        return response()->json(['status' => 'unfollowed']);
    } else {
        Follower::create([
            'creator_id' => $userId,
            'follower_id' => $currentUser->id
        ]);
        $userToFollow->increment('followers_count');
        return response()->json(['status' => 'followed']);
    }
}
}
