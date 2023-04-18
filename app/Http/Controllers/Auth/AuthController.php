<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegistrationUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function create(): \Inertia\Response
    {
        return Inertia::render('Users/Auth/login');
    }
    public function login(LoginUserRequest $request): \Illuminate\Http\RedirectResponse
    {
//        $credentials = $request->validateWithBag('auth.login.validation');
        $validated = $request->validateWithBag('auth.login.validation',$request->rules());

        if (Auth::attempt($validated)) {
            $request->session()->regenerate();

            return redirect()->intended();
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);

    }
    public function viewRegistration(): \Inertia\Response
    {
        return Inertia::render('Users/Auth/registration');
    }
    public function registration(RegistrationUserRequest $request){

        $validated = $request->validateWithBag('auth.registration.validation',$request->rules());
        User::create( $validated );
        return to_route('auth.login');
    }
    public function destroy(): \Illuminate\Http\RedirectResponse
    {
        Auth::logout();

        return to_route('auth.login');
    }
}
