<?php

namespace Tests\Feature;

use App\Models\Sellers;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SellerProfileTest extends TestCase
{
    use DatabaseMigrations;
    private $seller;

    public function setUp(): void
    {
        parent::setUp();
        $this->seller = Sellers::factory()->create();
    }
    /**
     * A basic feature test example.
     */
    public function test_seller_profile_page_is_displayed(): void
    {
        $response = $this
            ->actingAs($this->seller, 'seller')
            ->get('/seller/profile');

        $response->assertStatus(200);
    }

    public function test_seller_profile_page_is_not_displayed_when_not_logged_in(): void
    {
        $response = $this->get('/seller/profile');

        $response->assertRedirect('/seller/login');
    }

    public function test_seller_dashboard_page_is_not_displayed_when_not_logged_in(): void
    {
        $response = $this->get('/seller/dashboard');

        $response->assertRedirect('/seller/login');
    }

    public function test_seller_cannot_view_user_dashboard(): void
    {
        $response = $this
            ->actingAs($this->seller, 'seller')
            ->get('/dashboard');

        $response->assertRedirect(RouteServiceProvider::SELLERHOME);
    }

    public function test_seller_cannot_view_user_profile(): void
    {
        $response = $this
            ->actingAs($this->seller, 'seller')
            ->get('/profile');

        $response->assertRedirect(RouteServiceProvider::SELLERHOME);
    }

    public function test_seller_cannot_view_user_login(): void
    {
        $response = $this
            ->actingAs($this->seller, 'seller')
            ->get('/login');

        $response->assertRedirect(RouteServiceProvider::SELLERHOME);
    }

    public function test_seller_cannot_view_user_registration(): void
    {
        $response = $this
            ->actingAs($this->seller, 'seller')
            ->get('/register');

        $response->assertRedirect(RouteServiceProvider::SELLERHOME);
    }

}
