<?php

namespace Tests\Feature\Sellers;

use App\Models\Sellers;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShowSellerTest extends TestCase
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
    public function test_show_seller_page(): void
    {
        $response = $this->get("/sellers/{$this->seller->id}");

        $response->assertStatus(200);
    }

    public function test_show_seller_name_on_page(): void
    {
        $response = $this->get("/sellers/{$this->seller->id}");

        $response->assertSee($this->seller->name);
    }
}
