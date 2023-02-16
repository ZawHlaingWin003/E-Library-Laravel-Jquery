<?php

namespace App\Imports;

use App\Models\AdminUser;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class AdminUsersImport implements ToModel, WithHeadingRow, WithValidation
{

    /* public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $data = [
                'name' => $row['name'],
                'email' => $row['email'],
                'phone' => $row['phone'],
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            ];
            AdminUser::create($data);
        }
    } */
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new AdminUser([
            'name' => $row['name'],
            'email' => $row['email'],
            'phone' => $row['phone'],
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);
    }

    public function rules(): array
    {
        return[
            'name' => 'required',
            'email' => 'required|unique:admin_users,email',
            'phone' => 'required|unique:admin_users,phone'
        ];
    }
}
