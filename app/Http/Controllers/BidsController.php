<?php

namespace App\Http\Controllers;

use App\Models\Bids;
use App\Models\Sellers;
use Illuminate\Http\Request;
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
            dd('seller not found');
            return back()->withErrors(['sellers_id' => 'Seller not found.']);
        }

        // Extract the day of the week from the date (Monday = 1, Sunday = 7)
        $dayOfWeek = date('N', strtotime($request->date));

        $weekday = $seller->availableWeekdays->firstWhere('day_of_week', $dayOfWeek);

        if (!$weekday) {
            dd('weekday not found');
            return back()->withErrors(['date' => 'Date not found.']);
        }

        $startTimeExists = $weekday->availableTimes->contains('start_time', $request->startTime);
        $endTimeExists = $weekday->availableTimes->contains('end_time', $request->endTime);

        if (!$startTimeExists || !$endTimeExists) {
            dd('start time or end time not found');
            return back()->withErrors(['date' => 'Invalid start time or end time.']);
        }

        // Check if the bid amount is greater than the highest bid for the time slot
        $highestBid = Bids::where('sellers_id', $request->sellers_id)
            ->where('bid_date', $request->date)
            ->where('start_time', $request->startTime)
            ->where('end_time', $request->endTime)
            ->max('amount');

        if ($request->amount <= $highestBid) {
            dd('bid amount must be greater than the current highest bid.');
            return back()->withErrors(['amount' => 'Bid amount must be greater than the current highest bid.']);
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
        dd('Bid successfully created.');
        return back()->with('success', 'Bid successfully created.');
    }

    /**
     * Display the specified resource.
     */
    public function show($sellers_id, $bid_date, $start_time, $end_time)
    {
        $bids = Bids::with('seller', 'user')
            ->where('sellers_id', $sellers_id)
            ->where('bid_date', $bid_date)
            ->where('start_time', $start_time)
            ->where('end_time', $end_time)
            ->orderBy('amount', 'desc')
            ->get();

        return Inertia::render('Bids/Show', [
            'bids' => $bids,
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
