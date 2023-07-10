<?php

namespace Tests\Feature\SellerAuth;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SellerAuthenticationTest extends TestCase
{

    use DatabaseMigrations;
    /**
     * A basic feature test example.
     */
    public function test_seller_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/seller/login');

        $response->assertStatus(200);
    }
}
