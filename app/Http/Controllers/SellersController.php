<?php

namespace App\Http\Controllers;

use App\Models\Sellers;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SellersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sellers = Sellers::all();

        return Inertia::render('Sellers/Index', [
           'sellers' => $sellers
        ]);
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
    public function show($id)
    {
        $seller = Sellers::with(['availableWeekdays', 'availableWeekdays.availableTimes'])->findOrFail($id);

        return Inertia::render('Sellers/Show', [
            'seller' => $seller,
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sellers $sellers)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sellers $sellers)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sellers $sellers)
    {
        //
    }
}
