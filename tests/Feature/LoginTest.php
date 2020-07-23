<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Http\Controllers\CommandController;

class ApiTest extends TestCase
{

    use RefreshDatabase;

    const COMMAND_LOGIN = 'commandLogin';
    const MESSAGE_OPTIONS = 'messageOptions';
    const REQUEST_UUID = 'request_uuid';
    const UUID = 'abcd-dddd-eeee-aaaa-xyzz';

    /** @test */
    public function user_can_run_login_command()
    {
        $this->mockUuid();
        $this->json('POST', route(self::COMMAND_LOGIN), [
            'data' => [
                'username' => 'TestUser'
            ]
        ])
            ->assertJson([
            'data' => '',
            self::MESSAGE_OPTIONS => [
                self::REQUEST_UUID => self::UUID,
                'info' => 'Password for TestUser:',
                'type' => 'password'
            ]
        ])
            ->assertStatus(200);
    }

    /** @test */
    public function username_is_required()
    {
        $this->json('POST', route(self::COMMAND_LOGIN))
            ->assertJson([
            'data' => 'Login requires <username>'
        ])
            ->assertJsonMissing([
            'data' => 'username'
        ])
            ->assertStatus(200);
    }

    /** @test */
    public function user_can_enter_password()
    {
        $this->json('POST', route(self::COMMAND_LOGIN), [
            self::MESSAGE_OPTIONS => [
                self::REQUEST_UUID => self::UUID
            ],
            'data' => [
                'password' => 'qwerty'
            ]
        ])
            ->assertJson([
            'data' => 'Hello'
        ])
            ->assertStatus(200);
    }

    /** @test */
    public function password_is_required()
    {
        $this->json('POST', route(self::COMMAND_LOGIN), [
            self::MESSAGE_OPTIONS => [
                self::REQUEST_UUID => self::UUID
            ]
        ])
            ->assertJson([
            'data' => 'Command requires <password>'
        ])
            ->assertStatus(200);
    }

    public function mockUuid()
    {
        return $this->partialMock(CommandController::class, function ($mock) {
            $mock->shouldReceive('process')
                ->shouldReceive('uuid')
                ->andReturn(self::UUID);
        });
    }
}
