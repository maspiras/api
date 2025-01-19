<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
#use Illuminate\Database\Eloquent\Collection;
use App\Models\ReservedRoom;

class Reservation extends Model
{
    use HasFactory;
    //use SoftDeletes;
    public $timestamps = true;
    /* protected $fillable = [
        'ref_number','checkin', 'checkout', 'adults', 'childs', 'pets', 'fullname',
        'phone', 'email', 'additional_info', 'booking_source_id', 'doorcode',
        'rateperday', 'daystay', 'subtotal', 'grandtotal', 'currency_id',
        'payment_type_id', 'prepayment', 'payment_status_id', 'balancepayment',
        'user_id', 'host_id', 'booking_status_id', 'created_at'
    ]; */

    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reservedRooms(): HasMany
    {
        return $this->hasMany(ReservedRoom::class, 'reservation_id');
    }
}
