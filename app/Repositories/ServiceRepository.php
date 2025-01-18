<?php

namespace App\Repositories;
use App\Models\Service;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\LazyCollection;
use Illuminate\Support\Collection;

class ServiceRepository extends BaseRepository
{
    protected $model;
    
    public function __construct()
    {
        $this->model = DB::table('services');
    }

    public function getServices($host_id){
       
        $services =  $this->model->where('host_id', $host_id)            
                ->orderBy('service_name')
                ->get();#->chunk(2);
        return $this->toArr($services);
    }

    

    
}
