<div class="position-relative">
    <div wire:loading
        wire:target="open,file_path,submitHR,Catalog,activeTab,closeImageDialog,downloadImage,showImage,file_paths,createServiceRequest,createIncidentRequest">
        <div class="loader-overlay">
            <div class="loader">
                <div></div>
            </div>

        </div>
    </div>
    <div style="overflow-x:hidden">
        <div class="row ">

            <div class="d-flex border-0  align-items-center justify-content-center">
                <div class="nav-buttons d-flex justify-content-center">
                    <ul class="nav custom-nav-tabs border rounded">

                        <li class="custom-item m-0 p-0 flex-grow-1 mbl-dev-active">
                            <div href="#"
                                wire:click="$set('activeTab', 'active')"
                                class="reviewActiveButtons custom-nav-link  {{ $activeTab === 'active' ? 'active left-radius' : '' }}">
                                Active
                            </div>

                        </li>

                        <li class="pendingCustomStyles custom-item m-0 p-0 flex-grow-1">
                            <a href="#"
                                wire:click="$set('activeTab', 'pending')"
                                class="custom-nav-link {{ $activeTab === 'pending' ? 'active' : '' }}">
                                Pending
                            </a>
                        </li>

                        <li class="custom-item m-0 p-0 flex-grow-1 mbl-dev-closed">
                            <a href="#"
                                wire:click="$set('activeTab', 'closed')"
                                class="reviewClosedButtons custom-nav-link {{ $activeTab === 'closed' ? 'active' : '' }}">
                                Closed
                            </a>
                        </li>
                    </ul>
                </div>

            </div>







        </div>
        <div class="row m-0">
    
        <div class="col-md-12 mb-2" >
            <div class="newReq" style="align-items:end">
                <button class="submit-btn" wire:click="ServiceRequest">
                    Service Request
                </button>
                <button class="submit-btn" wire:click="incidentRequest">
                    Incident Request
                </button>
            </div>
        </div>
        <!-- modals for service requst -->
        @if($ServiceRequestaceessDialog)
        <div class="modal" tabindex="-1" role="dialog" style="{{ $showModal ? 'display: block;' : 'display: none;' }}">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Create Service Request</h1>
                    </div>
                    <div class="modal-body">

                        <form wire:submit.prevent="createServiceRequest" style="width:80%">

                            <div class="form-group  mt-2">
                                <label for="Name">Requested By:</label>


                                <div class="input-group mb-3">



                                    <span class="input-group-text" id="basic-addon2"><i class="fa fa-info-circle" style="color:blue"></i></span> <!-- Change label as needed -->
                                    @if($employeeDetails)
                                    <input wire:model.lazy="full_name" type="text" class="form-control" aria-describedby="basic-addon1" readonly>
                                    @else
                                    <p>No employee details found.</p>
                                    @endif
                                </div>

                            </div>


                            <!-- Short Description -->
                            <div class="form-group mt-2">
                                <label for="short_description">Short Description <span style="color:red">*</span></label>
                                <input wire:model.lazy="short_description" type="text" class="form-control" id="short_description">
                                @error('short_description') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <!-- Priority -->
                            <div class="form-group mt-2">
                                <label for="priority">Urgency <span style="color:red">*</span></label>
                                <select wire:model.lazy="priority" class="form-control" id="priority">
                                    <option value="" hidden>Select Priority</option>
                                    <option value="Low">Low</option>
                                    <option value="Medium">Medium</option>
                                    <option value="High">High</option>
                                </select>
                                @error('priority') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <!-- Description -->
                            <div class="form-group mt-2">
                                <label for="description">Please describe your issue below <span style="color:red">*</span></label>
                                <textarea wire:model.lazy="description" class="form-control" id="description"></textarea>
                                @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <!-- File Upload -->
                            <div class="row mt-2">
                                                        <div class="col">
                                                            <label for="fileInput" style="color:#778899; font-weight:500; font-size:12px; cursor:pointer;">
                                                                <i class="fa fa-paperclip"></i> Attach Image
                                                            </label>
                                                        </div>
                                                        @error('file_path') <span class="text-danger">{{ $message }}</span> @enderror
                                                    </div>

                                                    <div>
                                                    <input id="file_paths" type="file" wire:model="file_paths" multiple />

                                                    </div>
                        </form>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <div class="m-0 p-0 mt-3 d-flex gap-3 justify-content-center">
                            <button type="button" wire:click="createServiceRequest" class="submit-btn">Submit</button>
                            <button wire:click="cancelServiceRequest" type="button" class="cancel-btn" style="border:1px solid rgb(2,17,79);">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show blurred-backdrop" style="{{ $showModal ? '' : 'display: none;' }}"></div>
        @endif
        <!-- modals for incident requst -->
        @if($incidentRequestaceessDialog)
        <div class="modal" tabindex="-1" role="dialog" style="{{ $showModal ? 'display: block;' : 'display: none;' }}">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Create Incident Request</h1>
                    </div>
                    <div class="modal-body">

                        <form wire:submit.prevent="createIncidentRequest" style="width:80%">

                            <div class="form-group  mt-2">
                                <label for="Name">Requested By:</label>


                                <div class="input-group mb-3">



                                    <span class="input-group-text" id="basic-addon2"><i class="fa fa-info-circle" style="color:blue"></i></span> <!-- Change label as needed -->
                                    @if($employeeDetails)
                                    <input wire:model.lazy="full_name" type="text" class="form-control" aria-describedby="basic-addon1" readonly>
                                    @else
                                    <p>No employee details found.</p>
                                    @endif
                                </div>

                            </div>


                            <!-- Short Description -->
                            <div class="form-group mt-2">
                                <label for="short_description">Short Description <span style="color:red">*</span></label>
                                <input wire:model.lazy="short_description" type="text" class="form-control" id="short_description">
                                @error('short_description') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <!-- Priority -->
                            <div class="form-group mt-2">
                                <label for="priority">Urgency <span style="color:red">*</span></label>
                                <select wire:model.lazy="priority" class="form-control" id="priority">
                                    <option value="" hidden>Select Priority</option>
                                    <option value="Low">Low</option>
                                    <option value="Medium">Medium</option>
                                    <option value="High">High</option>
                                </select>
                                @error('priority') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <!-- Description -->
                            <div class="form-group mt-2">
                                <label for="description">Please describe your issue below <span style="color:red">*</span></label>
                                <textarea wire:model.lazy="description" class="form-control" id="description"></textarea>
                                @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <!-- File Upload -->
                            <div class="row mt-2">
                                                        <div class="col">
                                                            <label for="fileInput" style="color:#778899; font-weight:500; font-size:12px; cursor:pointer;">
                                                                <i class="fa fa-paperclip"></i> Attach Image
                                                            </label>
                                                        </div>
                                                        @error('file_path') <span class="text-danger">{{ $message }}</span> @enderror
                                                    </div>

                                                    <div>
                                                    <input id="file_paths" type="file" wire:model="file_paths" multiple />

                                                    </div>

                        </form>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <div class="m-0 p-0 mt-3 d-flex gap-3 justify-content-center">
                            <button type="button" wire:click="createIncidentRequest" class="submit-btn">Submit</button>
                            <button wire:click="cancelIncidentRequest" type="button" class="cancel-btn" style="border:1px solid rgb(2,17,79);">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show blurred-backdrop" style="{{ $showModal ? '' : 'display: none;' }}"></div>
        @endif
    </div>


        @if ($activeTab == "active")
        <div class="row align-items-center " style="margin-top:50px">
            <div class="col-12 col-md-3  ">
                <div class="input-group task-input-group-container">
                    <input wire:input="searchActiveHelpDesk" wire:model="activeSearch" type="text"
                        class="form-control task-search-input" placeholder="Search..." aria-label="Search"
                        aria-describedby="basic-addon1">
                    <div class="input-group-append">
                        <button wire:click="searchActiveHelpDesk" class="task-search-btn" type="button">
                            <i class="fa fa-search task-search-icon"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3 " style="margin-top:-5px">
            <select wire:model="activeCategory" wire:change="searchActiveHelpDesk" id="activeCategory" class="form-select" style="height:33px; font-size:0.8rem;">
    <option value="" class="option-default">Select Request</option>
    <option value="Service Request" class="option-item">Service Request</option>
    <option value="Incident Request" class="option-item">Incident Request</option>
