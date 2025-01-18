<?php

namespace App\Repositories;
use App\Models\Service;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\LazyCollection;
use Illuminate\Support\Collection;

class ReservedServiceRepository extends BaseRepository
{
    protected $model;
    
    public function __construct()
    {
        $this->model = DB::table('reserved_services');
    }

    public function getMyReservedServices($id){       
        return $this->model->distinct()->select(['reserved_services.reservation_id', 'reserved_services.host_id', 'reserved_services.user_id', 'reserved_services.service_id', 'services.service_name','reserved_services.amount', 'reserved_services.paymentstatus'])
            ->leftJoin('services', 'reserved_services.service_id', '=', 'services.id')
            ->where('reservation_id', '=', $id)
            ->get();
        
    }

    public function updateMyReservedServices($reservation_id, $data){     
        $this->model->where('reservation_id', '=', $reservation_id)->delete();        
        /* $this->model->where('reservation_id', '=', $reservation_id)->chunkById(1000, function ($reservedrooms) {
            //go through the collection and delete every post.
            foreach($reservedrooms as $r) {
                $r->delete();
            }
        }); */
        
        $this->model->insert($data);
    }

}
