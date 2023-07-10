<?php

namespace Tests\Feature\Sellers;

use App\Models\Sellers;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IndexSellersTest extends TestCase
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
    public function test_show_index_sellers_page(): void
    {
        $response = $this->get('/sellers');

        $response->assertStatus(200);
    }

    public function test_show_seller_name(): void
    {
        $response = $this->get('/sellers');

        $response->assertSee($this->seller->name);
    }
}
