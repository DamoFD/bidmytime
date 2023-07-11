<?php

namespace Tests\Feature\Sellers;

use App\Models\Sellers;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia;
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
    public function test_show_index_sellers_page_and_props(): void
    {
        $this
            ->get(route('sellers.index'))
            ->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                ->component('Sellers/Index')
                ->where('sellers.0.name', $this->seller->name)
            );
    }
}
