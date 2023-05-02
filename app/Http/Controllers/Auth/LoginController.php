<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Models\Core\Employee;
use App\Models\Core\User;
use App\Providers\RouteServiceProvider;
use App\Utils\Whiltelist;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected string $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(RedirectIfAuthenticated::class, ['except' => 'logout']);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username(): string
    {
        return 'username';
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @return array
     */
    protected function credentials(Request $request)
    {
        $credentials = $request->only($this->username(), 'password');

        if (str_contains($credentials[$this->username()], '@')) {
            $credentials['email'] = $credentials[$this->username()];
            unset($credentials[$this->username()]);
        }

        return $credentials;
    }

    /**
     * @throws ValidationException
     */
    public function authenticate(Request $request): \Symfony\Component\HttpFoundation\Response
    {
        $this->validateLogin($request);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        /** @var User $coreUser */
        $coreUser = User::query()->with('employee')->where('user_name', $request->get('username'))->first();

        if ($coreUser && Hash::check($request->get('password'), $coreUser->user_password)) {

            if (!\App\Models\User::query()->where('username', $coreUser->user_name)->exists()) {
                $communityUser = new \App\Models\User();
                $communityUser->email = $coreUser->employee->emp_work_email;
                $communityUser->username = $coreUser->user_name;
                $communityUser->type = $this->getUserRole($coreUser->user_name, $coreUser->employee->emp_work_email);
                $communityUser->password = bcrypt($request->get('password'));
                $communityUser->name = $this->getName($coreUser->employee);
                $communityUser->email_verified_at = now();
                $communityUser->remember_token = Str::random(10);
                $communityUser->bio = '';
                $communityUser->save();
            }
        }

        //dd($request->only('username', 'password'));
        if (Auth::attempt($request->only('username', 'password'), $request->boolean('remember'))) {
            if ($request->hasSession()) {
                $request->session()->put('auth.password_confirmed_at', time());
            }

            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    private function getName(Employee $employee): string
    {
        if (!empty($employee->emp_middle_name)) {
            return sprintf('%s %s %s', $employee->emp_firstname, $employee->emp_middle_name, $employee->emp_lastname);
        } else {
            return sprintf('%s %s', $employee->emp_firstname, $employee->emp_lastname);
        }
    }

    private function getUserRole(string $username, string $email): int
    {
        return in_array($username, Whiltelist::ALL_ADMINS) || in_array($email, Whiltelist::ALL_ADMINS) ? \App\Models\User::ADMIN : \App\Models\User::DEFAULT;
    }
}
