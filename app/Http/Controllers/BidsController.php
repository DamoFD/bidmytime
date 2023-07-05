<?php

namespace App\Http\Controllers;

use App\Models\Bids;
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($sellers_id, $bid_date, $start_time, $end_time)
    {
        $bids = Bids::with('seller')
            ->where('sellers_id', $sellers_id)
            ->where('bid_date', $bid_date)
            ->where('start_time', $start_time)
            ->where('end_time', $end_time)
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('Bids/Show', [
            'bids' => $bids
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
