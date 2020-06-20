<?php

namespace App\Http\Controllers;

use App\Http\Requests\LecturerLoginRequest;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LecturerLoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/lecturer';

    /**
     * ManagerLoginController constructor.
     */
    public function __construct()
    {
        $this->middleware('guest:lecturer')->except('logout');
    }

    /**
     * @return mixed
     */
    public function guard()
    {
        return Auth::guard('lecturer');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login-manager', ['url' => '/lecturers/login']);
    }

    /**
     * @param LecturerLoginController $request
     * @return \Illuminate\Http\RedirectResponse|void
     * @throws ValidationException
     */
    public function login(LecturerLoginRequest $request)
    {
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }
        if ($this->attemptLogin($request)) {
            return redirect()->route(\LECTURER);
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

        return $this->loggedOut($request) ?: redirect('/lecturers');
    }

}
