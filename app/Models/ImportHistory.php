<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'creator_id',
        'type',
        'result_count',
        'description',
    ];

    protected $table = 'import_history';
    
}
