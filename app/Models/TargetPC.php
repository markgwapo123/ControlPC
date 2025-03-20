<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TargetPC extends Model
{
    use HasFactory;

    protected $table = 'target_pcs'; // Ensure the correct table name
    protected $fillable = ['ip', 'status']; // Define fillable columns
}
