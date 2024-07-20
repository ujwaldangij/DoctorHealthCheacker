<?php

namespace App\Models\WebsiteModels\SuperAdmin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reminder extends Model
{
    use HasFactory;
    protected $table = "reminder";
    protected $primaryKey = "id";
    protected $fillable = [
        'schedule_id',
        'start_date',
        'end_date',
        'message',
        'created_at',
        'updated_at',
    ];
}
