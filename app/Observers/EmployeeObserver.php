<?php

namespace App\Observers;

use App\Models\Employee;
use App\Jobs\IndexEmployeeElasticsearchJob;
use App\Jobs\RemoveEmployeeElasticsearchJob;

class EmployeeObserver
{
    public function created(Employee $employee)
    {
        dispatch(new IndexEmployeeElasticsearchJob($employee));
    }

    public function updated(Employee $employee)
    {
        dispatch(new IndexEmployeeElasticsearchJob($employee));
    }

    public function deleted(Employee $employee)
    {
        dispatch(new RemoveEmployeeElasticsearchJob($employee->id));
    }
}
