<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Models\Core\Employee;
use App\Models\Core\User;
use App\Providers\RouteServiceProvider;
use App\Utils\Whiltelist;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
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
        $coreUser = User::query()->where('email', $request->get('username'))->first();

        if ($coreUser && checkDjangoPassword($request->get('password'), $coreUser->password)) {
            if (!\App\Models\User::query()->where('username', $coreUser->email)->exists()) {
                $communityUser = new \App\Models\User();
                $communityUser->email = $coreUser->email;
                $communityUser->username = $coreUser->email;
                $communityUser->type = $this->getUserRole($coreUser->email);
                $communityUser->password = bcrypt($request->get('password'));
                $communityUser->name = $this->getName($coreUser);
                $communityUser->email_verified_at = now();
                $communityUser->remember_token = Str::random(10);
                $communityUser->bio = '';
                $communityUser->github_username = null;
                $communityUser->github_id = null;
                $communityUser->save();
            }
        }

        if (Auth::attempt($request->only('username', 'password'), $request->boolean('remember'))) {
            if ($request->hasSession()) {
                $request->session()->put('auth.password_confirmed_at', time());
            }

            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    private function getName(User $user): string
    {
        return sprintf('%s %s', $user->first_name, $user->last_name);
    }

    private function getUserRole(string $email): int
    {
        if (str_ends_with($email, '@crossjobs.co')) {
            return \App\Models\User::ADMIN;
        }

        if (in_array($email, Whiltelist::ALL_ADMINS)) {
            return \App\Models\User::ADMIN;
        }

        return \App\Models\User::DEFAULT;
    }
}
