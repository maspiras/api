<?php

namespace App\Http\Controllers\Reservation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\ReservationRepository;

class ReservationController extends Controller
{
    var $r, $reservationRepository;
    public function __construct(Request $r, ReservationRepository $reservationRepository)
    {
        $this->r = $r;
        $this->reservationRepository = $reservationRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /* return response()->json([
            'result' => 'All Reservations',
        ]); */
        return response()->json([
            'status' => 1,
            'message' => 'Reservations fetched successfully',
            'data' => [
                'checkinToday' => $this->reservationRepository->getTodaysCheckin($this->r),
                'checkoutToday' => $this->reservationRepository->getTodaysCheckout($this->r),
                'currentlyHosting' => $this->reservationRepository->getCurrentlyHosting($this->r),
            ],
        ], 200);
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
        return response()->json([
            'result' => 'Store Reservation',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json([
            'result' => 'Show Reservation',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return response()->json([
            'result' => 'Update Reservation',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return response()->json([
            'result' => 'Delete Reservation',
        ]);
    }
}
