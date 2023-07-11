<?php

namespace Tests\Feature;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use DatabaseMigrations;

    private $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_profile_page_is_displayed(): void
    {
        $this
            ->actingAs($this->user)
            ->get(route('profile.edit'))
            ->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                ->component('Profile/Edit')
                ->where('errors', [])
            );
    }

    public function test_profile_page_is_not_displayed_when_not_logged_in(): void
    {
        $this
            ->get(route('profile.edit'))
            ->assertRedirect(route('login'));
    }

    public function test_dashboard_page_is_not_displayed_when_not_logged_in(): void
    {
        $this
            ->get(route('dashboard'))
            ->assertRedirect(route('login'));
    }

    public function test_user_cannot_view_seller_dashboard(): void
    {
        $this
            ->actingAs($this->user)
            ->get(route('seller.dashboard'))
            ->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_user_cannot_view_seller_profile(): void
    {
        $this
            ->actingAs($this->user)
            ->get(route('seller.profile.edit'))
            ->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_user_cannot_view_seller_login(): void
    {
        $this
            ->actingAs($this->user)
            ->get(route('seller.login'))
            ->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_user_cannot_view_seller_registration(): void
    {
        $this
            ->actingAs($this->user)
            ->get(route('seller.register'))
            ->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_profile_information_can_be_updated(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch('/profile', [
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $user->refresh();

        $this->assertSame('Test User', $user->name);
        $this->assertSame('test@example.com', $user->email);
        $this->assertNull($user->email_verified_at);
    }

    public function test_email_verification_status_is_unchanged_when_the_email_address_is_unchanged(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch('/profile', [
                'name' => 'Test User',
                'email' => $user->email,
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $this->assertNotNull($user->refresh()->email_verified_at);
    }

    public function test_user_can_delete_their_account(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->delete('/profile', [
                'password' => 'password',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/');

        $this->assertGuest();
        $this->assertNull($user->fresh());
    }

    public function test_correct_password_must_be_provided_to_delete_account(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/profile')
            ->delete('/profile', [
                'password' => 'wrong-password',
            ]);

        $response
            ->assertSessionHasErrors('password')
            ->assertRedirect('/profile');

        $this->assertNotNull($user->fresh());
    }
}
