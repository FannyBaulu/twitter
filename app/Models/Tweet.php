<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Carbon\Carbon;

class Tweet extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

    /**
     * Converting date of creation into a more explicit format for users.
     *
     * @param [type] $date
     */
    public function getCreatedAtAttribute($date){
        return Carbon::parse($date)->format('d M. Y');
    }
}
