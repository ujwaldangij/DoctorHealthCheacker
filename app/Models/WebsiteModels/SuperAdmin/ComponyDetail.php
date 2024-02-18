<?php

namespace App\Models\WebsiteModels\SuperAdmin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComponyDetail extends Model
{
    use HasFactory;
    protected $table = "company_detail";
    protected $primaryKey = "id";
}
