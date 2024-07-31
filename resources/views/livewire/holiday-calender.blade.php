<div>
<!-- <x-loading-indicator /> -->
    <div class="container">
        <div class="row m-0 p-0">
            <div class="col-md-12 text-right d-flex justify-content-end">
                <select id="yearSelect" wire:change="selectYear($event.target.value)" class="dropdownPlaceholder">
                    <option class="optionDropdown" value="{{ $previousYear }}" {{ $selectedYear == $previousYear ? 'selected' : '' }}>{{ $previousYear }}</option>
                    <option class="optionDropdown" value="{{ $initialSelectedYear }}" {{ $selectedYear == $initialSelectedYear ? 'selected' : '' }}>{{ $initialSelectedYear }}</option>
                    <option class="optionDropdown" value="{{ $nextYear }}" {{ $selectedYear == $nextYear ? 'selected' : '' }}>{{ $nextYear }}</option>
                </select>
            </div>
        </div>
    </div>

    <div class="hol-container" id="calendar{{ $selectedYear }}">
        <div class="row m-0">
            @foreach($calendarData->sortBy('date')->groupBy(function($entry) {
            return date('F Y', strtotime($entry->date));
            }) as $month => $entries)
            <div class="col-md-3">
                <div class="inner-container">
                    <div class="headerMonth">
                        <h6>{{ $month }}</h6>
                    </div>
                    @if($entries->isEmpty() || $entries->every(function ($entry) {
                    return empty($entry->festivals);
                    }))
                    <div class="no-holidays">
                        <h6>No holidays</h6>
                    </div>
                    @else
                    <div class="group py-3 px-3">
                        @foreach($entries as $entry)
                        <div class="fest grid-container">
                            <div class="grid-item date-container">
                                <h5 class="p-0 m-0">{{ date('d', strtotime($entry->date)) }}</h5>
                                <p class="mb-0" style="font-size: 10px;">{{ substr($entry->day, 0, 3) }}</p>
                            </div>
                            <div class="grid-item festivals">
                                <p class="mb-0" style="font-size: 12px;">{{ $entry->festivals }}</p>
                            </div>
                        </div>
                        @endforeach

                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div style="text-align: center; margin: 30px auto;">
        @if($selectedYear == $nextYear && $calendarData->where('year', $nextYear)->isEmpty())
        <div class="bg-white rounded border p-3" style="margin: 50px auto; width:80%;">
            <p style="font-size: 16px; color: #721c24; font-weight: bold;">It’s lonely here!</p>
            <p style="font-size: 12px; color:#778899;">HR department is yet to publish the holiday list for the year {{ $nextYear }}, check again later.</p>
        </div>
        @endif
    </div>


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
