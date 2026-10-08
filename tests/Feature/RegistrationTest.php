<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_registration_creates_and_authenticates_a_cashier_account(): void
    {
        $response = $this->post(route('register.store'), [
            'name' => 'Rina Kasir',
            'email' => 'rina@example.com',
            'password' => 'rahasia123',
            'password_confirmation' => 'rahasia123',
        ]);

        $user = User::where('email', 'rina@example.com')->firstOrFail();

        $response->assertRedirect(route('kasir'));
        $this->assertAuthenticatedAs($user);
        $this->assertSame('kasir', $user->role);
        $this->assertTrue(Hash::check('rahasia123', $user->password));
    }

    public function test_registration_requires_a_unique_email_and_confirmed_password(): void
    {
        User::factory()->create(['email' => 'rina@example.com']);

        $this->post(route('register.store'), [
            'name' => 'Rina Kasir',
            'email' => 'rina@example.com',
            'password' => 'short',
            'password_confirmation' => 'different',
        ])->assertSessionHasErrors(['email', 'password']);

        $this->assertDatabaseCount('users', 1);
    }

    public function test_admin_cannot_be_created_through_public_registration(): void
    {
        $this->post(route('register.store'), [
            'name' => 'Akun Baru',
            'email' => 'baru@example.com',
            'role' => 'admin',
            'password' => 'rahasia123',
            'password_confirmation' => 'rahasia123',
        ])->assertRedirect(route('kasir'));

        $this->assertDatabaseHas('users', [
            'email' => 'baru@example.com',
            'role' => 'kasir',
        ]);
    }
}
