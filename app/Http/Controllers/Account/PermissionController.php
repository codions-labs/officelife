<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;
use App\Models\Company\Employee;
use App\Http\Controllers\Controller;
use App\Services\Company\Employee\ChangePermission;

class PermissionController extends Controller
{
    /**
     * Show the list of employees.
     *
     * @param Request $request
     * @param int $companyId
     * @param int $employeeId
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, int $companyId, int $employeeId)
    {
        $employee = Employee::findOrFail($employeeId);

        return view('company.employee.permission')
            ->withEmployee($employee);
    }

    /**
     * Change permission.
     *
     * @param Request $request
     * @param int $companyId
     * @param int $employeeId
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, int $companyId, int $employeeId)
    {
        $request = [
            'company_id' => $companyId,
            'author_id' => auth()->user()->id,
            'employee_id' => $employeeId,
            'permission_level' => $request->get('permission_level'),
        ];

        (new ChangePermission)->execute($request);

        return redirect(tenant('/account/employees'));
    }
}