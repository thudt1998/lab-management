<?php

namespace App\Http\Controllers;

use App\Entities\Manager;
use App\Http\Requests\ManagerLoginRequest;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ManagerLoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/manager';

    /**
     * ManagerLoginController constructor.
     */
    public function __construct()
    {
        $this->middleware('guest:manager')->except('logout');
    }

    /**
     * @return mixed
     */
    public function guard()
    {
        return Auth::guard('manager');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login-manager', ['url' => '/managers/login']);
    }

    public function login(ManagerLoginRequest $request)
    {
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return redirect()->route(\MANAGER);
        }
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * @param Request $request
     * @throws ValidationException
     */
    public function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            'system' => [trans('auth.failed')],
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/managers');
    }

}
