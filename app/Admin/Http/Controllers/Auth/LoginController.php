<?php

namespace App\Admin\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Session;
use App\Models\Role;

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
    protected $redirectTo = '/admin/dashboard';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }


    /**
     * Log the user out of the application.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->flush();

        $request->session()->regenerate();

        return redirect('/');
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        //add user to session
        Session::put('user',$user->toArray());

        //add language to the session
        $repo = '\\App\\Admin\\Repositories\\LanguageRepository';
        $language_repo = new $repo();

        //get the users language
        $user_language = $language_repo->userLanguage($user);

        //set language id according to user language setting for admin(cms) translations
        Session::put('language.user_lang_id',$user_language->id);

        //set the locale according to user language setting
        \App::setLocale($user_language->abbr);

        //set the default translation language from the existing session or else from the language table
        $lang = Session::get('language.default_id');
        if(!isset($lang)){
            $default_language = $language_repo->defaultLanguage();
            Session::put('language.default_id',$default_language->id);
            Session::put('language.default_abbr',$default_language->abbr);
        }

        //put the active translation languages to the session
        $active_languages = $language_repo->activeLanguages();
        if(count($active_languages)){
            Session::put('language.active',$active_languages);
        }else{
            Session::put('language.active',[]);
        }

        //add role to the session
        $role = Role::find($user->role_id);
        $permissions = [];
        foreach($role->menuItems as $item){
            $permissions[] = $item->url;
        }
        Session::put('role',$role->toArray());
        Session::put('role.permissions',$permissions);

    }

}
