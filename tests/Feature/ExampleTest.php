<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login_from_home(): void
    {
        $response = $this->get('/');
        $response->assertRedirect(route('login'));
    }

    public function test_login_page_renders_successfully(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('Cafe RJ');
    }

    public function test_authenticated_user_can_access_pos(): void
    {
        $user = User::factory()->create([
            'role' => 'kasir',
        ]);

        $response = $this->actingAs($user)->get('/pos');
        $response->assertStatus(200);
        $response->assertSee('Kasir POS');
    }
}
