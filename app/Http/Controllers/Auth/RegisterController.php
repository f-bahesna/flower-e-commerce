<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Exception;
use Redirect;
use Auth;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        // $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    // protected function validator(array $data)
    // {
    //     return Validator::make($data, [
    //         'name' => ['required', 'string', 'max:255'],
    //         'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
    //         'password' => ['required', 'string', 'min:8', 'confirmed'],
    //         'nomor_telepon' => ['required', 'integer', 'min:15', 'confirmed'],
    //     ]);
    // }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    // protected function create(array $data)
    // {
    //     try {
    //         return User::create([
    //             'name' => $data['name'],
    //             'email' => $data['email'],
    //             'password' => Hash::make($data['password']),
    //             'nomor_telepon' => $data['nomor_telepon'],
    //         ]);
    //     } catch (\Exception $th) {
    //         dd($th);
    //     }

    // }
    protected function userRegister(Request $request)
    {
        $this->middleware('guest');

        try {
            $this->validate($request , [
                'name' => 'required', 'string', 'max:255',
                'email' => 'required', 'string', 'email', 'max:255', 'unique:users',
                'password' => 'required', 'string', 'min:8', 'confirmed',
                'password_confirmation' => 'required', 'string', 'min:8', 'confirmed',
                'nomor_telepon' => 'required', 'integer', 'min:15', 'confirmed',
            ]);
            
        if($request["password"] != $request["password_confirmation"]){
            return Redirect::back()->withErrors(['msg', 'Password Tidak Sama']);
        }else{
            $id = User::insertGetId([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'nomor_telepon' => $request['nomor_telepon'],
            ]);

            Auth::loginUsingId($id);
    
            return redirect()->route('home-page');
        }

        } catch (\Exception $e) {
            dd($e);
            return redirect()->route('register')->with('error', 'your message,here');  
        }
   
    }

    public function userLogout()
    {
        Auth::logout();
        return redirect('/');
    }
}
