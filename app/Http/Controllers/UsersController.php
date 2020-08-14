<?php
namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    public function login()
    {
        if(!$request = $this->requestHasValidUuid())
        {
            return $this->loginStepGetLogin();
        }
        
        if($request['command_step'] === 'password')
        {
            return $this->loginStepGetPassword($request);
        }
        
        return ['data' => 'Incorrect data'];
    }
    
    private function loginStepGetPassword($request=[])
    {
        if(!$this->validateRequest(['data.password'=>'required']))
        {
            return [
                'data' => 'Command requires <password>'
            ];
        }
        
        $user = User::where('username', $request['username'])->first();
        if(!$user)
        {
            return [
                'data' => 'Bad request!'
            ];
        }
        
        if(Hash::check(request('data.password'), $user['password']))
        {
            $response = [
                'data' => 'You are logged in!'
            ];
        }
        else
        {
            $response = [
                'data' => 'Incorrect password!'
            ];
        }
        return $response;
    }
    
    private function loginStepGetLogin()
    {
        if(!$this->validateRequest(['data.username'=>'required']))
        {
            return [
                'data' => 'Command requires <username>'
            ];
        }
        
        $uuid = $this->generateUuid();
        
        $cachedRequests = Cache::get('requests', []);
        $cachedRequests[$uuid] = [
            'request_uuid' => $uuid,
            'command_step'=>'password',
            'username' => request('data.username')
        ];
        
        Cache::put('requests', $cachedRequests);
        
        return [
            'data' => '',
            'messageOptions' => [
                'request_uuid' => $uuid,
                'info' => 'Password for ' . request('data.username') . ':',
                'type' => 'password'
            ]
        ];
    }
}