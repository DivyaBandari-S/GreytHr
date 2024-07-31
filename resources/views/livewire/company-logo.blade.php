<div>
    @auth('emp')
    <img  height="50" width="200" src="{{$employee->company_logo}}" alt="">
    @endauth
    @auth('hr')
    <img height="50" width="200" src="{{ optional($hr)->company_logo }}" alt="">
    @endauth

    @auth('it')
    <img  height="50" width="200" src="{{ optional($it)->com->company_logo }}" alt="">
    @endauth
    @auth('finance')
    <img  height="50" width="200" src="{{ optional($finance)->com->company_logo }}" alt="">
    @endauth
    @auth('admins')
    <img  height="50" width="200" src="{{ optional($admin)->com->company_logo }}" alt="">
    @endauth
</div>