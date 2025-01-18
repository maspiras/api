<?php

namespace App\Repositories;

use App\Models\Reservation;
use Illuminate\Support\Facades\DB;

class ReservationRepository extends BaseRepository
{
    #protected $model = Reservation::class;
    /* public function __construct()
    {
        $this->model = $model;
    } */
    protected $model;
    /* public function __construct(Reservation $model)
    {
        $this->model = $model;
    } */

    public function __construct()
    {
        $this->model = DB::table('reservations');
    }



    public function getTodaysCheckin($r)
    {
        $checkin = $this->model->select(['reservations.id as reservation_id', 'reservations.ref_number', 'reservations.checkin', 'reservations.fullname', 'reservations.checkout', 'reservations.payment_status_id as payment_status', 'reserved_rooms.room_id as room_id', 'rooms.room_name'])
            ->leftJoin('reserved_rooms', 'reservations.id', '=', 'reserved_rooms.reservation_id')
            ->leftJoin('rooms', 'reserved_rooms.room_id', '=', 'rooms.id')
            ->where('reservations.host_id', '=', $r->host_id)
            ->where('booking_status_id', '!=', 2)
            ->whereDate('reservations.checkin', '=', now()->today())
            ->groupBy('reserved_rooms.room_id')
            ->get();
        #->whereRaw('checkin = now()->today()')->get();
        return $checkin;
        //return now()->today(); 
        //return $r->host_id;
    }

    public function getTodaysCheckout($r)
    {
        $checkout = DB::table('reservations')->select(['reservations.id as reservation_id', 'reservations.ref_number', 'reservations.checkin', 'reservations.fullname', 'reservations.checkout', 'reservations.payment_status_id as payment_status', 'reserved_rooms.room_id as room_id', 'rooms.room_name'])
            ->leftJoin('reserved_rooms', 'reservations.id', '=', 'reserved_rooms.reservation_id')
            ->leftJoin('rooms', 'reserved_rooms.room_id', '=', 'rooms.id')
            ->where('reservations.host_id', '=', $r->host_id)
            ->where('booking_status_id', '!=', 2)
            ->whereDate('reservations.checkout', '=', now()->today())
            ->groupBy('reserved_rooms.room_id')
            ->get();
        #->whereRaw('checkin = now()->today()')->get();
        return $checkout;
        //return now()->today();      
    }

    public function getCurrentlyHosting($r)
    {
        $current = DB::table('reservations')->select(['reservations.id as reservation_id', 'reservations.ref_number', 'reservations.checkin as checkin', 'reservations.fullname', 'reservations.checkout as checkout', 'reservations.payment_status_id as payment_status', 'reserved_rooms.room_id as room_id', 'rooms.room_name'])
            ->leftJoin('reserved_rooms', 'reservations.id', '=', 'reserved_rooms.reservation_id')
            ->leftJoin('rooms', 'reserved_rooms.room_id', '=', 'rooms.id')
            ->where('reservations.host_id', '=', $r->host_id)
            ->where('booking_status_id', '!=', 2)
            ->whereDate('reserved_rooms.reserved_dates', '=', now()->today())
            ->groupBy('reserved_rooms.room_id')
            ->get();
        #->whereRaw('checkin = now()->today()')->get();
        return $current;
    }

    public function getRecentReservation($r)
    {
        $recentreservation = DB::table('reservations')->select(['reservations.id as reservation_id', 'reservations.ref_number', 'reservations.checkin', 'reservations.fullname', 'reservations.checkout', 'reservations.payment_status_id as payment_status'])
            ->where('reservations.host_id', '=', $r->host_id)
            ->where('booking_status_id', '!=', 2)
            ->orderByDesc('id')
            ->limit(10)
            ->get();
        #->whereRaw('checkin = now()->today()')->get();
        return $recentreservation;
    }
}
