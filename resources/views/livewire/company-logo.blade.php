<div>
@auth('emp')
    <img  src="{{$employee->company_logo}}" alt="">
    @endauth
    @auth('hr')
    <img src="{{ optional($hr)->company_logo }}" alt="">
    @endauth
 
    @auth('it')
    <img  src="{{ optional($it)->com->company_logo }}" alt="">
    @endauth
    @auth('finance')
    <img  src="{{ optional($finance)->com->company_logo }}" alt="">
    @endauth
    @auth('admins')
    <img  src="{{ optional($admin)->com->company_logo }}" alt="">
    @endauth
</div>