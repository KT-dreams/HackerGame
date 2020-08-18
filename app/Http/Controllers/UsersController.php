<?php
namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;

class UsersController extends Controller
{
    const LOGIN_MAPPING = [
        'firstStep'  => 'loginStepGetLogin',
        'password' => 'loginStepGetPassword',
    ];

    public function login()
    {
        return $this->stepController(self::LOGIN_MAPPING);
    }
    
    public function stepController($mapping)
    {
        if(!$context = $this->getContext())
        {
            return call_user_func(array($this, $mapping['firstStep']));
        }
        
        if($mapping[$context['commandStep']] ?? false)
        {
            return call_user_func(array($this, $mapping[$context['commandStep']]), $context);
        }
        
        return ['data' => 'Incorrect data'];
    }
    
    public function loginStepGetLogin()
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
            'requestUuid' => $uuid,
            'commandStep'=>'password',
            'username' => request('data.username')
        ];
        
        Cache::put('requests', $cachedRequests);
        
        return [
            'data' => '',
            'messageOptions' => [
                'requestUuid' => $uuid,
                'info' => 'Password for ' . request('data.username') . ':',
                'type' => 'password'
            ]
        ];
    }
    
    private function loginStepGetPassword($context=[])
    {
        if(!$this->validateRequest(['data.password'=>'required']))
        {
            return [
                'data' => 'Command requires <password>'
            ];
        }
        
        $user = User::where('username', $context['username'])->first();
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
}