<?php

namespace Tests\Feature;

use App\Models\Sellers;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia;
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
        $this
            ->actingAs($this->seller, 'seller')
            ->get(route('seller.profile.edit'))
            ->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('SellerProfile/Edit')
                    ->where('errors', [])
            );
    }

    public function test_seller_profile_page_is_not_displayed_when_not_logged_in(): void
    {
        $this
            ->get(route('seller.profile.edit'))
            ->assertRedirect(route('seller.login'));
    }

    public function test_seller_dashboard_page_is_not_displayed_when_not_logged_in(): void
    {
        $this
            ->get(route('seller.dashboard'))
            ->assertRedirect(route('seller.login'));
    }

    public function test_seller_cannot_view_user_dashboard(): void
    {
        $this
            ->actingAs($this->seller, 'seller')
            ->get(route('dashboard'))
            ->assertRedirect(RouteServiceProvider::SELLERHOME);
    }

    public function test_seller_cannot_view_user_profile(): void
    {
        $this
            ->actingAs($this->seller, 'seller')
            ->get(route('profile.edit'))
            ->assertRedirect(RouteServiceProvider::SELLERHOME);
    }

    public function test_seller_cannot_view_user_login(): void
    {
        $this
            ->actingAs($this->seller, 'seller')
            ->get(route('login'))
            ->assertRedirect(RouteServiceProvider::SELLERHOME);
    }

    public function test_seller_cannot_view_user_registration(): void
    {
        $this
            ->actingAs($this->seller, 'seller')
            ->get(route('register'))
            ->assertRedirect(RouteServiceProvider::SELLERHOME);
    }

}
