<?php

namespace App\Http\Controllers;

use App\Models\AvailableWeekdays;
use App\Models\Bids;
use App\Models\Sellers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class BidsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'sellers_id' => 'required|integer|exists:sellers,id',
            'date' => 'required|date',
            'startTime' => 'required|string',
            'endTime' => 'required|string',
        ]);

        $seller = Sellers::find($request->sellers_id);

        if (!$seller) {
            return back()->withErrors(['sellers_id' => 'Seller not found.']);
        }

        // Extract the day of the week from the date (Monday = 1, Sunday = 7)
        $dayOfWeek = date('w', strtotime($request->date)) + 1;

        $weekday = $seller->availableWeekdays->firstWhere('day_of_week', $dayOfWeek);

        if (!$weekday) {
            return back()->withErrors(['date' => 'This date is not available for this seller.']);
        }

        $startTimeExists = $weekday->availableTimes->contains('start_time', $request->startTime);
        $endTimeExists = $weekday->availableTimes->contains('end_time', $request->endTime);

        if (!$startTimeExists || !$endTimeExists) {
            return back()->withErrors(['date' => 'This timeslot is not available for this seller.']);
        }

        // Check if the bid amount is greater than the highest bid for the time slot
        $highestBid = Bids::where('sellers_id', $request->sellers_id)
            ->where('bid_date', $request->date)
            ->where('start_time', $request->startTime)
            ->where('end_time', $request->endTime)
            ->max('amount');

        if ($request->amount <= $highestBid) {
            return back()->withErrors(['amount' => 'Bid amount must be greater than the current highest bid.']);
        }

        // Check if the time slot has an exception
        $exception = $seller->availableExceptions->where('sellers_id', $request->sellers_id)
            ->where('date', $request->date)
            ->where('start_time', $request->startTime)
            ->where('end_time', $request->endTime)
            ->first();

        if ($exception) {
            return back()->withErrors(['date' => 'This time slot is not available for this seller.']);
        }

        // If all validations pass, create the bid
        $bids = new Bids;
        $bids->amount = $request->amount;
        $bids->user_id = auth()->user()->id;
        $bids->sellers_id = $request->sellers_id;
        $bids->bid_date = $request->date;
        $bids->start_time = $request->startTime;
        $bids->end_time = $request->endTime;
        $bids->save();
        return back()->with('success', 'Bid successfully created.');
    }

    /**
     * Display the specified resource.
     */
    public function show($sellers_id, $bid_date, $start_time, $end_time)
    {

        $seller = Sellers::findOrFail($sellers_id);

        // Check if time slot exists

        // Extract the day of the week from the date (Monday = 1, Sunday = 7)
        $formatted_date = Carbon::parse($bid_date);
        $weekday = $formatted_date->dayOfWeek + 1;
        $availableWeekday = AvailableWeekdays::where('sellers_id', $sellers_id)
            ->where('day_of_week', $weekday)
            ->first();

        if (!$availableWeekday) {
            abort(404);
        }

        // get bids that match parameters
        $bids = Bids::with('user')
            ->where('sellers_id', $sellers_id)
            ->where('bid_date', $bid_date)
            ->where('start_time', $start_time)
            ->where('end_time', $end_time)
            ->orderBy('amount', 'desc')
            ->get();

        return Inertia::render('Bids/Show', [
            'bids' => $bids,
            'seller' => $seller,
            'selectedDate' => $bid_date,
            'startTime' => urldecode($start_time),
            'endTime' => urldecode($end_time),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bids $bids)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bids $bids)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bids $bids)
    {
        //
    }
}
