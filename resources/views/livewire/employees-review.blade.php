<div>
    <div class="row m-0 p-0 " >
        <div class="col-md-3">
            <p>Attendance</p>
            <p>Leave</p>
        </div>
        <div class="col-md-9">
            <div>
                <button>Active</button>
            </div>
            <div class="attendace-content-active">
                <p>attendance</p>
            </div>

            <div class="leaveContent">
                <p>Leave </p>
            </div>
            @endif
        </div>
        @endif
    </div>
    @endif
</div>
@elseif($currentSection === 'Leave Cancel')
<div class="d-flex align-items-center justify-content-center gap-4">
    <button wire:click="toggleActiveContent('Leave Cancel')" class="btn" style="font-size:12px;background-color: {{ $activeButton['Leave Cancel'] ? 'rgb(2, 17, 79)' : 'white' }};
                            color: {{ $activeButton['Leave Cancel'] ? 'white' : 'black' }}">
        Active
    </button>
    <button wire:click="toggleClosedContent('Leave Cancel')" class="btn" style="border:1px solid rgb(2, 17, 79);font-size:12px;background-color: {{ $activeButton['Leave Cancel'] ? 'white' : 'rgb(2, 17, 79)' }};
                            color: {{ $activeButton['Leave Cancel'] ? 'rgb(2, 17, 79)' : 'white' }}">
        Closed
    </button>
</div>
<div class="mt-5">
    @if($activeButton['Leave Cancel'])
    <div class="d-flex flex-column justify-content-center bg-white rounded border text-center">
        <img src="/images/pending.png" alt="Pending Image" style="width:55%; margin:0 auto;">
        <p style="color:#969ea9; font-size:12px; font-weight:400; ">Hey, you have no Leave Cancel records to view</p>
    </div>
    @else
    <div class="d-flex flex-column justify-content-center bg-white rounded border text-center">
        <img src="/images/pending.png" alt="Pending Image" style="width:55%; margin:0 auto;">
        <p style="color:#969ea9; font-size:12px; font-weight:400; ">Hey, you have no closed Leave Cancel records to view</p>
    </div>
    @endif
</div>
@elseif($currentSection === 'Leave Comp Off')
<div class="d-flex align-items-center justify-content-center gap-4">
    <button wire:click="toggleActiveContent('Leave Comp Off')" class="btn" style="font-size:12px;background-color: {{ $activeButton['Leave Comp Off'] ? 'rgb(2, 17, 79)' : 'white' }};
                            color: {{ $activeButton['Leave Comp Off'] ? 'white' : 'black' }}">
        Active
    </button>
    <button wire:click="toggleClosedContent('Leave Comp Off')" class="btn" style="border:1px solid rgb(2, 17, 79);font-size:12px;background-color: {{ $activeButton['Leave Comp Off'] ? 'white' : 'rgb(2, 17, 79)' }};
                            color: {{ $activeButton['Leave Comp Off'] ? 'rgb(2, 17, 79)' : 'white' }}">
        Closed
    </button>
</div>
<div class="mt-5">
    @if($activeButton['Leave Comp Off'])
    <div class="d-flex flex-column justify-content-center bg-white rounded border text-center">
        <img src="/images/pending.png" alt="Pending Image" style="width:55%; margin:0 auto;">
        <p style="color:#969ea9; font-size:12px; font-weight:400; ">Hey, you have no Leave Comp Off records to view</p>
    </div>
    @else
    <div class="d-flex flex-column justify-content-center bg-white rounded border text-center">
        <img src="/images/pending.png" alt="Pending Image" style="width:55%; margin:0 auto;">
        <p style="color:#969ea9; font-size:12px; font-weight:400; ">Hey, you have no closed Leave Comp Off records to view</p>
    </div>
    @endif
</div>
@elseif($currentSection === 'Restricted Holiday')
<div class="d-flex align-items-center justify-content-center gap-4">
    <button wire:click="toggleActiveContent('Restricted Holiday')" class="btn" style="font-size:12px;background-color: {{ $activeButton['Restricted Holiday'] ? 'rgb(2, 17, 79)' : 'white' }};
                            color: {{ $activeButton['Restricted Holiday'] ? 'white' : 'black' }}">
        Active
    </button>
    <button wire:click="toggleClosedContent('Restricted Holiday')" class="btn" style="border:1px solid rgb(2, 17, 79); font-size:12px;background-color: {{ $activeButton['Restricted Holiday'] ? 'white' : 'rgb(2, 17, 79)' }};
                            color: {{ $activeButton['Restricted Holiday'] ? 'rgb(2, 17, 79)' : 'white' }}">
        Closed
    </button>
</div>
<div class="mt-5">
    @if($activeButton['Restricted Holiday'])
    <div class="d-flex flex-column justify-content-center bg-white rounded border text-center">
        <img src="/images/pending.png" alt="Pending Image" style="width:55%; margin:0 auto;">
        <p style="color:#969ea9; font-size:12px; font-weight:400; ">Hey, you have no Restricted Holiday records to view</p>
    </div>
    @else
    <div class="d-flex flex-column justify-content-center bg-white rounded border text-center">
        <img src="/images/pending.png" alt="Pending Image" style="width:55%; margin:0 auto;">
        <p style="color:#969ea9; font-size:12px; font-weight:400; ">Hey, you have no closed Restricted Holiday records to view</p>
    </div>
    @endif
</div>
@endif
</div>
</div>
<script>
    function toggleAccordion(element) {

        const accordionBody = element.nextElementSibling;

        if (accordionBody.style.display === 'block') {

            accordionBody.style.display = 'none';

            element.classList.remove('active'); // Remove active class

        } else {

            accordionBody.style.display = 'block';

            element.classList.add('active'); // Add active class

        }
    }
</script>