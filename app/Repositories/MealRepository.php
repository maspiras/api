<?php

namespace App\Repositories;
use App\Models\Service;
use Illuminate\Support\Facades\DB;
#use Illuminate\Support\LazyCollection;
#use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
class MealRepository extends BaseRepository
{
    protected $model;
    
    public function __construct()
    {
        $this->model = DB::table('meals');
    }
    
    public function getMeals(){        
        //Cache::forever('key', 'value');
        $cache_keyword = 'meals';	
		$data = cache($cache_keyword);        
		if(is_null($data)){	
            $data = $this->model->orderBy('id')->get();
            Cache::forever($cache_keyword, $data);
		}
		return $data;

    }
}
