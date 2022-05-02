<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\UserRequest;
use App\Enums\RequestStatus;
use Laravel\Sanctum\Sanctum;
use Illuminate\Http\Response;

class MakerCheckerTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    protected $admin;

    protected function setUp() :void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
        $this->admin->assignRole('admin');

        Sanctum::actingAs(
            $this->admin,
            ['*']
        );
    }

    public function test_that_user_can_login()
    {
        $payload = [
            "email" => "admin00@sample.test",
            "password" => "glover1234"
        ];

        $response = $this->post('/api/auth/login', $payload);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_that_validation_error_is_returned_if_a_parameter_is_not_supplied_when_creating_request()
    {
        $payload = [
            'firstname' => 'Ridwan',
            'lastname' => 'Adedotun',
            'email' => ''
        ];

        $response = $this->post('/api/admin/create-user-request', $payload);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_that_user_request_is_created_successfully()
    {
        $payload = [
            'firstname' => 'Ridwan',
            'lastname' => 'Adedotun',
            'email' => 'adedotun@gmail.com'
        ];

        $response = $this->post('/api/admin/create-user-request', $payload);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_that_user_update_request_is_created_successfully()
    {
        $payload = [
            'firstname' => 'Ridwan',
            'lastname' => 'Adedotun',
            'email' => 'adedotun@gmail.com',
            'user_id' => 2
        ];

        $response = $this->post('/api/admin/update-user-request', $payload);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_that_user_delete_request_is_created_successfully()
    {
        $user_id = 2;
        $response = $this->post('/api/admin/delete-user-request/'.$user_id);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_that_pending_request_can_be_fetched()
    {
        $response = $this->get('/api/admin/fetch-pending-request');

        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_that_admin_can_approve_a_request()
    {
        $pending_request = UserRequest::whereNot('admin_id', $this->admin->id)->where('status', RequestStatus::PENDING)->first();

        $payload = [
            "request_id" => $pending_request->id,
            "action_type" => 'approve'
        ];

        $this->post('/api/admin/mark-request', $payload)->assertStatus(Response::HTTP_OK);
    }

    public function test_that_admin_can_decline_a_request()
    {
        $pending_request = UserRequest::whereNot('admin_id', $this->admin->id)->where('status', RequestStatus::PENDING)->first();

        $payload = [
            "request_id" => $pending_request->id,
            "action_type" => 'decline'
        ];

        $this->post('/api/admin/mark-request', $payload)->assertStatus(Response::HTTP_OK);
    }

}
