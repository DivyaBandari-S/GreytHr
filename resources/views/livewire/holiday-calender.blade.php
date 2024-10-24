<div>
    <div class="position-absolute" wire:loading
        wire:target="selectYear">
        <div class="loader-overlay">
            <div class="loader">
                <div></div>
            </div>
        </div>
    </div>
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
            @if($calendarData && $calendarData->isNotEmpty())
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
                                <p class="mb-0 normalTextValue fw-500">{{ $entry->festivals }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
            @else
            <div class="bg-white rounded border p-3 d-flex flex-column align-items-center" style="margin: 50px auto; width:80%;">
                <p class="noDataAvailable">No Data Available</p>
                <p class="normalTextValue">There is no data available for the selected year. Please check again later.</p>
            </div>
            @endif
        </div>
    </div>
</div>