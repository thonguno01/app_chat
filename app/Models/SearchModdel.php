<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SearchModdel extends Model
{
    use HasFactory;
    static public function searchUser($keySearch)
    {
        $query =  DB::table('users')
            ->where('id', '<>', session()->get('id'))
            ->where('name', 'like', '%' . $keySearch . '%')
            ->get();
        return $query;
    }
}
