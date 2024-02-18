<?php

namespace App\Models\WebsiteModels\SuperAdmin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class menu extends Model
{
    use HasFactory;
    protected $table = "menus";
    protected $primaryKey = "id";

    public function getNameAttribute($value){
        return ucfirst($value);
    }
    public function getMenuWithSubmenus(){
        return $this->select('menus.id', 'menus.url', 'menus.icon', 'menus.name','sub_menus.menu_id', 'sub_menus.submenusname')
        ->leftJoin('sub_menus', 'menus.id', '=', 'sub_menus.menu_id')
        ->get()->toArray();
    }
}
