<?php
namespace App\Http\Controllers;

use Illuminate\Support\Str;

class CommandController extends Controller
{
    const MESSAGE_OPTIONS = 'messageOptions';

    public function generate_uuid()
    {
        return Str::uuid();
    }

    public function login()
    {
        $message = request()->json()->all();

        if (array_key_exists(self::MESSAGE_OPTIONS, $message) && array_key_exists('request_uuid', $message[self::MESSAGE_OPTIONS])) {
            if (array_key_exists('data', $message) && array_key_exists('password', $message['data'])) {
                $response = [
                    'data' => 'Hello'
                ];
            } else {
                $response = [
                    'data' => 'Command requires <password>'
                ];
            }
            return $response;
        }

        if (array_key_exists('data', $message) && array_key_exists('username', $message['data'])) {
            return [
                'data' => '',
                self::MESSAGE_OPTIONS => [
                    'request_uuid' => $this->generate_uuid(),
                    'info' => 'Password for ' . $message['data']['username'] . ':',
                    'type' => 'password'
                ]
            ];
        }

        return [
            'data' => 'Login requires <username>'
        ];
    }
}