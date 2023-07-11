<?php

namespace Tests\Feature\Sellers;

use App\Models\Sellers;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia;
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
    public function test_show_seller_page_with_props(): void
    {
        $this
            ->get(route('sellers.show', $this->seller->id))
            ->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Sellers/Show')
                    ->where('seller.name', $this->seller->name)
            );
    }
}
