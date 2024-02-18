<?php

namespace App\Models\WebsiteModels\SuperAdmin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class track extends Model
{
    use HasFactory;
    protected $table = "track";
    protected $primaryKey = "id";
    protected $fillable = [
        'doctor_id','status','created_at','updated_at'
    ];
}
