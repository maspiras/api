<?php

namespace App\Repositories;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\LazyCollection;

class PaymentRepository extends BaseRepository
{
    protected $model;
    
    public function __construct()
    {
        $this->model = DB::table('payments');
    }

    public function myPayments($reservation_id){
        $data = $this->model->where('reservation_id', $reservation_id)
                ->orderBy('id', 'desc')->get();
        return $data;
    }

    
}
