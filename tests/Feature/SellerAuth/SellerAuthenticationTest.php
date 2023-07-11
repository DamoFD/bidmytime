<?php

namespace Tests\Feature\SellerAuth;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class SellerAuthenticationTest extends TestCase
{

    use DatabaseMigrations;
    /**
     * A basic feature test example.
     */
    public function test_seller_login_screen_can_be_rendered(): void
    {
        $this
            ->get(route('seller.login'))
            ->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('SellerAuth/Login')
                    ->where('errors', [])
            );
    }
}
