<?php

namespace App\Http\Controllers\Dashboard;

use App\Exports\AdminUsersExport;
use App\Http\Controllers\Controller;
use App\Imports\AdminUsersImport;
use App\Models\AdminUser;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AdminUserController extends Controller
{
    public function index()
    {
        $admin_users = AdminUser::orderBy('id', 'desc')->paginate(5);
        return view('dashboard.admin_users.index', compact('admin_users'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function export()
    {
        $admin_users = AdminUser::all();
        return Excel::download(new AdminUsersExport($admin_users), 'admin_users.xlsx');
    }

    public function uploadExcel()
    {
        return view('dashboard.admin_users.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'admin_users' => 'required|mimes:xlsx'
        ]);

        if($request->hasFile('admin_users')){
            Excel::import(new AdminUsersImport, $request->file('admin_users'));
            return redirect()->route('admin_users.index')->with('success', 'Admin Users Data Imported Successfully!');
        }
    }
}
