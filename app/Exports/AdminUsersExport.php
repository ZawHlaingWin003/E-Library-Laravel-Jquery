<?php

namespace App\Exports;

use App\Models\AdminUser;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;

class AdminUsersExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    /* public function collection()
    {
        return AdminUser::all();
    } */

    public function __construct($admin_users)
    {
        $this->admin_users = $admin_users;
    }

    public function view(): View
    {
        return view('dashboard.admin_users.export', [
            'admin_users' => $this->admin_users
        ]);
    }
}
