<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;

    protected $table = "budget";
    protected $fillable = [
        'client',
        'salesman',
        'description',
        'value',
    ];

    public function getCreatedAtFormatAttribute()
    {
        return $this->created_at->format('d/m/y');
    }
}