</select>

            </div>
        </div>



        <div class="help-desk-table">

        <table class="help-desk-table-main">
    <thead class="help">
        <tr class="help-desk-table-row">
            <th class="help-desk-table-column">Request Raised By</th>
            <th class="help-desk-table-column">Request ID</th>
            <th class="help-desk-table-column">Category</th>
            <th class="help-desk-table-column">Short Description</th>
       
            <th class="help-desk-table-column">Description</th>
            <th class="help-desk-table-column">Attach Files</th>
            <th class="help-desk-table-column">Priority</th>
            <th class="help-desk-table-column">Status</th>
        </tr>
    </thead>
    <tbody>
        @if ($searchData && $searchData->whereIn('status_code', [8,10])->isEmpty())
        <tr>
            <td colspan="8" style="text-align: center; border: none;">
                <img style="width: 10em; margin: 20px;" src="https://media.istockphoto.com/id/1357284048/vector/no-item-found-vector-flat-icon-design-illustration-web-and-mobile-application-symbol-on.jpg?s=612x612&w=0&k=20&c=j0V0ww6uBl1LwQLH0U9L7Zn81xMTZCpXPjH5qJo5QyQ=" alt="No items found">
            </td>
        </tr>
        @else
        @foreach ($searchData->whereIn('status_code', [8,10])->sortByDesc('created_at') as $index => $record)
        <tr class="helpdesk-main" style="background-color: white; border-bottom: none;">
            <td class="helpdesk-request">
                {{ ucfirst(strtolower($record->emp->first_name)) }} {{ ucfirst(strtolower($record->emp->last_name)) }} <br>
                <strong style="font-size: 10px;">({{ $record->emp_id }})</strong>
            </td>
            <td class="helpdesk-request">
                {{ $record->snow_id ?? '-' }}
            </td>
            <td class="helpdesk-request">
                {{ $record->category ?? '-' }}
            </td>
            <td class="helpdesk-request">
                {{ $record->short_description ?? '-' }}
            </td>
          
            <td class="helpdesk-request">
                {{ $record->description ?? '-' }}
            </td>
            <td class="helpdesk-request">
    {{-- Process images and files --}}
    @php
        // Check if file_paths is empty or null
        $fileDataArray = isset($record->file_paths) && !empty($record->file_paths) 
            ? (is_string($record->file_paths) 
                ? json_decode($record->file_paths, true) 
                : $record->file_paths)
            : '-';

        // If fileDataArray is not an empty array, separate images and files
        $images = ($fileDataArray !== '-' && is_array($fileDataArray)) 
            ? array_filter(
                $fileDataArray,
                fn($fileData) => strpos($fileData['mime_type'], 'image') !== false
            )
            : [];

        $files = ($fileDataArray !== '-' && is_array($fileDataArray)) 
            ? array_filter(
                $fileDataArray,
                fn($fileData) => strpos($fileData['mime_type'], 'image') === false
            )
            : [];
    @endphp

    {{-- Modal to display the images --}}
    @if ($fileDataArray !== '-' && !empty($images) && count($images) > 1)
        <a href="#" wire:click.prevent="showViewImage({{ $record->id }})" class="anchorTagDetails">View Images</a>
    @elseif ($fileDataArray !== '-' && !empty($images) && count($images) == 1)
        <a href="#" wire:click.prevent="showViewImage({{ $record->id }})" class="anchorTagDetails">View Image</a>
    @endif

    {{-- Modal to display the images --}}
    @if ($showViewImageDialog && $recordId == $record->id && $fileDataArray !== '-' && !empty($images))
        <div class="modal custom-modal d-block" tabindex="-1" role="dialog">
            <div class="modal-dialog custom-modal-dialog custom-modal-dialog-centered custom-modal-lg" role="document">
                <div class="modal-content custom-modal-content">
                    <div class="modal-header custom-modal-header">
                        <h5 class="modal-title view-file">View Image</h5>
                    </div>

                    <div class="modal-body custom-modal-body">
                        <div id="imageCarousel" class="carousel slide">
                            <div class="carousel-inner">
                                @foreach ($images as $index => $image)
                                    <div class="carousel-item {{ $currentImageIndex == $index ? 'active' : '' }}">
                                        <img src="data:{{ $image['mime_type'] }};base64,{{ $image['data'] }}" 
                                            alt="{{ $image['original_name'] }}" 
                                            style="width:100%; height:auto;" />
                                    </div>
                                @endforeach
                            </div>

                            {{-- Carousel Controls --}}
                            <button wire:click="setActiveImageIndex({{ ($currentImageIndex - 1 + count($images)) % count($images) }})" 
                                    class="carousel-control-prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button wire:click="setActiveImageIndex({{ ($currentImageIndex + 1) % count($images) }})" 
                                    class="carousel-control-next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>

                    <div class="modal-footer custom-modal-footer">
                        <button wire:click="downloadAllImages" type="button" class="submit-btn">Download All Images</button>
                        <button wire:click="downloadActiveImage" type="button" class="submit-btn">Download Active Image</button>
                        <button type="button" class="cancel-btn1" wire:click="closeViewImage">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show blurred-backdrop"></div>
    @endif

    {{-- File Modal --}}
    @if ($fileDataArray !== '-' && !empty($files) && count($files) > 1)
        <a href="{{ route('incident.files.zip', ['id' => $record->id]) }}" class="anchorTagDetails">Download Files</a>
    @elseif ($fileDataArray !== '-' && !empty($files) && count($files) == 1)
        @foreach ($files as $file)
            @php
                $base64File = trim($file['data'] ?? '');
                $mimeType = $file['mime_type'] ?? 'application/octet-stream'; // Default MIME type
                $originalName = $file['original_name'] ?? 'download.pdf'; // Default file name
            @endphp
            <a href="data:{{ $mimeType }};base64,{{ $base64File }}" download="{{ $originalName }}" class="anchorTagDetails">Download File</a>
        @endforeach
    @endif

    {{-- Display message when no files or images are present --}}
    @if ($fileDataArray === '-' || (empty($images) && empty($files)))
        <p>-</p>
    @endif
