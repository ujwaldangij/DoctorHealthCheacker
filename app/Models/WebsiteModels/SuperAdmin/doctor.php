<?php

namespace App\Models\WebsiteModels\SuperAdmin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class doctor extends Model
{
    use HasFactory;
    protected $table = "doctor";
    protected $primaryKey = "id";
    protected $fillable = [
        'name',
        'specialties',
        'contact',
        'email',
        'align',
        'session_user_id',
        'agree_disagree',
        'sample_collection_date',
        'sample_collection_time',
        'address_line',
        'state',
        'city',
        'pincode',
        'lab_partners',
        'test_cycle',
        'esign',
    ];

    protected $casts = [
        'sample_collection_date' => 'date', // Example of casting to date
        'sample_collection_time' => 'time', // Example of casting to time
    ];

    protected $nullable = [
        'name',
        'specialties',
        'contact',
        'email',
        'align',
        'session_user_id',
        'agree_disagree',
        'sample_collection_date',
        'sample_collection_time',
        'address_line',
        'state',
        'city',
        'pincode',
        'user_mr',
        'esign',
    ];
}
