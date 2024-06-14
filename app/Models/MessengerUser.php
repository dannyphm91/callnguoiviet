<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Ad\Entities\Ad;

class MessengerUser extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'from_id',
        'to_id',
        'ad_id',
    ];

    public function from()
    {
        return $this->belongsTo(User::class, 'from_id');
    }

    public function to()
    {
        return $this->belongsTo(User::class, 'to_id');
    }

    public function ad()
    {
        return $this->belongsTo(Ad::class, 'ad_id');
    }

    public function messages()
    {
        return $this->hasMany(Messenger::class, 'messenger_user_id');
    }
}
