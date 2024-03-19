@foreach ($this->employeesWithMatchingDOB as $employee)
    <x-employee-details-card :employee="$employee" />
@endforeach


