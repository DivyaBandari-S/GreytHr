<div class="container-fluid my-5">
    <h5 class="text-center text-5xl font-bold py-3">Users</h5>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 gap-5 justify-content-center">
        @forelse ($employeeDetails  as $key => $employee)
            {{-- child --}}
            <div class="col mb-4">
                <div class="card h-100">
                    <div class="col d-flex align-items-center justify-content-center mt-4" >
                        @if($employee->image)
                            <div >
                                <img src="{{ asset('storage/' . $employee->image) }}"  height="50" width="50" style="border-radius:50%;">
                            </div>
                        @else
                            <div >
                                <img src="https://th.bing.com/th/id/OIP.Ii15573m21uyos5SZQTdrAHaHa?rs=1&pid=ImgDetMain"  height="50" width="50" alt="Default Image">
                            </div>
                        @endif
                    </div>
                    <div class="card-body text-center">
                       
                        <div>{{ ucfirst(strtolower($employee->first_name)) }}&nbsp;{{ ucwords(strtolower($employee->last_name)) }}</div>
                        <p class="card-text">{{$employee->emp_id}}</p>
                    </div>
                    <div class="card-footer text-center">
                        <button class="btn btn-primary" wire:click="message('{{ $employee->emp_id }}')">Message</button>
                    </div>
                </div>
            </div>
        @empty
            <p class="col text-center">No employees found.</p>
        @endforelse
    </div>
</div>
