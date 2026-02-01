<?php

namespace App\Services;

use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Contracts\User as SocialiteUser;

final readonly class GoogleAuthService 
{
    /**
    * Log in or register the student using Google OAuth user.
    *
    * @param SocialiteUser $googleUser
    * @return Student
    */
    public function loginOrRegister(SocialiteUser $googleUser): Student
    {
        $student = Student::where('google_id', $googleUser->getId())->first();

        if (!$student) {
            $student = Student::create([
                'google_id'        => $googleUser->getId(),
                'email'            => $googleUser->getEmail(),
                'name'             => $googleUser->getName(),
                'profile_picture'  => $googleUser->getAvatar(),
                'access_granted_at'=> now(),
            ]);
        } else {
            $student->update([
                'access_granted_at' => now(),
            ]);
        }

        Auth::login($student);

        return $student;
    }
}