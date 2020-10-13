<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\EmailVerification;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_name' => 'required|string|max:25|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|numeric|min:9',
            'password' => 'confirmed|required| min:5 |max:30',
            'password_confirmation' => 'required| min:5 |max:30',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()], Response::HTTP_NOT_ACCEPTABLE);
        }

        $user = new User();
        $user->user_name = $request->user_name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->verified = 0;
        $user->password = bcrypt($request->password);
        $user->token = base64_encode($request->email);
        $user->save();

        $user->referral_code()->create([
            'user_id' => $user->id,
            'referal_code'=>$user->user_name.rand(0,9).rand(0,9).rand(0,9)
        ]);
        $user->wallets()->create([
            'user_id' => $user->id,
            'amount'=>0
        ]);

        $data = [
            'email_token' => $user->token
        ];

        Mail::to($request->email)->send(new EmailVerification($data));

        $http = new Client;

        $response = $http->post(url('/oauth/token'), [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => '2',
                'client_secret' => 'G9JFskOl0LOHLVmjX0A7Ylvhnxxyer4KwtAfFb7t',
                'username' => $request->email,
                'password' => $request->password,
                'scope' => '',
            ],
        ]);

        return response(['data' => json_decode((string) $response->getBody(), true)]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string',
            'password' => 'required|string'
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()], Response::HTTP_NOT_ACCEPTABLE);
        }

        $user = User::where('email', $request->email)->first();

        if(!$user)
        {
            return response(['status' => 'error', 'message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        if (Hash::check($request->password, $user->password)) {

            $client = new Client(['base_uri' => url('/'), 'timeout' => 10.0]);

            $response = $client->request('POST', '/oauth/token', [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => '2',
                    'client_secret' => 'G9JFskOl0LOHLVmjX0A7Ylvhnxxyer4KwtAfFb7t',
                    'username' => $request->email,
                    'password' => $request->password,
                    'scope' => '',
                ],
            ]);

            return response(['data' => json_decode((string) $response->getBody(), true)]);
        }
        else {
            return response()->json(['status' => 'error', 'message' => 'Password is incorrect!'], Response::HTTP_UNAUTHORIZED);
        }
    }

    public function verifyUser()
    {
        $user = Auth::user();
        return response()->json(['verified' => $user->verified], Response::HTTP_OK);
    }

    public function registerSocial(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'provider_id' => 'required',
            'user_name' => ['required', Rule::unique('users')->ignore($request->provider_id, 'provider_id')],
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => ['required', Rule::unique('users')->ignore($request->provider_id, 'provider_id')],
            'provider' => 'required',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()], Response::HTTP_NOT_ACCEPTABLE);
        }

        $user = User::where('email', $request->email)->where('provider_id', $request->provider_id)->first();
        if (empty($user)) 
        {
            $user = new User();
            $user->user_name = $request->user_name;
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->provider = $request->provider;
            $user->provider_id = $request->provider_id;
            $user->verified = 1;
            $user->password = bcrypt( $request->email );
            $user->remember_token = base64_encode($request->email);
            $user->save();
        }

        $client = new Client(['base_uri' => url('/'), 'timeout' => 10.0]);

        $response = $client->request('POST', '/oauth/token', [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => '2',
                'client_secret' => 'G9JFskOl0LOHLVmjX0A7Ylvhnxxyer4KwtAfFb7t',
                'username' => $user->email,
                'password' => $user->email,
                'scope' => '',
            ],
        ]);

        return response(['data' => json_decode((string) $response->getBody(), true)]);

    }
}
