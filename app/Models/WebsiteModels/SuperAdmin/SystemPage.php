<?php

namespace App\Models\WebsiteModels\SuperAdmin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemPage extends Model
{
    use HasFactory;
    protected $table = "system_pages";
    protected $primaryKey = "id";

    public function getTitleAttribute($value){
        return ucfirst($value);
    }
}
