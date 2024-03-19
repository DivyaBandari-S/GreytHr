<div>

<div class="container">
        <div class="row m-0">
            <div class="col-md-12 text-right d-flex justify-content-end">
                <select id="yearSelect" >
                    @php
                    $currentYear = date('Y');
                    @endphp
                    <option class="dropdown" value="{{ $currentYear - 1 }}">{{ $currentYear - 1 }}</option>
                    <option class="dropdown" value="{{ $currentYear }}" selected>{{ $currentYear }}</option>
                    <option class="dropdown" value="{{ $currentYear + 1 }}">{{ $currentYear + 1 }}</option>
                </select>
            </div>

        </div>
    </div>

    @if($currentYear == true)
    @php
    // Filter the data based on the selected year
    $filteredData = $calendarData->where('year', $currentYear)->sortBy('date');
    $currentMonth = '';
    @endphp

    <div class="hol-container" id="calendar{{ $currentYear }}">
        <div class="row m-0"> <!-- Create a flex container for months -->
            @foreach($filteredData->groupBy(function($entry) {
            return date('F Y', strtotime($entry->date));
            }) as $month => $entries)
            <div class="col-md-3">
                <div class="inner-container">
                    <h6>{{ $month }}</h6>
                    @if($entries->isEmpty() || $entries->every(function ($entry) {
                    return empty($entry->festivals);
                    }))
                    <div class="no-holidays">
                        <h6>No holidays</h6>
                    </div>
                    @else
                    <div class="group p-0" >
                        @foreach($entries as $entry)
                        <div class="fest d-flex flex-row align-items-center py-0 m-0" style="gap:10px;" >
                            <h5>{{ date('d', strtotime($entry->date)) }}<span>
                                    <p style="font-size: 10px;">{{ substr($entry->day, 0, 3) }}</p>
                                </span></h5>
                            <p style=" font-size: 12px;">{{ $entry->festivals }}</p>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    @if($previousYear == true)
    @php

    $filteredDataLastYear = $calendarData->where('year', $currentYear-1)->sortBy('date');
    $currentMonth = '';
    @endphp
    <div class="hol-container" id="calendar{{ $currentYear-1 }}">
        <div class="row m-0"> <!-- Create a flex container for months -->
            @foreach($filteredDataLastYear->groupBy(function($entry) {
            return date('F Y', strtotime($entry->date));
            }) as $month => $entries)
            <div class="col-md-3">
                <div class="inner-container">
                    <h6>{{ $month }}</h6>
                    @if($entries->isEmpty() || $entries->every(function ($entry) {
                    return empty($entry->festivals);
                    }))
                    <div class="no-holidays">
                        <h6>No holidays</h6>
                    </div>
                    @else
                    <div class="group p-0" >
                        @foreach($entries as $entry)
                        <div class="fest d-flex flex-row align-items-center" style="gap:10px;">
                            <h5>{{ date('d', strtotime($entry->date)) }}<span>
                                    <p style="font-size: 10px;">{{ substr($entry->day, 0, 3) }}</p>
                                </span></h5>
                            <p style=" font-size: 12px;">{{ $entry->festivals }}</p>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    @if($nextYear)
    @php
    $filteredDataNextYear = $calendarData->where('year', $currentYear + 1)->sortBy('date');
    $currentMonth = '';
    @endphp

    <div class="hol-container" id="calendar{{ $currentYear + 1 }}">
        <div class="row m-0"> <!-- Create a flex container for months -->
            @if($filteredDataNextYear->isEmpty() || $filteredDataNextYear->every(function ($entry) {
                return empty($entry->festivals);
            }))
            <div class="col-md-12">
                <div class="no-holidays">
                    <h6>No holidays data available for the next year.</h6>
                    <p>Update the holidays for the next year!</p>
                </div>
            </div>
            @else
            @foreach($filteredDataNextYear->groupBy(function($entry) {
                return date('F Y', strtotime($entry->date));
            }) as $month => $entries)
            <div class="col-md-3">
                <div class="inner-container">
                    <h6>{{ $month }}</h6>
                    @if($entries->isEmpty() || $entries->every(function ($entry) {
                        return empty($entry->festivals);
                    }))
                    <div class="no-holidays">
                        <h6>No holidays</h6>
                    </div>
                    @else
                    <div class="group p-0" >
                        @foreach($entries as $entry)
                        <div class="fest d-flex flex-row align-items-center" style="gap:10px;">
                            <h5>{{ date('d', strtotime($entry->date)) }}<span>
                                    <p style="font-size: 10px;">{{ substr($entry->day, 0, 3) }}</p>
                                </span></h5>
                            <p style=" font-size: 12px;">{{ $entry->festivals }}</p>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>
@endif

    <script>
        $(document).ready(function() {
            // Initially, show the calendar for the selected year
            var selectedYear = $("#yearSelect").val();
            $("#calendar" + selectedYear).show();

            $("#yearSelect").change(function() {
                var selectedYear = $(this).val();
                // Hide all calendars
                $(".hol-container").hide();
                // Show the calendar based on the selected year
                $("#calendar" + selectedYear).show();
            });
        });
    </script>

</div>