</td>
            <td class="helpdesk-request">
                {{ $record->priority ?? '-' }}
            </td>
            <td class="helpdesk-request">
    @if ($record->status_code == 10)
        <span style="color: green;">{{ $record->status->status_name ?? '-' }}</span>
    @elseif ($record->status_code == 8)
        <span style="color: orange;">{{ $record->status->status_name ?? '-' }}</span>
    @else
        {{$record->status->status_name->status_name ?? '-' }}
    @endif
</td>

        </tr>
     
        @endforeach
    
   
        @endif
    </tbody>
    <tbody>

    </tbody>
    
</table>

        </div>
        @endif










        @if ($activeTab == "closed")
        <div class="row align-items-center" style="margin-top:50px">

            <div class="col-12 col-md-3 ">
                <div class="input-group task-input-group-container">
                    <input wire:input="searchClosedHelpDesk" wire:model="closedSearch" type="text"
                        class="form-control task-search-input" placeholder="Search..." aria-label="Search"
                        aria-describedby="basic-addon1">
                    <div class="input-group-append">
                        <button wire:click="searchClosedHelpDesk" class="task-search-btn" type="button">
                            <i class="fa fa-search task-search-icon"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-3" style="margin-top:-5px">
            <select wire:model="closedCategory" wire:change="searchClosedHelpDesk" id="closedCategory" class="form-select" style="height:33px; font-size:0.8rem;">
    <option value="" class="option-default">Select Request</option>
    <option value="Service Request" class="option-item">Service Request</option>
    <option value="Incident Request" class="option-item">Incident Request</option>
