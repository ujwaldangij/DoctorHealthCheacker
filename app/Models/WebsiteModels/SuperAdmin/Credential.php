<?php

namespace App\Models\WebsiteModels\SuperAdmin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Credential extends Model
{
    use HasFactory,Notifiable;
    protected $table = "credentials";
    protected $primaryKey = "id";

    protected $fillable = [
        'username',
        'email',
        'password',
        'email_verified_at',
        'login_attempts',
        'last_login_attempt_at'
    ];

}
