<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectToProvider( $provider ) {

        return Socialite::driver( $provider )->redirect();
    }

    public function handleProviderCallback( $provider ) {
        try {
            if ( $provider != 'facebook' ) {
                $user = Socialite::driver( $provider )->user();
            } else {
                $user = Socialite::driver( $provider )->fields(
                    [
                        'id',
                        'name',
                        'first_name',
                        'last_name',
                        'email',
                        
                    ]
                )->user();
            }

        } catch ( \Exception $e ) {
            return redirect()->to( '/login' );
        }
        
        
        $authUser = $this->findOrCreateUser( $user, $provider );
            
        // if ($authUser->verified != 1){
        //     return redirect()->to( 'vertification' );

        // }
        // else
            auth()->login( $authUser, true );
            return redirect()->to( '/' );
    }

    private function findOrCreateUser( $socialLiteUser, $key ) {
        $email = $key != 'facebook' ? $socialLiteUser->email : $socialLiteUser->user['email'];

        if ( $authUser = User::where( 'email', $email )->first() ) {
            return $authUser;
        }
            

        return User::create( [
            'first_name'  => $key != 'facebook' ? $socialLiteUser->user['name'] : $socialLiteUser->user['first_name'],
            'last_name'   => $key != 'facebook' ? $socialLiteUser->user['name'] : $socialLiteUser->user['last_name'],
            'email'       => $key != 'facebook' ? $socialLiteUser->email : $socialLiteUser->user['email'],
            'password'    => bcrypt( str_random( 10 ) ),
            'provider'    => $key,
            'remember_token' => base64_encode($key != 'facebook' ? $socialLiteUser->email : $socialLiteUser->user['email']),
            'verified'    => 1,
            'provider_id' => $key != 'facebook' ? $socialLiteUser->id : $socialLiteUser->user['id'],
            'user_name'   => $key != 'facebook' ? $socialLiteUser->name : $socialLiteUser->user['name'],
        ] );

    }

    protected function authenticated(Request $request, $user)
    {
        // dd($request);
        if ( $user->hasRole('admin') ) {
            return redirect()->route('admin.index');
        }
        elseif ( $user->hasRole('vendor') ) {
           if(isset($request->nasvendor) == "nasvendor"){
               
                return redirect('vendors');
                
            }else{
                return redirect()->route('seller.login');
            }
        }
        else {
            //
        }
    }


}
