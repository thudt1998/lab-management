<?php

namespace App\Http\Controllers;

use App\Http\Requests\LecturerLoginRequest;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class StudentLoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/student';

    /**
     * ManagerLoginController constructor.
     */
    public function __construct()
    {
        $this->middleware('guest:student')->except('logout');
    }

    /**
     * @return mixed
     */
    public function guard()
    {
        return Auth::guard('student');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login-student', ['url' => '/students/login']);
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
            return redirect()->route(\STUDENT);
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

        return $this->loggedOut($request) ?: redirect('/students');
    }
}
