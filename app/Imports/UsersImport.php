<?php

namespace App\Imports;

use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;

class UsersImport implements ToCollection, WithHeadingRow, WithValidation
{
    use Importable;

    /**
     * @param Row $row
     */
    public function collection(Collection  $rows)
    {
        foreach ($rows as $row) {
            $user = new User([
                'name' => $row['nombre'],
                'email' => $row['email'],
                'username' => $row['username'],
                //'avatar' => $row[''],
                'estado' => 1,
                'password' => bcrypt($row['password']),
            ]);
            $user->save();

            $user->assignRole($row['rol']);

            $user_info = new UserInfo([
                'id' => $user->id,
                'telefono' => $row['telefono'],
                'empresa' => $row['empresa'],
                'pais' => $row['pais'],
            ]);
            $user_info->save();
        }
    }

    public function rules(): array
    {
        return [
            'email' => 'required|unique:users',
            'username' => 'required|unique:users',
            'nombre' => 'required',
            'password' => 'required',
        ];
    }
}