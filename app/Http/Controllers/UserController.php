<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserInvitesRequest;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function sentInvites()
    {
        $invites = auth()->user()->sentInvites;

        return response()->json(['data' => $invites->toArray()]);
    }

    public function receivedInvites()
    {
        $invites = auth()->user()->receivedInvites()->notCanceled()->get();

        return response()->json(['data' => $invites->toArray()]);
    }

}
