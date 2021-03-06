<?php

namespace App\Http\Controllers\Auth;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\User\CreateAccount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Auth\ThrottlesLogins;

class RegisterController extends Controller
{
    use ThrottlesLogins;

    /**
     * Show the register page.
     *
     * @return mixed
     */
    public function index()
    {
        if (Auth::check()) {
            return redirect('/home');
        }

        return Inertia::render('Auth/Register', [
            'signInUrl' => route('login'),
        ]);
    }

    /**
     * Store the user.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $data = [
            'email' => $email,
            'password' => $password,
        ];

        (new CreateAccount)->execute($data);

        Auth::attempt($data);

        return Redirect::route('home');
    }
}
