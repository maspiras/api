<?php

namespace App\Repositories;
use App\Models\ReservedRoom;
#use Illuminate\Support\LazyCollection;
#use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;

class ReservedRoomRepository extends BaseRepository
{
    /*public $model = ReservedRooms::class;
    public function __construct()
    {
        $this->model = $model;
    } */
    protected $model;
    public function __construct()
    {
        $this->model = DB::table('reserved_rooms');
    }

    public function getMyReservedRooms($id){       
        return $this->model->distinct()
        ->select(['reserved_rooms.id as id', 'reserved_rooms.room_id as room_id', 'rooms.room_name as room_name'
            ])    
                ->leftJoin('rooms', 'reserved_rooms.room_id', '=', 'rooms.id')
        ->where('reserved_rooms.reservation_id', '=', $id)->get();
        
    }



     public function getHostReservedRooms($from, $to){
        
       
        $reservedrooms = $this->model->distinct()
        ->selectRaw('room_id, fullname, checkin, checkout, payment_status_id, prepayment, grandtotal, balancepayment as balance, DATE(checkout) AS checkoutday')
        ->join('reservations', 'reserved_rooms.reservation_id', '=', 'reservations.id')
        ->where('host_id', auth()->user()->host_id)
        ->whereBetween('reserved_dates',
        [
            $from,
            $to
        ])
        ->cursor()
        #->orderBy('reserved_dates', 'asc')
        ->sortByDesc('reserved_dates');

        return $reservedrooms;
    }

    public function updateMyReservedRoom($reservation_id, $data){     
        //$this->model->where('reservation_id', '=', $reservation_id)->delete();        
       // $this->removeReservedRoom($reservation_id);
       // $this->model->insert($data);
        /* $this->model->where('reservation_id', '=', $reservation_id)->chunkById(1000, function ($reservedrooms) {
            //go through the collection and delete every post.
            foreach($reservedrooms as $r) {
                $r->delete();
            }
        }); */

        if($this->removeReservedRoom($reservation_id)){
           // $this->model->insert($data);
            //$this->insert($data);
            $this->massiveInsert($data);
        }
        
    }

    public function removeReservedRoom($reservation_id){    
        
        /* $this->model->where('reserved_rooms.reservation_id', '=', $reservation_id)->chunkById(100, function (Collection $reservedrooms){           
            foreach($reservedrooms as $r) {
               // $r->delete();
              // $data->push($r->id);
                DB::table('reserved_rooms')
                ->where('reserved_rooms.id', '=',$r->id)
                ->delete();                 
            }
        });  */
        $query = DB::table('reserved_rooms')->where('reserved_rooms.reservation_id', '=', $reservation_id);
        $i=0;
                while ($query->exists()) {
                    $query->limit(200)->delete();
                    $i++;
                    //sleep(3);
                }

        $ret = false;
        if($i >= 0){
            $ret = true;
        }
        return $ret;
    }

    

    
}