</select>
            </div>
        </div>
        <div class="help-desk-table">

            <table class="help-desk-table-main">
                <thead>
                    <tr class="help-desk-table-row">
                        <th class="help-desk-table-column">Request Raised By</th>
                        <th class="help-desk-table-column">Request ID</th>
                        <th class="help-desk-table-column">Short Description</th>
                      
                        <th class="help-desk-table-column">Description</th>
                        <th class="help-desk-table-column">Attach Files</th>
                        <th class="help-desk-table-column">Priority</th>
                        <th class="help-desk-table-column">Status</th> <!-- Added Status Column -->
                    </tr>
                </thead>
                <tbody>
                    @if($searchData && $searchData->whereIn('status_code', [11,3])->isEmpty())
                    <tr class="search-data">
                        <td colspan="7" style="text-align: center; border:none;">
                            <img style="width: 10em; margin: 20px;"
                                src="https://media.istockphoto.com/id/1357284048/vector/no-item-found-vector-flat-icon-design-illustration-web-and-mobile-application-symbol-on.jpg?s=612x612&w=0&k=20&c=j0V0ww6uBl1LwQLH0U9L7Zn81xMTZCpXPjH5qJo5QyQ="
                                alt="No items found">
                        </td>
                    </tr>
                    @else
                    @foreach ($searchData->sortByDesc('created_at') as $index => $record)
                    @if($record->status_code == 11 || $record->status_code == 3)
                    <tr style="background-color: white;">
                        <td class="helpdesk-request">
                            {{ ucfirst(strtolower($record->emp->first_name)) }} {{ ucfirst(strtolower($record->emp->last_name)) }} <br>
                            <strong style="font-size: 10px;">({{ $record->emp_id }})</strong>
                        </td>
                        <td class="helpdesk-request">
                            {{ $record->snow_id ?? '-' }}
                        </td>
                        <td class="helpdesk-request">
                            {{ $record->short_description ?? '-' }}
                        </td>
                    
                        <td class="helpdesk-request">
                            {{ $record->description ?? '-' }}
                        </td>
                        <td class="helpdesk-request">
    {{-- Process images and files --}}
    @php
        // Check if file_paths is empty or null
        $fileDataArray = isset($record->file_paths) && !empty($record->file_paths) 
            ? (is_string($record->file_paths) 
                ? json_decode($record->file_paths, true) 
                : $record->file_paths)
            : '-';

        // If fileDataArray is not an empty array, separate images and files
        $images = ($fileDataArray !== '-' && is_array($fileDataArray)) 
            ? array_filter(
                $fileDataArray,
                fn($fileData) => strpos($fileData['mime_type'], 'image') !== false
            )
            : [];

        $files = ($fileDataArray !== '-' && is_array($fileDataArray)) 
            ? array_filter(
                $fileDataArray,
                fn($fileData) => strpos($fileData['mime_type'], 'image') === false
            )
            : [];
    @endphp

    {{-- Modal to display the images --}}
    @if ($fileDataArray !== '-' && !empty($images) && count($images) > 1)
        <a href="#" wire:click.prevent="showViewImage({{ $record->id }})" class="anchorTagDetails">View Images</a>
    @elseif ($fileDataArray !== '-' && !empty($images) && count($images) == 1)
        <a href="#" wire:click.prevent="showViewImage({{ $record->id }})" class="anchorTagDetails">View Image</a>
    @endif

    {{-- Modal to display the images --}}
    @if ($showViewImageDialog && $recordId == $record->id && $fileDataArray !== '-' && !empty($images))
        <div class="modal custom-modal d-block" tabindex="-1" role="dialog">
            <div class="modal-dialog custom-modal-dialog custom-modal-dialog-centered custom-modal-lg" role="document">
                <div class="modal-content custom-modal-content">
                    <div class="modal-header custom-modal-header">
                        <h5 class="modal-title view-file">View Image</h5>
                    </div>

                    <div class="modal-body custom-modal-body">
                        <div id="imageCarousel" class="carousel slide">
                            <div class="carousel-inner">
                                @foreach ($images as $index => $image)
                                    <div class="carousel-item {{ $currentImageIndex == $index ? 'active' : '' }}">
                                        <img src="data:{{ $image['mime_type'] }};base64,{{ $image['data'] }}" 
                                            alt="{{ $image['original_name'] }}" 
                                            style="width:100%; height:auto;" />
                                    </div>
                                @endforeach
                            </div>

                            {{-- Carousel Controls --}}
                            <button wire:click="setActiveImageIndex({{ ($currentImageIndex - 1 + count($images)) % count($images) }})" 
                                    class="carousel-control-prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button wire:click="setActiveImageIndex({{ ($currentImageIndex + 1) % count($images) }})" 
                                    class="carousel-control-next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>

                    <div class="modal-footer custom-modal-footer">
                        <button wire:click="downloadAllImages" type="button" class="submit-btn">Download All Images</button>
                        <button wire:click="downloadActiveImage" type="button" class="submit-btn">Download Active Image</button>
                        <button type="button" class="cancel-btn1" wire:click="closeViewImage">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show blurred-backdrop"></div>
    @endif

    {{-- File Modal --}}
    @if ($fileDataArray !== '-' && !empty($files) && count($files) > 1)
        <a href="{{ route('incident.files.zip', ['id' => $record->id]) }}" class="anchorTagDetails">Download Files</a>
    @elseif ($fileDataArray !== '-' && !empty($files) && count($files) == 1)
        @foreach ($files as $file)
            @php
                $base64File = trim($file['data'] ?? '');
                $mimeType = $file['mime_type'] ?? 'application/octet-stream'; // Default MIME type
                $originalName = $file['original_name'] ?? 'download.pdf'; // Default file name
            @endphp
            <a href="data:{{ $mimeType }};base64,{{ $base64File }}" download="{{ $originalName }}" class="anchorTagDetails">Download File</a>
        @endforeach
    @endif

    {{-- Display message when no files or images are present --}}
    @if ($fileDataArray === '-' || (empty($images) && empty($files)))
        <p>-</p>
    @endif
