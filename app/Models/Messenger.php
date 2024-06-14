<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Messenger extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'to_id', 'from_id', 'body', 'messenger_user_id',
    ];

    protected $appends = ['created_time', 'human_time'];

    public function getCreatedTimeAttribute()
    {
        return formatTime($this->created_at, 'h:i A');
    }

    public function getHumanTimeAttribute()
    {
        return \Carbon\Carbon::parse($this->created_at)->diffForHumans();
    }

    public function from()
    {
        return $this->belongsTo(User::class, 'from_id');
    }

    public function to()
    {
        return $this->belongsTo(User::class, 'to_id');
    }

    public function messengerUser()
    {
        return $this->belongsTo(MessengerUser::class, 'messenger_user_id');
    }
}
