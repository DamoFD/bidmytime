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
            'day_of_week' => 1,
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
            'start_time' => '9:00 am',
            'end_time' => '10:00 am',
            'amount' => 27.25,
        ]);
    }
    /**
     * A basic feature test example.
     */
    public function test_show_bids_view(): void
    {
        $this
            ->get(route('bids.show', ['sellers_id' => $this->seller->id, 'bid_date' => '2024-07-01', 'start_time' => '9:00 am', 'end_time' => '10:00 am']))
            ->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Bids/Show')
                    ->where('errors', [])
            );
    }

    public function test_404_if_date_not_available(): void
    {
        $this
            ->get(route('bids.show', ['sellers_id' => $this->seller->id, 'bid_date' => '2024-07-02', 'start_time' => '9:00 am', 'end_time' => '10:00 am']))
            ->assertStatus(404);
    }

    public function test_show_bid_data(): void
    {
        $this
            ->get(route('bids.show', ['sellers_id' => $this->seller->id, 'bid_date' => '2024-07-01', 'start_time' => '9:00 am', 'end_time' => '10:00 am']))
            ->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Bids/Show')
                    ->where('bids.0.amount', $this->bid->amount)
            );
    }



}
