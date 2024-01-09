<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
// use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Auth\Events\Verified;
use Laravel\Fortify\Fortify;

class VerificationApiController extends Controller
{
	// use VerifiesEmails;
	public function __construct ()
	{
		//
	}
	public function verify(Request $request)
	{
		$userID = $request['id'];
		$user = User::findOrFail($userID);
		$date = date('Y-m-d H:i:s');
		$user->email_verified_at = $date;
		$user->update();
		// return $request->wantsJson()
		// 	? new JsonResponse('', 204)
		// 	: redirect()->intended(Fortify::redirects('email-verification').'?verified=1');
		return $request->wantsJson()
			? new JsonResponse('', 204)
			: redirect()->route('verificado', $user);
		// return response()->json('Email verified!');
	}
	public function resend(Request $request)
	{
		// return $request->user();
		if ($request->user()->hasVerifiedEmail()) {
			return response()->json('Usuario ya tiene verificado su correo electrónico', 422);
			// return redirect($this->redirectPath());
		}
		$request->user()->sendApiEmailVerificationNotification();
		return response()->json('Notificación reenviada');
		// return back()->with('resent', true);
	}
}