</td>
                        <td class="helpdesk-request">
                            {{ $record->priority ?? '-' }}
                        </td>
                        <td class="helpdesk-request @if($record->status_code == 3) rejectColor @elseif($record->status_code == 11) approvedColor @endif">
    @if($record->status_code == 3)
        {{ ucfirst($record->status->status_name ?? '-') }}<br>
        @if($record->rejection_reason)
            <!-- If rejection_reason is not null, show the View Reason link -->
            <a href="#" wire:click.prevent="showRejectionReason('{{ $record->id }}')" class="anchorTagDetails">
                View Reason
            </a>
        @else
            <!-- If rejection_reason is null, show "No Reason" -->
           <p class="helpdesk-request">No Reason</p> 
        @endif
    @elseif($record->status_code == 11)
        {{ ucfirst($record->status->status_name?? '-') }}
    @endif
</td>

<!-- Modal for Rejection Reason -->
<div>
    @if($isOpen)
        <div class="modal" style="display: block; background-color: rgba(0, 0, 0, 0.5);">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Rejection Reason</h5>
                    </div>
                    <div class="modal-body">
                        {{ $rejection_reason ?? 'No Reason' }}  <!-- Show "No Reason" if rejection_reason is null -->
                    </div>
                    <div class="modal-footer d-flex align-items-center justify-content-center">
                        <div class="d-flex align-items-center justify-content-center">
                            <button type="button" class="cancel-btn" wire:click="closeModal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>





        </tr>


        @endif
        @endforeach
     
        @endif
        </tbody>
        </table>


    </div>
    @endif



    @if ($activeTab == "pending")
    <div class="row align-items-center" style="margin-top:50px">
        <div class="col-12 col-md-3 ">
            <div class="input-group task-input-group-container">
                <input wire:input="searchPendingHelpDesk" wire:model="pendingSearch" type="text"
                    class="form-control task-search-input" placeholder="Search..." aria-label="Search"
                    aria-describedby="basic-addon1">
                <div class="input-group-append">
                    <button wire:click="searchPendingHelpDesk" class="task-search-btn" type="button">
                        <i class="fa fa-search task-search-icon"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3" style="margin-top:-2px">
        <select wire:model="pendingCategory" wire:change="searchPendingHelpDesk" id="pendingCategory" class="form-select" style="height:33px; font-size:0.8rem;">
    <option value="" class="option-default">Select Request</option>
    <option value="Service Request" class="option-item">Service Request</option>
    <option value="Incident Request" class="option-item">Incident Request</option>
