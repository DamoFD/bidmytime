<?php

namespace Tests\Feature\Sellers;

use App\Models\Sellers;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShowSellerTest extends TestCase
{

    use DatabaseMigrations;
    /**
     * A basic feature test example.
     */
    public function test_show_seller_page(): void
    {
        $seller = Sellers::factory()->create();
        $response = $this->get('/sellers/'. $seller->id);

        $response->assertStatus(200);
    }
}
