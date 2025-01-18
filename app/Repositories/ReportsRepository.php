<?php

namespace App\Repositories;
use App\Models\Payment;
use Illuminate\Support\LazyCollection;
use Illuminate\Support\Facades\DB;
use Carbon\CarbonPeriod;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\Query\Builder;
class ReportsRepository extends BaseRepository
{    
    private $carbon, $payments;
    public function __construct()
    {   
        $this->payments = DB::table('payments');
            
        /* protected $model;
         
        #$this->model = DB::table('reserved_rooms');
        switch($this->r->option){
            case 'sales':
                $this->model = DB::table('reservation');
                return getSales();
            break;
			
			default:	
		} */ 
    }

    public function getSales($start, $end, $duration = '1 day' ,$day = '-%d'){
        
        #return $thismonth = CarbonPeriod::create(Carbon::now()->startOfMonth(), '1 day', Carbon::now());
        
/*
        $payments = DB::table('payments')
                        ->selectRaw('count(id) as data, DATE_FORMAT(added_on,"%Y-%m-%d %H:%i:00") AS new_date, YEAR(added_on) as year, MONTH(added_on) as month, DAY(added_on) as day, sum(amount) as amount')
                        //->groupBy('new_date')
                        ->groupBy(DB::raw('DATE_FORMAT(added_on,"%Y-%m-%d %H:%i:00")'))
                        ->get();
        */
        $sales['data'] = DB::select("select count(id) AS data, 
                                DATE_FORMAT(added_on, '%Y-%m".$day."') AS new_date, 
                                YEAR(added_on) AS year, 
                                MONTH(added_on) AS month,
                                DAY(added_on) AS day,
                                sum(amount) as amount
                                from payments
                                where (added_on between '".$start."' and '".$end."') AND (host_id = '".auth()->user()->host_id."')
                                group by new_date"
                            );
        
        $sales['dates'] = CarbonPeriod::create($start, $duration, $end);                            
        
        return $sales;
        
        
        /* SELECT COUNT(id) AS DATA, 
        DATE_FORMAT(added_on, '%Y-%m-%d') AS new_date, 
        YEAR(added_on) AS YEAR, 
        MONTH(added_on) AS MONTH,
        DAY(added_on) AS DAY,
        SUM(amount) AS amount
        FROM payments
        GROUP BY new_date */
        
    }

    public function getBookingSourcesReport(){
        return DB::select("SELECT bs.source_name, COUNT(r.`booking_source_id`) AS total, source_color
                            FROM reservations r
                            LEFT JOIN booking_sources bs
                            ON bs.id=r.booking_source_id
                            where host_id=".auth()->user()->host_id."
                            GROUP BY bs.source_name
                            ORDER BY total DESC
                            ");
    }



    

}
