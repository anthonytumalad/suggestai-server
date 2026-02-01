<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GoogleAuthService;
use Laravel\Socialite\Facades\Socialite;


class GoogleAuthController extends Controller
{
    public function __construct(
        private readonly GoogleAuthService $googleAuthService
    ){}

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();

        /** @var Student $student */
        $student = $this->googleAuthService->loginOrRegister($googleUser);

        return redirect()->route('forms.show', ['slug' => 'feedback-form']);
    }
}
