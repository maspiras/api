<?php

namespace App\Repositories;
use App\Models\Service;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\LazyCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class CurrencyRepository extends BaseRepository
{
    protected $model;
    
    public function __construct()
    {
        $this->model = DB::table('currencies');
    }

    public function getCurrencies(){        
        //Cache::forever('key', 'value');
        $cache_keyword = 'currencies';	
		$data = cache($cache_keyword);        
		if(is_null($data)){	
            $data = $this->model->orderBy('currency_code')->get();
		    #cache([$cache_keyword => $data], now()->addYear()); 
            //cache([$cache_keyword => $data])->forever(); 
            Cache::forever($cache_keyword, $data);
		}
		return $data;

    }
}
