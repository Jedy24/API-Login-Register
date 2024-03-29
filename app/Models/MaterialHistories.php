<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialHistories extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'subject',
        'grade',
        'notes',
        'output_data',
        'user_id'
    ];

    protected $casts = [
        'output_data' => 'json',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
