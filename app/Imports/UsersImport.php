<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
class UsersImport implements ToModel
{
    public function model(array $row)
    {
        return new User([
            'name'     => $row[0],
            'email'    => $row[1],
            'documento'    => $row[2],
            //'plan_id' =>$row[1],
            'password' => $row[2],
        ]);

    }
}