</select>
        </div>
    </div>
    <div class="help-desk-table">
        <table class="help-desk-table-main">
        <thead>
                    <tr class="help-desk-table-row">
                        <th class="help-desk-table-column">Request Raised By</th>
                        <th class="help-desk-table-column">Request ID</th>
                        <th class="help-desk-table-column">Short Description</th>
                      
                        <th class="help-desk-table-column">Description</th>
                        <th class="help-desk-table-column">Attach Files</th>
                        <th class="help-desk-table-column">Priority</th>
                        <th class="help-desk-table-column">Status</th> <!-- Added Status Column -->
                    </tr>
                </thead>
            <tbody>
                @if($searchData->where('status_code', 5)->isEmpty())
                <tr class="search-data">
                    <td colspan="7" style="text-align: center; border:none">
                        <img style="width: 10em; margin: 20px;" src="https://media.istockphoto.com/id/1357284048/vector/no-item-found-vector-flat-icon-design-illustration-web-and-mobile-application-symbol-on.jpg?s=612x612&w=0&k=20&c=j0V0ww6uBl1LwQLH0U9L7Zn81xMTZCpXPjH5qJo5QyQ=" alt="No items found">
                    </td>
                </tr>
                @else
                @foreach ($searchData->whereIn('status_code', 5)->sortByDesc('created_at') as $index => $record)
                <tr style="background-color: white;">
                        <td class="helpdesk-request">
                            {{ ucfirst(strtolower($record->emp->first_name)) }} {{ ucfirst(strtolower($record->emp->last_name)) }} <br>
                            <strong style="font-size: 10px;">({{ $record->emp_id }})</strong>
                        </td>
                        <td class="helpdesk-request">
                            {{ $record->snow_id ?? '-' }}
                        </td>
                        <td class="helpdesk-request">
                            {{ $record->short_description ?? '-' }}
                        </td>
                    
                        <td class="helpdesk-request">
                            {{ $record->description ?? '-' }}
                        </td>
                        <td class="helpdesk-request">
    {{-- Process images and files --}}
    @php
        // Check if file_paths is empty or null
        $fileDataArray = isset($record->file_paths) && !empty($record->file_paths) 
            ? (is_string($record->file_paths) 
                ? json_decode($record->file_paths, true) 
                : $record->file_paths)
            : '-';

        // If fileDataArray is not an empty array, separate images and files
        $images = ($fileDataArray !== '-' && is_array($fileDataArray)) 
            ? array_filter(
                $fileDataArray,
                fn($fileData) => strpos($fileData['mime_type'], 'image') !== false
            )
            : [];

        $files = ($fileDataArray !== '-' && is_array($fileDataArray)) 
            ? array_filter(
                $fileDataArray,
                fn($fileData) => strpos($fileData['mime_type'], 'image') === false
            )
            : [];
    @endphp

    {{-- Modal to display the images --}}
    @if ($fileDataArray !== '-' && !empty($images) && count($images) > 1)
        <a href="#" wire:click.prevent="showViewImage({{ $record->id }})" class="anchorTagDetails">View Images</a>
    @elseif ($fileDataArray !== '-' && !empty($images) && count($images) == 1)
        <a href="#" wire:click.prevent="showViewImage({{ $record->id }})" class="anchorTagDetails">View Image</a>
    @endif

    {{-- Modal to display the images --}}
    @if ($showViewImageDialog && $recordId == $record->id && $fileDataArray !== '-' && !empty($images))
        <div class="modal custom-modal d-block" tabindex="-1" role="dialog">
            <div class="modal-dialog custom-modal-dialog custom-modal-dialog-centered custom-modal-lg" role="document">
                <div class="modal-content custom-modal-content">
                    <div class="modal-header custom-modal-header">
                        <h5 class="modal-title view-file">View Image</h5>
                    </div>

                    <div class="modal-body custom-modal-body">
                        <div id="imageCarousel" class="carousel slide">
                            <div class="carousel-inner">
                                @foreach ($images as $index => $image)
                                    <div class="carousel-item {{ $currentImageIndex == $index ? 'active' : '' }}">
                                        <img src="data:{{ $image['mime_type'] }};base64,{{ $image['data'] }}" 
                                            alt="{{ $image['original_name'] }}" 
                                            style="width:100%; height:auto;" />
                                    </div>
                                @endforeach
                            </div>

                            {{-- Carousel Controls --}}
                            <button wire:click="setActiveImageIndex({{ ($currentImageIndex - 1 + count($images)) % count($images) }})" 
                                    class="carousel-control-prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button wire:click="setActiveImageIndex({{ ($currentImageIndex + 1) % count($images) }})" 
                                    class="carousel-control-next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>

                    <div class="modal-footer custom-modal-footer">
                        <button wire:click="downloadAllImages" type="button" class="submit-btn">Download All Images</button>
                        <button wire:click="downloadActiveImage" type="button" class="submit-btn">Download Active Image</button>
                        <button type="button" class="cancel-btn1" wire:click="closeViewImage">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show blurred-backdrop"></div>
    @endif

    {{-- File Modal --}}
    @if ($fileDataArray !== '-' && !empty($files) && count($files) > 1)
        <a href="{{ route('incident.files.zip', ['id' => $record->id]) }}" class="anchorTagDetails">Download Files</a>
    @elseif ($fileDataArray !== '-' && !empty($files) && count($files) == 1)
        @foreach ($files as $file)
            @php
                $base64File = trim($file['data'] ?? '');
                $mimeType = $file['mime_type'] ?? 'application/octet-stream'; // Default MIME type
                $originalName = $file['original_name'] ?? 'download.pdf'; // Default file name
            @endphp
            <a href="data:{{ $mimeType }};base64,{{ $base64File }}" download="{{ $originalName }}" class="anchorTagDetails">Download File</a>
        @endforeach
    @endif

    {{-- Display message when no files or images are present --}}
    @if ($fileDataArray === '-' || (empty($images) && empty($files)))
        <p>-</p>
    @endif
</td>
                        <td class="helpdesk-request">
                            {{ $record->priority ?? '-' }}
                        </td>
                        <td class="helpdesk-request">
                        @if ($record->status_code == 5)
                        <span style="color: orange;">{{ $record->status->status_name ??'-' }}</span>

                        @endif
                    </td>

<!-- Modal for Rejection Reason -->






        </tr>


                @endforeach
                
                @endif
            </tbody>
        </table>


    </div>
    @endif
</div>
</div>