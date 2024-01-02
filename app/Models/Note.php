<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = [
        'id'
    ];

    protected $casts =[
        'is_published' => 'boolean',
    ];
    
    protected $fillable = [
        'title',
        'body',
        'user_id',
        'send_date',
        'is_published',
        'heart_count',
        'recipient'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
