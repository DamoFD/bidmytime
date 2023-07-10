<?php

namespace Tests\Feature\Bids;

use App\Models\AvailableTimes;
use App\Models\AvailableWeekdays;
use App\Models\Bids;
use App\Models\Sellers;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class ShowBidsTest extends TestCase
{
    use DatabaseMigrations;

    private $seller;
    private $availableWeekday;
    private $availableTime;
    private $user;
    private $bid;

    public function setUp(): void
    {
        parent::setUp();
        $this->seller = Sellers::factory()->create();
        $this->availableWeekday = AvailableWeekdays::create([
            'sellers_id' => $this->seller->id,
            'day_of_week' => 2,
        ]);
        $this->availableTime = AvailableTimes::create([
            'available_weekdays_id' => $this->availableWeekday->id,
            'start_time' => '09:00:00',
            'end_time' => '10:00:00',
        ]);
        $this->user = User::factory()->create();
        $this->bid = Bids::create([
            'user_id' => $this->user->id,
            'sellers_id' => $this->seller->id,
            'bid_date' => '2024-07-01',
            'start_time' => '09:00:00',
            'end_time' => '10:00:00',
            'amount' => 27.25,
        ]);
    }
    /**
     * A basic feature test example.
     */
    public function test_show_bids_view(): void
    {

        $response = $this->get("/bids/{$this->seller->id}/2024-07-01/9%3A00 am/10%3A00 am" );

        $response->assertStatus(200);
    }

    public function test_404_if_time_not_available(): void
    {
        $response = $this->get("/bids/{$this->seller->id}/2024-07-02/9%3A00 am/10%3A00 am" );

        $response->assertStatus(404);
    }

    public function test_show_bid_data(): void
    {
        $bid = Bids::create([
            'user_id' => $this->user->id,
            'sellers_id' => $this->seller->id,
            'bid_date' => '2024-07-01',
            'start_time' => '9:00 am',
            'end_time' => '10:00 am',
            'amount' => 27.25,
        ]);

        $response = $this->get("/bids/{$this->seller->id}/2024-07-01/9%3A00 am/10%3A00 am" );

        $response->assertSee($bid->amount);
    }



}
