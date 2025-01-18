<?php

namespace App\Repositories;
use App\Models\Service;
use Illuminate\Support\Facades\DB;
#use Illuminate\Support\LazyCollection;
#use Illuminate\Support\Collection;

class ReservedMealRepository extends BaseRepository
{
    protected $model;
    
    public function __construct()
    {
        $this->model = DB::table('reserved_meals');
    }

    public function getMyReservedMeals($id){       
        /* return $this->model
            #->leftJoin('services', 'reserved_services.service_id', '=', 'services.id')
            ->where('reservation_id', '=', $id)
            ->get(); */
            
        $cache_keyword = 'myReservedMeals_'.$id;	
        $data = cache($cache_keyword);        
        if(is_null($data)){	
            $data = $this->model
            ->select(['reserved_meals.id as id', 'reserved_meals.meal_id as meal_id', 'reserved_meals.meal_adults as meal_adults', 'reserved_meals.meal_childs as meal_childs',
                       'reserved_meals.amount as amount','reserved_meals.reservation_id as reservation_id' , 'reserved_meals.added_on as added_on', 'meals.meals_name as meals_name',
            ])    
                ->leftJoin('meals', 'reserved_meals.meal_id', '=', 'meals.id')
                    ->where('reserved_meals.reservation_id', '=', $id)->first();
            cache([$cache_keyword => $data], now()->addDays(1)); 
        }
        return $data;    
    }

    public function update(int $id, array $data)
    {        
        return $this->model->where('reservation_id', $id)
                    ->update($data);
    }

    public function updateOrInsert(int $id, array $data)
    {        
        return $this->model->updateOrInsert(['reservation_id' => $id], $data);                    
    }

    

    
}
