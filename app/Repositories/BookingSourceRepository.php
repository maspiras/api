<?php

namespace App\Repositories;
use App\Models\Service;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\LazyCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class BookingSourceRepository extends BaseRepository
{
    protected $model;
    
    public function __construct()
    {
        $this->model = DB::table('booking_sources');
    }

    public function getBookingSources(){        
        $cache_keyword = 'booking_sources';	
		$data = cache($cache_keyword);        
		if(is_null($data)){	
            $data = $this->model->orderBy('source_name')->get();
		    #cache([$cache_keyword => $data], now()->addYear()); 
            Cache::forever($cache_keyword, $data);
		}
		return $data;

    }
}
