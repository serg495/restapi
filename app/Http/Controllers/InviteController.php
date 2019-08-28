<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateInviteRequest;
use App\Http\Requests\ReceivedInviteRequest;
use App\Http\Requests\SentInviteRequest;
use App\Http\Resources\InviteResource;
use App\Invite;

class InviteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    
    public function send(CreateInviteRequest $request)
    {
        $fields = $request->all();
        $fields['sender_id'] = auth()->id();

        Invite::create($fields);

        return response()->json(['data' => 'Invite sent']);
    }
    
    public function cancel(SentInviteRequest $request, Invite $invite)
    {
        $invite->update(['is_canceled' => true]);

        return response()->json(['data' => $invite->toArray()]);
    }

    public function confirm(ReceivedInviteRequest $request, Invite $invite)
    {
        $invite->update(['confirmed' => $request->confirmation]);

        return response()->json(['data' => $invite->toArray()]);
    }

}
