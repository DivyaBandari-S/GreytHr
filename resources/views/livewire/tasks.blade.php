<div>
    <style>
        .people-input-group-container {
            width: 230px;
        }

        .people-search-input {
            font-size: 0.75rem;
            border-radius: 5px 0 0 5px;
            height: 32px;
        }


        .people-search-btn {
            height: 32px;
            width: 40px;
            position: relative;
            border-radius: 0 5px 5px 0;
            background-color: rgb(2, 17, 79);
            color: #fff;
            border: none;
            margin-right: 10px;
        }

        .people-search-icon {
            position: absolute;
            top: 9px;
            left: 11px;
            color: #fff;
        }

        .task-date-range-picker {
            width: 245px;
            margin-left: -20px;
        }

        @media (max-width: 548px) {
            .task-date-range-picker {
                margin-left: 0px;
            }
        }

        .viewfile {
            color: var(--main-heading-color);
            font-size: var(--main-headings-font-size);
            font-weight: 500;
        }
  
    </style>

    <div class="container"
        style="margin-top:15px;width:100%; height: 600px; border: 1px solid silver; border-radius: 5px;background-color:white; overflow-x: hidden;padding-bottom: 15px; position: relative;">
        <div class="nav-buttons d-flex justify-content-center" style="margin-top: 15px;">
            <ul class="nav custom-nav-tabs border">
                <li class="custom-item m-0 p-0 flex-grow-1">
                    <div style="border-top-left-radius:5px;border-bottom-left-radius:5px;"
                        class="custom-nav-link {{ $activeTab === 'open' ? 'active' : '' }}"
                        wire:click.prevent="setActiveTab('open')">Open</div>
                </li>
                <li class="custom-item m-0 p-0 flex-grow-1">
                    <a href="#" style="border-top-right-radius:5px;border-bottom-right-radius:5px;"
                        class="custom-nav-link {{ $activeTab === 'completed' ? 'active' : '' }}"
                        wire:click.prevent="setActiveTab('completed')">Closed</a>
                </li>
            </ul>
        </div>

        <div id="alert-container" class="d-flex justify-content-center alert-container " wire:poll.5s="hideAlert" style="position: sticky; top: 13%; z-index: 10; width: 100%;" >

            @if ($showAlert)
                <p class="alert alert-success" role="alert" style=" font-weight: 400;width:fit-content;padding:10px;border-radius:5px" >
                    {{ session('message') }}
                    <span style="font-weight:500;margin:0px 10px; cursor: pointer; " wire:click='hideAlert'>x</span>
                </p>
            @endif
        </div>

        <script>
            $(document).ready(function() {
                $('#date_range').datepicker({
                    format: 'yyyy-mm-dd',
                    startDate: '-30d',
                    endDate: '+0d',
                    todayHighlight: true,
                    multidateSeparator: ' to ',
                    inputs: $('#start_date, #end_date'), 
                    inputs: {
                        start: $('#start_date'),
                        end: $('#end_date')
                    },
                    clearBtn: true,
                    autoclose: true,
                    toggleActive: true
                }).on('changeDate', function(e) {
                    var startDate = $('#start_date').val();
                    var endDate = $('#end_date').val();
                    @this.set('start_date', startDate);
                    @this.set('end_date', endDate);
                });
            });
        </script>

        <div style="display:flex; justify-content:flex-end;">
            <button wire:click="show"
                style="background-color:rgb(2, 17, 79); border: none; border-radius: 5px; color: white; font-size: 0.75rem; height: 30px; cursor: pointer; margin-top: 15px; margin-right: 20px;width:100px; margin-bottom: 15px;">Add
                New Task</button>
        </div>


        @if ($activeTab == 'open')
            <div class="filter-section" style="padding-bottom: 15px; border-radius: 5px;">
                <form class="form-inline row" style="margin-bottom: -15px;">
                    <!-- Search Box -->
                    <div class="input-group people-input-group-container">
                        <input wire:model="search" type="text" class="form-control people-search-input"
                            placeholder="Search..." aria-label="Search" aria-describedby="basic-addon1">
                        <div class="input-group-append">
                            <button wire:click="searchActiveTasks" class="people-search-btn" type="button">
                                <i class="fa fa-search people-search-icon"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-group task-date-range-picker">
                        <!-- <label for="drp" class="form-label">DateRangePicker</label> -->
                        <livewire:date-component key="{{ 'drp-' . uniqid() }}" :start="$start" :end="$end" />
                    </div>
                </form>
            </div>
            <div class="card-body"
                style="background-color:white;width:100%;border-radius:5px;max-height:400px;overflow-y:auto;overflow-y:auto;margin-top: 10px;">

                <div class="table-cresponsive">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background-color: rgb(2, 17, 79); color: white;">
                                <th style="padding: 7px; font-size: 0.75rem; text-align: start; width: 10%; min-width: 80px;">
                                    <i class="fa fa-angle-down" style="color: white; padding-left: 8px;"></i>
                                </th>
                                <th style="padding: 7px; font-size: 0.75rem; text-align: start; width: 15%; min-width: 120px;">Task Id
                                </th>
                                <th style="padding: 7px; font-size: 0.75rem; text-align: start; width: 15%; min-width: 150px;">Task Name
                                </th>
                                <th style="padding: 7px; font-size: 0.75rem; text-align: start; width: 15%; min-width: 170px;">Assigned By
                                </th>
                                <th style="padding: 7px; font-size: 0.75rem; text-align: start; width: 15%; min-width: 150px;">Assignee
                                </th>

                                <th style="padding: 7px; font-size: 0.75rem; text-align: start; width: 15%; min-width: 150px;">Assigned
                                    Date
                                </th>
                                <th style="padding: 7px; font-size: 0.75rem; text-align: start; width: 15%; min-width: 150px;">Due Date
                                </th>
                                <th style="padding: 7px; font-size: 0.75rem; text-align: start; width: 15%; min-width: 150px;">Re-Opened Date
                                </th>
                                <th style="padding: 7px; font-size: 0.75rem; text-align: center; width: 15%; min-width: 200px;">Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($searchData->isEmpty())
                                <tr>
                                    <td colspan="8" style="text-align: center;">
                                        <img style="width: 10em; margin: 20px;"
                                            src="https://media.istockphoto.com/id/1357284048/vector/no-item-found-vector-flat-icon-design-illustration-web-and-mobile-application-symbol-on.jpg?s=612x612&w=0&k=20&c=j0V0ww6uBl1LwQLH0U9L7Zn81xMTZCpXPjH5qJo5QyQ="
                                            alt="No items found">
                                    </td>
                                </tr>
                            @else
                                @foreach ($searchData as $index => $record)
                                    @if ($record->status == 'Open')
                                        <tr>
                                            <td style="padding: 10px; border:none; font-size: 0.75rem; text-align: start; width: 10%; min-width: 80px;cursor: pointer;">
                                                <div class="arrow-btn" wire:click="toggleAccordion('{{ $record->id }}')">
                                                    <i class="{{ in_array($record->id, $openAccordions) ? 'fa fa-angle-up' : 'fa fa-angle-down' }}"></i>
                                                </div>
                                            </td>
                                            <td
                                                style="padding: 10px; border:none; font-size: 0.75rem; text-align: start;width: 15%; min-width: 120px;">
                                                T-{{ ($record->id) }}
                                            </td>

                                            <td
                                                style="padding: 10px; border:none; font-size: 0.75rem; text-align: start;width: 15%; min-width: 150px;">
                                                {{ ucfirst($record->task_name) }}
                                            </td>
                                            <td
                                                style="padding: 10px; border:none; font-size: 0.75rem; text-align: start;width: 15%; min-width: 170px;">
                                                {{ ucwords(strtolower($record->emp->first_name)) }}
                                                {{ ucwords(strtolower($record->emp->last_name)) }}

                                            </td>
                                            <td
                                                style="padding: 10px; border:none;font-size: 0.75rem; text-align: start; width: 15%; min-width: 150px;">

                                                {{ ucfirst($record->assignee) }}
                                            </td>
                                            <td
                                                style="padding: 10px; border:none; font-size: 0.75rem; text-align: start; width: 15%; min-width: 150px;">
                                                {{ \Carbon\Carbon::parse($record->created_at)->format('d M, Y') }}
                                            </td>
                                            <td
                                                style="padding: 10px; border:none; font-size: 0.75rem; text-align: start; width: 15%; min-width: 150px;">
                                                {{ \Carbon\Carbon::parse($record->due_date)->format('d M, Y') }}
                                            </td>
                                            <td
                                                style="padding: 10px; border:none; font-size: 0.75rem; text-align: center; width: 15%; min-width: 150px;">
                                                @if($record->reopened_date)
                                                    {{ \Carbon\Carbon::parse($record->reopened_date)->format('d M, Y') }}
                                                @else
                                                <span>-</span>

                                                @endif
                                            </td>
                                            <td
                                                style="padding: 10px; border:none; font-size: 0.75rem; text-align: center; width: 15%; min-width: 200px;">
                                                @foreach ($record->comments ?? [] as $comment)
                                                    {{ $comment->comment }}
                                                @endforeach
                                                <!-- Add Comment link to trigger modal -->
                                                <button type="button"
                                                    wire:click.prevent="openAddCommentModal('{{ $record->id }}')"
                                                    class="submit-btn" data-toggle="modal"
                                                    data-target="#exampleModalCenter">Comment</button>
                                                <button wire:click="openForTasks('{{ $record->id }}')"
                                                    style="border:1px solid rgb(2, 17, 79);width:80px; padding: 5px 0.75rem;"
                                                    class="cancel-btn">Close</button>
                                                    {{-- <div class="d-flex justify-content-center" style="gap:10px;">
                                                        <i class="fa-solid fa-comment chat-icon" title="Comment" wire:click.prevent="openAddCommentModal('{{ $record->id }}')" data-toggle="modal"  data-target="#exampleModalCenter"></i>
                                                    <i class="fa-solid fa-circle-xmark chat-icon"title="Close" wire:click="openForTasks('{{ $record->id }}')"></i>
                                                    </div> --}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="9" class="m-0 p-0"
                                                style="background-color: #fff; padding: 0; margin: 0;">
                                                <div class="accordion-content mt-0"
                                                style="display: {{ in_array($record->id, $openAccordions) ? 'block' : 'none' }}; padding: 0 10px; margin-bottom: 20px;">
                                                    <!-- Content for accordion body -->
                                                    <table class="rounded border"
                                                        style="margin-top: 20px; width: 100%; border-collapse: collapse;">
                                                        <thead class="py-0"
                                                            style="background-color: #ecf9ff; box-shadow: 1px 0px 2px 0px rgba(0, 0, 0, 0.2); border-bottom: 1px solid #ccc; padding: 5px;">
                                                            <tr style="color: #778899;">
                                                                <th
                                                                    style="font-weight: 500; width: 22%; padding: 10px; font-size: 0.75rem; text-align: center;">
                                                                    Priority</th>

                                                                <th
                                                                    style="font-weight: 500; width: 18%; padding: 10px; font-size: 0.75rem; text-align: center;">
                                                                    Followers</th>
                                                                <th
                                                                    style="font-weight: 500; width: 15%; padding: 10px; font-size: 0.75rem; text-align: center;">
                                                                    Subject</th>
                                                                <th
                                                                    style="font-weight: 500; width: 15%; padding: 10px; font-size: 0.75rem; text-align: center;">
                                                                    Description</th>
                                                                <th
                                                                    style="font-weight: 500; width: 30%; padding: 10px; font-size: 0.75rem; text-align: center;">
                                                                    Attach</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td
                                                                    style="border: none; width: 22%; padding: 10px; font-size: 0.75rem; text-align: center;">
                                                                    {{ $record->priority }}
                                                                </td>

                                                                <td
                                                                    style="border: none; width: 18%; padding: 10px; font-size: 0.75rem; text-align: center;">
                                                                    {{ ucfirst($record->followers) ?: '-' }}
                                                                </td>
                                                                <td
                                                                    style="border: none; width: 15%; padding: 10px; font-size: 0.75rem; text-align: center;">
                                                                    {{ ucfirst($record->subject ?? '-') }}
                                                                </td>
                                                                <td
                                                                    style="border: none; width: 15%; padding: 10px; font-size: 0.75rem; text-align: center;">
                                                                    {{ ucfirst($record->description ?? '-') }}
                                                                </td>
                                                                <td
                                                                    style="border: none; width: 30%; padding: 10px; font-size: 0.75rem; text-align: center;">
                                                                    {{-- @if (!empty($record->file_path) && $record->file_path !== 'null')
                                                                        <a href="#"
                                                                            wire:click="showViewFile('{{ $record->id }}')"
                                                                            style="text-decoration: none; color: #007BFF;">View
                                                                            File</a>
                                                                    @else
                                                                        N/A
                                                                    @endif --}}
                                                                    @if (!empty($record->file_path) && $record->file_path !== 'null')
                                                                    @if(strpos($record->mime_type, 'image') !== false)
                                                                    <a href="#" wire:click.prevent="showViewFile('{{ $record->id }}')"
                                                                        style="text-decoration: none; color: #007BFF;">
                                                                        View Image
                                                                    </a>
                                                                    @else
                                                                    <a href="{{ route('files.showTask', $record->id) }}" download="{{ $record->file_name }}"  style="margin-top: 10px;">
                                                                        Download file
                                                                    </a>
                                        
                                                                    @endif
                                                                    @else
                                                                    {{-- Show this message if no file is attached --}}
                                                                    <p style="color: gray;">N/A</p>
                                                                    @endif
                                                                </td>


                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <!-- Modal Structure (updated to include record ID) -->


                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>



        @endif

        @if ($activeTab == 'completed')
            <div class="filter-section" style="padding-bottom: 15px; border-radius: 5px;">
                <form wire:submit.prevent="applyFilters" class="form-inline row" style="margin-bottom: -15px;">
                    <!-- Search Box -->
                    <div class="input-group people-input-group-container">
                        <input wire:model="closedSearch" type="text" class="form-control people-search-input"
                            placeholder="Search..." aria-label="Search" aria-describedby="basic-addon1">
                        <div class="input-group-append">
                            <button wire:click="searchCompletedTasks" class="people-search-btn" type="button">
                                <i class="fa fa-search people-search-icon"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-group task-date-range-picker">

                        <livewire:date-component key="{{ 'drp-' . uniqid() }}" :start="$start" :end="$end" />
                    </div>


                </form>
            </div>
            <div class="card-body"
                style="background-color:white;width:100%;border-radius:5px;max-height:300px;overflow-y:auto;overflow-x:auto;margin-top: 10px;">

                <div class="table-responsive">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background-color: rgb(2, 17, 79); color: white;">
                                <th style="padding: 7px; font-size: 0.75rem; text-align: start; width: 7%;min-width: 80px;">
                                    <i class="fa fa-angle-down" style="color: white; padding-left: 8px;"></i>
                                </th>
                                <th style="padding: 7px; font-size: 0.75rem; text-align: start; width: 8%;min-width: 120px;">Task Id
                                </th>
                                <th style="padding: 7px; font-size: 0.75rem; text-align: start; width: 10%;min-width: 150px;">Task Name
                                </th>


                                <th style="padding: 7px; font-size: 0.75rem; text-align: start; width: 9%;min-width: 150px;">Assigned By
                                </th>
                                <th style="padding: 7px; font-size: 0.75rem; text-align: start; width: 9%;min-width: 150px;">Assignee
                                </th>
                                <th style="padding: 7px; font-size: 0.75rem; text-align: start; width: 9%;min-width: 150px;">Assigned
                                    Date</th>
                                <th style="padding: 7px; font-size: 0.75rem; text-align: start; width: 9%;min-width: 150px;">Due Date
                                </th>

                                <th style="padding: 7px; font-size: 0.75rem; text-align: start; width: 9%;min-width: 150px;">Closed
                                    Date</th>
                                <th style="padding: 7px; font-size: 0.75rem; text-align: center; width: 20%;min-width: 200px;">Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($searchData->isEmpty())
                                <tr>
                                    <td colspan="9" style="text-align: center;">
                                        <img style="width: 10em; margin: 20px;"
                                            src="https://media.istockphoto.com/id/1357284048/vector/no-item-found-vector-flat-icon-design-illustration-web-and-mobile-application-symbol-on.jpg?s=612x612&w=0&k=20&c=j0V0ww6uBl1LwQLH0U9L7Zn81xMTZCpXPjH5qJo5QyQ="
                                            alt="No items found">
                                    </td>
                                </tr>
                            @else
                                @foreach ($searchData as $record)
                                    @if ($record->status == 'Completed')
                                        <tr>
                        
                                            <td style="padding: 10px; border:none; font-size: 0.75rem; text-align: start; width: 7%;min-width: 80px;cursor: pointer;">
                                                <div class="arrow-btn" wire:click="toggleAccordion('{{ $record->id }}')">
                                                    <i class="{{ in_array($record->id, $openAccordions) ? 'fa fa-angle-up' : 'fa fa-angle-down' }}"></i>
                                                </div>
                                            </td>
                                            <td
                                            style="padding: 10px; border:none; font-size: 0.75rem; text-align: start; width: 8%;min-width: 120px;">
                                            T-{{($record->id) }}
                                        </td>
                                            <td
                                                style="padding: 10px; border:none; font-size: 0.75rem; text-align: start; width: 9%;min-width: 150px;">
                                                {{ ucfirst($record->task_name) }}
                                            </td>

                                            <td
                                                style="padding: 10px; border:none; font-size: 0.75rem; text-align: start; width: 9%;min-width: 150px;">
                                                {{ ucwords(strtolower($record->emp->first_name)) }}
                                                {{ ucwords(strtolower($record->emp->last_name)) }}
                                            </td>

                                            <td
                                                style="padding: 10px; border:none; font-size: 0.75rem; text-align: start; width: 9%;min-width: 150px;">
                                                {{ ucfirst($record->assignee) }}
                                            </td>

                                            <td
                                                style="padding: 10px; border:none; font-size: 0.75rem; text-align: start; width: 9%;min-width: 150px;">
                                                {{ \Carbon\Carbon::parse($record->created_at)->format('d M, Y') }}
                                            </td>
                                            <td
                                                style="padding: 10px; border:none; font-size: 0.75rem; text-align: start; width: 9%;min-width: 150px; color: {{ \Carbon\Carbon::parse($record->updated_at)->startOfDay()->gt(\Carbon\Carbon::parse($record->due_date)->startOfDay())? 'red': 'inherit' }};">
                                                {{ \Carbon\Carbon::parse($record->due_date)->format('d M, Y') }}
                                            </td>
                                            <td
                                                style="padding: 10px; border:none; font-size: 0.75rem; text-align: start; width: 9%;min-width: 150px;">
                                                {{ \Carbon\Carbon::parse($record->updated_at)->format('d M, Y') }}
                                            </td>
                                            <td
                                                style="padding: 10px; border:none; font-size: 0.75rem; text-align: center; width: 20%;min-width: 200px;">
                                                @foreach ($record->comments ?? [] as $comment)
                                                    {{ $comment->comment }}
                                                @endforeach
                                                <!-- Add Comment link to trigger modal -->
                                                <button type="button"
                                                    wire:click.prevent="openAddCommentModal('{{ $record->id }}')"
                                                    class="submit-btn" data-toggle="modal"
                                                    data-target="#exampleModalCenter">Comment</button>
                                                <button wire:click="closeForTasks('{{ $record->id }}')"
                                                    style="border:1px solid rgb(2,17,79); width: 80px;  padding: 5px 0.75rem;"
                                                    class="cancel-btn1">Reopen</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="9" class="m-0 p-0"
                                                style="background-color: #fff; padding: 0; margin: 0;">
                                                <div class="accordion-content mt-0"
                                                style="display: {{ in_array($record->id, $openAccordions) ? 'block' : 'none' }}; padding: 0 10px; margin-bottom: 20px;">
                                                    <!-- Content for accordion body -->
                                                    <table class="rounded border"
                                                        style="margin-top: 20px; width: 100%; border-collapse: collapse;">
                                                        <thead class="py-0"
                                                            style="background-color: #ecf9ff; box-shadow: 1px 0px 2px 0px rgba(0, 0, 0, 0.2); border-bottom: 1px solid #ccc; padding: 5px;">
                                                            <tr style="color: #778899;">
                                                                <th
                                                                    style="font-weight: 500; width: 20%; padding: 10px; font-size: 0.75rem; text-align: center;">
                                                                    Priority</th>
                                                                <th
                                                                    style="font-weight: 500; width: 20%; padding: 10px; font-size: 0.75rem; text-align: center;">
                                                                    Followers</th>
                                                                <th
                                                                    style="font-weight: 500; width: 20%; padding: 10px; font-size: 0.75rem; text-align: center;">
                                                                    Subject</th>
                                                                <th
                                                                    style="font-weight: 500; width: 20%; padding: 10px; font-size: 0.75rem; text-align: center;">
                                                                    Description</th>
                                                                <th
                                                                    style="font-weight: 500; width: 20%; padding: 10px; font-size: 0.75rem; text-align: center;">
                                                                    Attach</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td
                                                                    style="border: none; width: 20%; padding: 10px; font-size: 0.75rem; text-align: center;">
                                                                    {{ $record->priority }}
                                                                </td>
                                                                <td
                                                                    style="border: none; width: 20%; padding: 10px; font-size: 0.75rem; text-align: {{ $record->followers ? 'start' : 'center' }};">
                                                                    {{ ucfirst($record->followers) ?: '-' }}
                                                                </td>
                                                                <td
                                                                    style="border: none; width: 20%; padding: 10px; font-size: 0.75rem; text-align: center;">
                                                                    {{ ucfirst($record->subject ?? '-') }}
                                                                </td>
                                                                <td
                                                                    style="border: none; width: 20%; padding: 10px; font-size: 0.75rem; text-align: center;">
                                                                    {{ ucfirst($record->description ?? '-') }}
                                                                </td>
                                                                <td
                                                                    style="border: none; width: 20%; padding: 10px; font-size: 0.75rem; text-align: center;">
                                                                    {{-- @if (!empty($record->file_path) && $record->file_path !== 'null')
                                                                        <a href="#"
                                                                            wire:click="showViewFile('{{ $record->id }}')"
                                                                            style="text-decoration: none; color: #007BFF;">View
                                                                            File</a>
                                                                    @else
                                                                        N/A
                                                                    @endif --}}
                                                                    @if (!empty($record->file_path) && $record->file_path !== 'null')
                                                                    @if(strpos($record->mime_type, 'image') !== false)
                                                                    <a href="#" wire:click.prevent="showViewFile('{{ $record->id }}')"
                                                                        style="text-decoration: none; color: #007BFF;">
                                                                        View Image
                                                                    </a>
                                                                    @else
                                                                    <a href="{{ route('files.showTask', $record->id) }}" download="{{ $record->file_name }}"  style="margin-top: 10px;">
                                                                        Download file
                                                                    </a>
                                        
                                                                    @endif
                                                                    @else
                                                                    {{-- Show this message if no file is attached --}}
                                                                    <p style="color: gray;">N/A</p>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>

            </div>
        @endif
        @if ($showDialog)
            <div class="modal" tabindex="-1" role="dialog" style="display: block;">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header d-flex justify-content-between"
                            style="background-color: rgb(2, 17, 79); color: white; height: 40px; padding: 8px;">
                            <h5 class="modal-title" style="font-size: 15px; margin: 0;"><b>Add Task</b></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                wire:click="close"
                                style="background: none; border: none; color: white; font-size: 30px; cursor: pointer;">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div class="task-container">
                                <!-- Task Name -->
                                <div class="form-group" style="margin-bottom: 10px;">
                                    <label for="task_name" style="font-size: 13px; color: #778899;">Task Name<span
                                        style="color: var(--requiredAlert);">*</span></label>
                                    <input type="text" wire:model.debounce.0ms="task_name"
                                        wire:input="autoValidate" class="placeholder-small"
                                        placeholder="Enter task name"
                                        style="width: 100%; font-size: 0.75rem; padding: 5px; outline: none; border: 1px solid #ccc; border-radius: 5px; margin-top: 5px;">
                                    @error('task_name')
                                        <span class="text-danger">Task name is required</span>
                                    @enderror
                                </div>


                                <!-- Assignee -->
                                <div class="form-group"
                                    style="color:grey;font-size:0.75rem;cursor:pointer; margin-bottom: 10px;">
                                    <label for="assignee"
                                        style="font-size: 13px;color:#778899; margin-bottom: 10px;">Assignee<span
                                        style="color: var(--requiredAlert);">*</span></label>
                                    <br>
                                    <i wire:click="forAssignee"  wire:change="autoValidate" class="fa fa-user icon" id="profile-icon"></i>
                                    @if ($showRecipients)
                                        <strong style="font-size: 12;" >Selected assignee:
                                        </strong><span title="{{$selectedPeopleName}}">{{ $selectedPeopleName }}</span>
                                    @else
                                        <a wire:click="forAssignee"  class="hover-link" style="color:black;cursor:pointer"> Add Assignee</a>
                                    @endif <br>
                                    @error('assignee')
                                        <span class="text-danger">Assignee is required</span>
                                    @enderror
                                </div>

                                @if ($assigneeList)
                                    <div
                                        style="border-radius:5px;background-color:grey;padding:8px;width:350px;max-height:250px;overflow-y:auto; ">
                                        <div class="input-group d-flex" style="margin-bottom: 10px;">
                                            <div class="input-group people-input-group-container"
                                                style="width: 300px;padding-left: 10px;">
                                                <input wire:input="filter" wire:model.debounce.0ms="searchTerm"
                                                    type="text" class="form-control people-search-input"
                                                    placeholder="Search employee name / Id" aria-label="Search"
                                                    aria-describedby="basic-addon1">
                                                <div class="input-group-append">
                                                    <button wire:change="autoValidate" wire:click="filter"
                                                        class="people-search-btn" type="button">
                                                        <i class="fa fa-search people-search-icon"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div wire:change="autoValidate" wire:click="closeAssignee"
                                                aria-label="Close">
                                                <i class="fa fa-times"
                                                    style="font-size: 20px;margin-top: 5px;color: #fff; cursor: pointer;"
                                                    aria-hidden="true"></i>
                                            </div>
                                        </div>
                                        @if ($peopleData->isEmpty())
                                            <div class="container"
                                                style="text-align: center; color: white; font-size: 0.75rem;">No People
                                                Found
                                            </div>
                                        @else
                                            @foreach ($peopleData as $people)
                                                <div wire:click="selectPerson('{{ $people->emp_id }}')"
                                                    class="container"
                                                    style="cursor: pointer; background-color: darkgrey; padding: 5px; margin-bottom: 8px; width: 300px; border-radius: 5px;">
                                                    <div class="row align-items-center">
                                                        <label for="person-{{ $people->emp_id }}"
                                                            style="width: 100%; display: flex; align-items: center; margin: 0;">
                                                            <div class="col-auto">
                                                                <input type="radio"
                                                                    id="person-{{ $people->emp_id }}"
                                                                    wire:change="autoValidate" wire:model="assignee"
                                                                    value="{{ $people->emp_id }}">
                                                            </div>
                                                            <div class="col-auto">
                                                                @if (!empty($people->image) && $people->image !== 'null')
                                                                    <img class="profile-image"
                                                                        style="margin-left: 10px;"
                                                                        src="{{ 'data:image/jpeg;base64,' . base64_encode($people->image) }}">
                                                                @else
                                                                    @if ($people && $people->gender == 'Male')
                                                                        <img style="margin-left: 10px;"
                                                                            class="profile-image"
                                                                            src="{{ asset('images/male-default.png') }}"
                                                                            alt="Default Male Image">
                                                                    @elseif($people && $people->gender == 'Female')
                                                                        <img style="margin-left: 10px;"
                                                                            class="profile-image"
                                                                            src="{{ asset('images/female-default.jpg') }}"
                                                                            alt="Default Female Image">
                                                                    @else
                                                                        <img style="margin-left: 10px;"
                                                                            class="profile-image"
                                                                            src="{{ asset('images/user.jpg') }}"
                                                                            alt="Default Image">
                                                                    @endif
                                                                @endif

                                                            </div>
                                                            <div class="col">
                                                                <h6 class="username"
                                                                    style="font-size: 0.75rem; color: white;">
                                                                    {{ ucwords(strtolower($people->first_name)) }}
                                                                    {{ ucwords(strtolower($people->last_name)) }}
                                                                </h6>
                                                                <p class="mb-0"
                                                                    style="font-size: 0.75rem; color: white;">
                                                                    (#{{ $people->emp_id }})
                                                                </p>
                                                            </div>
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                @endif
                                <div class="row">
                                    <div class="col-md-6">
                                        @if ($selectedPersonClients->isEmpty() || $selectedPersonClients=="")
                                        @else
                                            <div style="margin-bottom: 10px;">
                                                <label style="font-size: 13px;color:#778899" for="clientSelect">Select
                                                    Client<span
                                                    style="color: var(--requiredAlert);">*</span></label>
                                                <select wire:change="showProjects"
                                                    style="width: 100%;font-size:0.75rem;padding:5px;outline:none;border:1px solid #ccc;border-radius:5px;"
                                                    id="clientSelect" wire:model="client_id">
                                                    <option value="">Select client</option>
                                                    @foreach ($selectedPersonClients as $client)
                                                        <option style="color:#778899;"
                                                            value="{{ $client->client->client_id }}">
                                                            {{ $client->client->client_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('client_id')
                                                    <span class="text-danger">Client ID is required</span>
                                                @enderror
                                            </div>
                                        @endif

                                    </div>
                                    <div class="col-md-6">
                                        @if ($selectedPersonClientsWithProjects->isEmpty())
                                        @else
                                            <div style="margin-bottom: 10px;">
                                                <label style="font-size: 13px;color:#778899" for="clientSelect">Select
                                                    Project<span
                                                    style="color: var(--requiredAlert);">*</span></label>
                                                <select wire:change="autoValidate"
                                                    style="width: 100%;font-size:0.75rem;padding:5px;outline:none;border:1px solid #ccc;border-radius:5px;"
                                                    id="clientSelect" wire:model="project_name">
                                                    <option value="">Select project</option>
                                                    @foreach ($selectedPersonClientsWithProjects as $project)
                                                        <option style="color:#778899;"
                                                            value="{{ $project->project_name }}">
                                                            {{ $project->project_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('project_name')
                                                    <span class="text-danger">Project name is
                                                        required</span>
                                                @enderror

                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Priority -->
                                <div class="priority-container" style="margin-top: 0px;">
                                    <div class="row ">
                                        <div class="col-md-4">
                                            <label for="priority"
                                                style="font-size: 13px;color:#778899; margin-left: 0px; margin-top: 0px; padding: 0 10px 0 0;">Priority</label>
                                        </div>
                                        <div class="col-md-8 mt-1">
                                            <div id="priority"
                                                style="display: flex; align-items: center; margin-top: 0px;">
                                                <div class="priority-option" style="margin-left: 0px; padding: 0;">
                                                    <input type="radio" id="low-priority" name="priority"
                                                       wire:model="priority"
                                                        value="Low">
                                                    <span
                                                        style="font-size: 0.75rem;color:#778899; padding: 0;margin-left:5px"
                                                        class="text-xs">Low</span>
                                                </div>
                                                <div class="priority-option" style="margin-left: 20px; padding: 0;">
                                                    <input type="radio" id="medium-priority" name="priority"
                                                        wire:model="priority"
                                                        value="Medium">
                                                    <span
                                                        style="font-size: 0.75rem;color:#778899; padding: 0;margin-left:5px"
                                                        class="text-xs">Medium</span>
                                                </div>
                                                <div class="priority-option" style="margin-left: 20px; padding: 0;">
                                                    <input type="radio" id="high-priority" name="priority"
                                                        wire:model="priority"
                                                        value="High">
                                                    <span
                                                        style="font-size: 0.75rem;color:#778899; padding: 0;margin-left:5px"
                                                        class="text-xs">High</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                               
                                <!-- Due Date -->
                                <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                                    <div class="col">
                                        <div class="form-group">
                                            <label class="form-label"
                                                style="font-size: 13px;color:#778899; margin-left: 0px; margin-top: 0px; padding: 0 10px 0 0;">Due
                                                Date<span
                                                style="color: var(--requiredAlert);">*</span></label>
                                            <br>
                                            <input wire:change="autoValidate" type="date" wire:model="due_date"
                                                class="placeholder-small"
                                                style="width: 100%;font-size:0.75rem;padding:5px;outline:none;border:1px solid #ccc;border-radius:5px;"
                                                min="<?= date('Y-m-d') ?>" value="<?= date('Y-m-d') ?>">
                                            @error('due_date')
                                                <span class="text-danger">Due date is required</span>
                                            @enderror

                                        </div>
                                    </div>
                                    <div class="col">
                                        <!-- Tags -->
                                        <div class="form-group">
                                            <label for="tags"
                                                style="font-size: 13px;color:#778899; margin-left: 0px; margin-top: 0px; padding: 0 10px 0 0;">Tags</label>

                                            <input wire:change="autoValidate" type="text" wire:model="tags"
                                                placeholder="Enter tags" class="placeholder-small"
                                                style="width: 100%;font-size:0.75rem;padding:6px;outline:none;border:1px solid #ccc;border-radius:5px;margin-top: 5px;">
                                        </div>
                                    </div>
                                </div>

                                <div  class="form-group"
                                    style=" color: grey; font-size: 0.75rem">
                                    <label for="assignee"
                                        style="font-size: 13px;color:#778899; margin-left: 0px; margin-top: 0px; padding: 0 10px 0 0;">Followers</label>
                                    <br>
                                    <i wire:click="forFollowers" wire:change="autoValidate" style="margin-top: 10px; cursor: pointer"
                                        class="fas fa-user icon" id="profile-icon"></i>
                                    @if ($showFollowers)
                                        <strong style="font-size: 12;">Selected Followers:
                                        </strong><span title="{{ implode(', ', array_unique($selectedPeopleNamesForFollowers)) }}">{{ implode(', ', array_unique($selectedPeopleNamesForFollowers)) }}</span>
                                    @else
                                        <a wire:click="forFollowers" class="hover-link" style="color:black;cursor:pointer"> Add Followers</a>
                                    @endif
                                </div>
                                @if ($followersList)
                                    <div
                                        style="border-radius:5px;background-color:grey;padding:8px;width:350px;max-height:250px;overflow-y:auto; ">
                                        <div class="input-group d-flex" style="margin-bottom: 10px;">
                                            <div class="input-group people-input-group-container"
                                                style="width: 300px;padding-left: 10px;">
                                                <input wire:input="filter" wire:model.debounce.0ms="searchTerm"
                                                    type="text" class="form-control people-search-input"
                                                    placeholder="Search employee name / Id" aria-label="Search"
                                                    aria-describedby="basic-addon1">
                                                <div class="input-group-append">
                                                    <button wire:change="autoValidate" wire:click="filter"
                                                        class="people-search-btn" type="button">
                                                        <i class="fa fa-search people-search-icon"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div wire:change="autoValidate" wire:click="closeFollowers"
                                                aria-label="Close">
                                                <i class="fa fa-times"
                                                    style="font-size: 20px;margin-top: 5px;color: #fff; cursor: pointer;"
                                                    aria-hidden="true"></i>
                                            </div>
                                        </div>
                                        @if ($peopleData->isEmpty())
                                            <div class="container"
                                                style="text-align: center; color: white; font-size: 0.75rem;">No People
                                                Found
                                            </div>
                                        @else
                                            @foreach ($peopleData as $people)
                                                <div wire:model="cc_to" wire:click="togglePersonSelection('{{ $people->emp_id }}')"
                                                    class="container"
                                                    style="cursor: pointer; background-color: darkgrey; padding: 5px; margin-bottom: 8px; width: 300px; border-radius: 5px;">
                                                    <div class="row align-items-center">
                                                        <div class="col-auto">
                                                            <input type="checkbox"
                                                                wire:model="selectedPeopleForFollowers"
                                                                  wire:change="updateCheckbox('{{ $people->emp_id }}')"
                                                                value="{{ $people->emp_id }}"
                                                                id="checkbox-{{ $people->emp_id }}">
                                                        </div>
                                                        <div class="col-auto">
                                                            @if (!empty($people->image) && $people->image !== 'null')
                                                                <img class="profile-image"
                                                                    src="{{ 'data:image/jpeg;base64,' . base64_encode($people->image) }}">
                                                            @else
                                                                @if ($people && $people->gender == 'Male')
                                                                    <img class="profile-image"
                                                                        src="{{ asset('images/male-default.png') }}"
                                                                        alt="Default Male Image">
                                                                @elseif($people && $people->gender == 'Female')
                                                                    <img class="profile-image"
                                                                        src="{{ asset('images/female-default.jpg') }}"
                                                                        alt="Default Female Image">
                                                                @else
                                                                    <img class="profile-image"
                                                                        src="{{ asset('images/user.jpg') }}"
                                                                        alt="Default Image">
                                                                @endif
                                                            @endif
                                                        </div>
                                                        <div class="col">
                                                            <h6 class="username"
                                                                style="font-size: 0.75rem; color: white;">
                                                                {{ ucwords(strtolower($people->first_name)) }}
                                                                {{ ucwords(strtolower($people->last_name)) }}
                                                            </h6>
                                                            <p class="mb-0"
                                                                style="font-size: 0.75rem; color: white;">
                                                                (#{{ $people->emp_id }})
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                        @endif
                                    </div>
                                @endif


                                <div class="form-group">
                                    <label for="Subject"
                                        style="font-size: 13px;color:#778899; margin-left: 0px; margin-top: 10px; padding: 0 10px 0 0;">Subject</label>
                                    <br>
                                    <input wire:change="autoValidate" wire:model="subject" class="placeholder-small"
                                        placeholder="Enter subject" rows="4"
                                        style="width: 100%;font-size:0.75rem;padding:5px;outline:none;border:1px solid #ccc;border-radius:5px;margin-top: 5px;"></input>
                                </div>
                                <!-- Description -->
                                <div class="form-group">
                                    <label for="description"
                                        style="font-size: 13px;color:#778899; margin-left: 0px; margin-top: 10px; padding: 0 10px 0 0;">Description</label>
                                    <br>
                                    <textarea wire:change="autoValidate" wire:model="description" class="placeholder-small"
                                        placeholder="Add description" rows="4"
                                        style="width: 100%;font-size:0.75rem;padding:5px;outline:none;border:1px solid #ccc;border-radius:5px;margin-top: 5px;"></textarea>
                                </div>

                                <!-- File Input -->
                                <div id="flash-message-container" style="display: none;" class="alert alert-success"
                                    role="alert"></div>
                                <div class="row">
                                    {{-- <div class="col">
                                        <label for="fileInput"
                                            style="cursor: pointer; font-size: 13px;color:#778899; margin-left: 0px; margin-top: 0px; padding: 0 10px 0 0;">
                                            Attach Image
                                        </label>
                                    </div> --}}
                                    <div class="col">
                                        <label for="fileInput" style="cursor: pointer; font-size: 13px;color:#778899; margin-left: 0px; margin-top: 0px; padding: 0 10px 0 0;">
                                            <i class="fa fa-paperclip"></i> Attach Image
                                        </label>
                                    </div>
                                    @error('file_path') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                
                            <div>
                                <input type="file" style="font-size: 0.75rem;" wire:model="file_path" id="file_path" wire:change="autoValidate" class="form-control" onchange="handleImageChange()">

                            </div>


                                {{-- <input wire:change="autoValidate" style="font-size: 0.75rem;" wire:model="image"
                                    type="file" accept="image/*" onchange="handleImageChange()"> --}}

                                <div style="text-align: center;margin-bottom:10px">
                                    <button style="margin-top: 20px;" wire:click="submit" class="submit-btn"
                                        type="button" name="link">Save
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <div class="modal-backdrop fade show blurred-backdrop"></div>
    @endif
    {{-- view file popup --}}
    @if ($showViewFileDialog)
        <div class="modal" tabindex="-1" role="dialog" style="display: block;">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title viewfile">View File</h5>
                    </div>
                    <div class="modal-body text-center">
                        <img src="{{ 'data:image/jpeg;base64,' . base64_encode($viewrecord->file_path) }}"
                            class="img-fluid" alt="Image preview"
                            >
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="submit-btn"
                            wire:click.prevent="downloadImage">Download</button>
                        <button type="button" class="cancel-btn1" wire:click="closeViewFile">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show blurred-backdrop"></div>
    @endif
    <!-- Add Comment Modal -->
    @if ($showModal)
        <div wire:ignore.self class="modal fade show" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true" style="display:block;">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-between" style="background-color: rgb(2, 17, 79); color: white; height: 40px; padding: 8px; position: relative;">
                        <h6 class="modal-title" id="exampleModalLongTitle">Add Comment</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            wire:click="closeModal" style="background: none; border: none; color: white; font-size: 30px; cursor: pointer;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="alert-container" class="d-flex justify-content-center alert-container " wire:poll.5s="hideAlert" style="position: sticky; top: 12%; z-index: 10; width: 100%;" >

                        @if ($showAlert)
                            <p class="alert alert-success" role="alert" style=" font-weight: 400;width:fit-content;padding:10px;border-radius:5px; margin-top: 20px;" >
                                {{ session('comment_message') }}
                                <span style="font-weight:500;margin:0px 10px; cursor: pointer; " wire:click='hideAlert'>x</span>
                            </p>
                        @endif
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="addComment">
                            <div class="form-group">
                                <label for="comment"
                                    style="color: #778899;font-size:13px;font-weight:500;">Comment:</label>
                                <p>
                                    <textarea class="form-control" id="comment" wire:model.lazy="newComment"
                                        wire:keydown.debounce.500ms="validateField('newComment')"></textarea>
                                </p>
                                @error('newComment')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="submit-btn" style="font-size:0.75rem;">Submit</button>
                            </div>
                        </form>
                        <div style="max-height: 300px;overflow-y:auto;">
                            @if ($taskComments->count() > 0)
                                @foreach ($taskComments as $comment)
                                    <div class="comment mb-4 mt-2">
                                        <div class="d-flex align-items-center gap-5">
                                            <div class="col-md-4 p-0 comment-details">
                                                <p style="color: #000;font-size:0.75rem;font-weight:500;margin-bottom:0;"
                                                    class="truncate-text"
                                                    title="{{ $comment->employee->full_name }}">
                                                    {{ $comment->employee->full_name }}
                                                </p>
                                            </div>
                                            <div class=" col-md-3 p-0 comment-time">
                                                <span
                                                    style="color: #778899;font-size:10px;font-weight:normal;margin-left:15px;">{{ $comment->created_at->diffForHumans() }}</span>
                                            </div>
                                            @if (Auth::guard('emp')->user()->emp_id == $comment->emp_id)
                                                <div class="col-md-2 p-0 comment-actions">
                                                    <button class="comment-btn"
                                                        wire:click="openEditCommentModal({{ $comment->id }})">
                                                        <i class="fas fa-edit"
                                                            style="color: #778899;height:7px;width:7px;"></i>
                                                    </button>
                                                    <button class="comment-btn"
                                                        wire:click="deleteComment({{ $comment->id }})">
                                                        <i class="fas fa-trash"
                                                            style="color: #778899;height:7px;width:7px;"></i>
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col p-0 comment-content">
                                            @if ($editCommentId == $comment->id)
                                                <!-- Input field for editing -->
                                                <input class="form-control" wire:model.defer="newComment"
                                                    type="text">
                                                <!-- Button to update comment -->
                                                <button class="update-btn p-1"
                                                    wire:click="updateComment({{ $comment->id }})">Update</button>
                                                <button class="btn btn-secondary p-1 m-0" wire:click="cancelEdit"
                                                    style="font-size: 0.75rem;">Cancel</button>
                                            @else
                                                <!-- Display comment content -->
                                                <p style="margin-bottom: 0;font-size:0.75rem;color:#515963;">
                                                    {{ ucfirst($comment->comment) }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    @endif
</div>




<script>

    function handleImageChange() {
        // Display a flash message
        showFlashMessage('File uploaded successfully!');
    }

    function showFlashMessage(message) {
        const container = document.getElementById('flash-message-container');
        container.textContent = message;
        container.style.fontSize = '0.75rem';
        container.style.display = 'block';

        // Hide the message after 3 seconds
        setTimeout(() => {
            container.style.display = 'none';
        }, 3000);
    }

    function updateModalImage(imageSrc, recordId) {
        const modalImage = document.querySelector(`#modalImage-${recordId}`);
        if (modalImage) {
            modalImage.src = imageSrc;
        }
    }
</script>
</div>