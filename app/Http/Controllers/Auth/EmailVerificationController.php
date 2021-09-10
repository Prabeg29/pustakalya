<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class EmailVerificationController extends Controller
{

    public function __construct()
    {
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();
        return [
            'message'=>'Email has been verified.'
        ];
    }

    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json([
                "message" => "Email already verified."
            ]);
        }
        $request->user()->sendEmailVerificationNotification();
        return response()->json([
            "message" => "Request has been sent."
        ]);
    }
}
