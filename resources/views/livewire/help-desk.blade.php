<div class="position-relative">
<div wire:loading
        wire:target="open,file_path,submitHR,Catalog,activeTab,closeImageDialog,downloadImage,showImage,">
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
        <div class="d-flex flex-row justify-content-end mt-2 mb-2">




            <div class="mx-2 ">
            <button wire:click="Catalog" class="helpdesk-btn"> IT Request </button>

            </div>


            <div class="mx-2 ">
                <button wire:click="open"  class="helpdesk-btn"> HR Request </button>
            </div>

            <div>

            </div>
        </div>

        @if($showDialog)
        <div class="modal" tabindex="-1" role="dialog" style="display: block;overflow-y:auto;">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header helpdesk-modal align-items-center">
                        <h5  class="modal-title helpdesk-title"><b>HR Request</b></h5>

                        </button>
                    </div>
                    <div class="modal-body">

         
                        <label for="category" class="helpdesk-label">Category <span style="color:red">*</span></label>
                        <div class="input" type="" class="form-control placeholder-small">
                            <div style="position: relative;">
                                <select wire:model.lazy="category" wire:keydown.debounce.500ms="validateField('category')" id="category" style="font-size: 12px;" class="form-control placeholder-small">
                                    <option style="color: #778899; " value="" hidden >Select Category</option>
                                    <optgroup label="HR">

                                        <option value="Employee Information">Employee Information</option>
                                        <option value="Hardware Maintenance">Hardware Maintenance</option>
                                        <option value="Incident Report">Incident Report</option>
                                        <option value="Privilege Access Request">Privilege Access Request</option>
                                        <option value="Security Access Request">Security Access Request</option>
                                        <option value="Technical Support">Technical Support</option>
                                        <!-- Add more HR-related options as needed -->
                                    </optgroup>
                                </select>
                                @error('category') <span class="text-danger">{{ $message }}</span> @enderror
                              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" 
         class="bi bi-caret-down" viewBox="0 0 16 16" style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); pointer-events: none;align-items :center">
        <path d="M3.204 5h9.592L8 10.481 3.204 5z"/></svg>




                            </div>
                        </div>

                        <div class="form-group mt-2">
                            <label for="subject" class="helpdesk-label">Subject <span style="color: red;">*</span></label>
                            <input type="text" wire:model.lazy="subject" wire:keydown.debounce.500ms="validateField('subject')" id="subject" class="form-control placeholder-small" placeholder="Enter subject" style="font-family: Montserrat, sans-serif;">
                            @error('subject') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group mt-2">
                            <label for="description" class="helpdesk-label" >Description <span style="color: red;">*</span></label>
                            <textarea id="description" wire:model.lazy="description" wire:keydown.debounce.500ms="validateField('description')" id="description" class="form-control" placeholder="Enter description" rows="4" style="font-family: Montserrat, sans-serif;"></textarea>

                            @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="row mt-2">
                            <div class="col">
                                <label for="fileInput" class="helpdesk-label" >
                                    <i class="fa fa-paperclip"></i> Attach Image
                                </label>
                            </div>
                            @error('file_path') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <input type="file" wire:model="file_path" class="form-control">

                        </div>



                        <div class="form-group mt-2">
                            <label for="priority" class="helpdesk-label">Priority<span style="color:red">*</span></label>
                            <div class="input" class="form-control placeholder-small">
                                <div style="position: relative;">
                                    <select name="priority" id="priority" wire:keydown.debounce.500ms="validateField('priority')" wire:model.lazy="priority" style="font-size: 12px; " class="form-control placeholder-small">
                                        <option style="color: grey;" value="" hidden >Select Priority</option>
                                        <option value="High">High</option>
                                        <option value="Low">Low</option>
                                        <option value="Medium">Medium</option>
                                    </select>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" 
         class="bi bi-caret-down" viewBox="0 0 16 16" style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); pointer-events: none;align-items :center">
        <path d="M3.204 5h9.592L8 10.481 3.204 5z"/>
    </svg>
                                </div>
                            </div>
                            @error('priority') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="row" style="margin-top: 10px;">
                            <div class="col">
                                <div class="row m-0 p-0">
                                    <div class="row m-0 p-0">
                                        <div style="margin: 0px; padding: 0;">
                                            <div>

                                                <div class="select-ccto">
                                                    Select CC To: {{ implode(', ', array_unique($selectedPeopleNames)) }}
                                                </div>
                                                @if (session()->has('selecterror'))
    <div class="alert alert-danger">
        {{ session('selecterror') }}
    </div>
@endif
                                            </div>
                                            <button type="button"  class="add-button" wire:click="toggleRotation">
                                                <div class="icon-container">
                                                    <i class="fas fa-plus" style="color: #778899;"></i>
                                                </div>
                                            </button>
                                            <span style="color: #778899; font-size: 12px;">Add</span>
                                        </div>
                                        @error('cc_to') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
   

                                @if($isRotated)
                                <div class="helpdesk-rotate" >
                                    <div class="input-group3 helpdesk-container" >
                                        <input
                                            wire:model="searchTerm"
                                    
                                            type="text"
                                            class="form-control helpdesk-search-term"
                                            placeholder="Search for Emp.Name or ID"
                                            aria-label="Search"
                                            aria-describedby="basic-addon1"  >
                                        <div class="input-group-append" style="display: flex; align-items: center;">
                                            <button wire:click="filter" class="helpdesk-search-btn" type="button">
                                                <i style="text-align: center;color:white;margin-left:10px" class="fa fa-search"></i>
                                            </button>
                                            <button
                                                wire:click="closePeoples"
                                                type="button"
                                                class="close hepldesk-close-people rounded px-1 py-0"
                                                aria-label="Close"
                                              >
                                                <span aria-hidden="true" style="color: white; font-size: 24px; line-height: 0;">×</span>
                                            </button>
                                        </div>
                                    </div>

                                    @if ($peopleData && $peopleData->isEmpty())
                                    <div class="container" style="text-align: center; color: white; font-size: 12px; margin-top: 5px">
                                        No People Found
                                    </div>
                                    @else
                                    @foreach($peopleData->sortBy(function($person) {
                                    return $person->first_name . ' ' . $person->last_name;
                                    }) as $people)
                                    <label wire:click="selectPerson('{{ $people->emp_id }}')" class="container" style="cursor: pointer; background-color: darkgrey; padding: 5px; margin-bottom: 8px; width: 300px; border-radius: 5px; margin-top: 5px">
                                        <div class="row align-items-center">
                                            <div class="col-auto">

                                                <input type="checkbox" id="person-{{ $people->emp_id }}" wire:model="selectedPeople" value="{{ $people->emp_id }}" {{ $people->isChecked ? 'checked' : '' }}   class="form-check-input custom-checkbox-helpdesk">
                                            </div>

                                            <div class="col-auto">
                                                @if (!empty($people->image) && $people->image !== 'null')
                                                <img class="profile-image" src="data:image/jpeg;base64,{{($people->image) }}">
                                                @else
                                                @if ($people->gender === 'Male')
                                                <img class="profile-image" src="{{ asset('images/male-default.png') }}" alt="Default Male Image">
                                                @elseif($people->gender === 'Female')
                                                <img class="profile-image" src="{{ asset('images/female-default.jpg') }}" alt="Default Female Image">
                                                @else
                                                <img class="profile-image" src="{{ asset('images/user.jpg') }}" alt="Default Image">
                                                @endif
                                                @endif
                                            </div>
                                            <div class="col">
                                                <h6 class="username" style="font-size: 12px; color: white;">{{ ucwords(strtolower($people->first_name)) }} {{ ucwords(strtolower($people->last_name)) }}</h6>
                                                <p class="mb-0" style="font-size: 12px; color: white;">(#{{ $people->emp_id }})</p>
                                            </div>
                                        </div>
                                    </label>
                                    @endforeach
                                    @endif
                                </div>
                                @endif

                            </div>
                        </div>


                        <div class="ml-0 p-0 mt-3 d-flex gap-3 justify-content-center">
                            <button wire:click="submitHR" class="submit-btn" type="button">Submit</button>
                            <button wire:click="close" class="cancel-btn" type="button" style="border: 1px solid rgb(2, 17, 79);">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show blurred-backdrop"></div>
        @endif


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
                <option value="" class="option-default" hidden>Select Request</option>
    @foreach($requestCategories as $request => $categories)
    <option value="{{ $request }}" class="option-item">{{ $request }}</option>
  
                    @endforeach
                </select>
            </div>
        </div>



        <div class="help-desk-table">


            <table class="help-desk-table-main" >
                <thead class="help">
                    <tr class="help-desk-table-row" >
                        <th class="help-desk-table-column" >Request Raised By</th>
                        <th class="help-desk-table-column" >Request ID</th>
                        <th class="help-desk-table-column" >Category</th>
                        <th class="help-desk-table-column" >Subject</th>
                        <th class="help-desk-table-column" >Description</th>
                        <th class="help-desk-table-column" >Attach Files</th>
                        <th class="help-desk-table-column" >CC To</th>
                        <th class="help-desk-table-column" >Priority</th>
                    </tr>
                </thead>
                <tbody>
                @if($searchData && $searchData->where('status', 'Recent')->isEmpty())
    <tr>
        <td colspan="7" style="text-align: center;border:none">
            <img style="width: 10em; margin: 20px;" src="https://media.istockphoto.com/id/1357284048/vector/no-item-found-vector-flat-icon-design-illustration-web-and-mobile-application-symbol-on.jpg?s=612x612&w=0&k=20&c=j0V0ww6uBl1LwQLH0U9L7Zn81xMTZCpXPjH5qJo5QyQ=" alt="No items found">
        </td>
    </tr>
    @else
                    @foreach ($searchData->sortByDesc('created_at') as $index => $record)
                    @if($record->status == "Recent")
                    <tr class="helpdesk-main" style="background-color: white;border-bottom:none">
                        <td class="helpdesk-request" >
                            {{ ucfirst(strtolower($record->emp->first_name)) }} {{ ucfirst(strtolower($record->emp->last_name)) }} <br>
                            <strong style="font-size: 10px;">({{ $record->emp_id }})</strong>
                        </td>
                        <td class="helpdesk-request" >
                            {{ $record->request_id ??'-'}}
                        </td>
                        <td class="helpdesk-request" >
                            {{ $record->category ??'-'}}
                        </td>
                        <td class="helpdesk-request" >
                            {{ $record->subject ??'-' }}
                        </td>
                        <td class="helpdesk-request" >
                            {{ $record->description ??'-' }}
                        </td>
                        <td class="helpdesk-request" >



                            @if ($record->file_path)
                            @if(strpos($record->mime_type, 'image') !== false)
                            <a href="#" class="anchorTagDetails" wire:click.prevent="showImage('{{ $record->getImageUrlAttribute() }}')">
                                View Image
                            </a>
                            @else
                            <a class="anchorTagDetails" href="{{ route('file.show', $record->id) }}" download="{{ $record->file_name }}" style="margin-top: 10px;">
                                Download file
                            </a>

                            @endif
                            @else
                            {{-- Show this message if no file is attached --}}
                            <p style="color: gray;">-</p>
                            @endif

                            @if ($showImageDialog)
                            <div class="modal fade show d-block" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">View File</h5>
                                        </div>
                                        <div class="modal-body text-center">
                                            <img src="{{ $imageUrl }}" src="data:image/jpeg;base64,{{ ($imageUrl) }}" class="img-fluid" alt="Image preview" style="width:50%;height:50%">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="submit-btn" wire:click.prevent="downloadImage">Download</button>
                                            <button type="button" class="cancel-btn1" wire:click="closeImageDialog">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-backdrop fade show"></div>
                            @endif












                            {{-- Generic download link for other file types --}}














                        </td>
                        <td class="helpdesk-request" >
                            @php
                            $ccToArray = explode(',', $record->cc_to ?? '-');
                            @endphp
                            {{ count($ccToArray) <= 2 ? implode(', ', $ccToArray) : '-' }}
                        </td>
                        <td class="helpdesk-request" >
                            {{ $record->priority ??'-'}}
                        </td>
                    </tr>

                    @if (count($ccToArray) > 2)
                    <tr class="border" style="border: none !important;">
                        <td class="boder" colspan="7" style="padding: 10px; font-size: 12px; text-transform: capitalize; border-top: none !important;">
                            <div style="margin-left: 10px; font-size: 12px; text-transform: capitalize;">
                                CC TO: {{ implode(', ', $ccToArray) }}
                            </div>
                        </td>
                    </tr>
                    @endif
                    @endif
                    @endforeach
                    @endif
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
                            <button wire:click="searchClosedHelpDesk"  class="task-search-btn" type="button">
                                <i class="fa fa-search task-search-icon"></i>
                            </button>
                        </div>
                    </div>
            </div>
     
            <div class="col-12 col-md-3" style="margin-top:-5px">
                <select wire:model="closedCategory" wire:change="searchClosedHelpDesk"id="closedCategory" class="form-select" style="height:33px; font-size:0.8rem;">
                    <option value="" hidden>Select Request</option>
                    @foreach($requestCategories as $request => $categories)
                    <option value="{{ $request }}">{{ $request }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="help-desk-table" >

            <table class="help-desk-table-main">
            <thead>
                    <tr class="help-desk-table-row" >
                        <th class="help-desk-table-column" style=" width: 20%;">Request Raised By</th>
                        <th class="help-desk-table-column" style=" width: 10%;">Category</th>
                        <th class="help-desk-table-column" style=" width: 20%;">Subject</th>
                        <th class="help-desk-table-column" style="width: 10%;">Description</th>
                        <th class="help-desk-table-column" style=" width: 10%;">Attach Files</th>
                        <th class="help-desk-table-column" style=" width: 20%;">CC To</th>
                        <th class="help-desk-table-column" style=" width: 10%;">Priority</th>
                    </tr>
                </thead>
                <tbody>
                    @if($searchData->where('status', 'Completed')->isEmpty())
                    <tr class="search-data">
                        <td colspan="7" style="text-align: center;border:none">
                            <img style="width: 10em; margin: 20px;" src="https://media.istockphoto.com/id/1357284048/vector/no-item-found-vector-flat-icon-design-illustration-web-and-mobile-application-symbol-on.jpg?s=612x612&w=0&k=20&c=j0V0ww6uBl1LwQLH0U9L7Zn81xMTZCpXPjH5qJo5QyQ=" alt="No items found">
                        </td>
                    </tr>
                    @else
                    @foreach ($searchData->sortByDesc('created_at') as $index => $record)

                    @if($record->status=="Completed")
                    <tr style="background-color: white;">
                        <td class="helpdesk-request" >
                            {{ ucfirst(strtolower($record->emp->first_name)) }} {{ ucfirst(strtolower($record->emp->last_name)) }} <br>
                            <strong style="font-size: 10px;">({{ $record->emp_id }})</strong>
                        </td>
                        <td class="helpdesk-request" >
                            {{ $record->category ??'-'}}
                        </td>
                        <td class="helpdesk-request">
                            {{ $record->subject ??'-'}}
                        </td>
                        <td class="helpdesk-request">
                            {{ $record->description ??'-'}}
                        </td>
                        <td class="helpdesk-request" >



                            @if ($record->file_path)
                            @if(strpos($record->mime_type, 'image') !== false)
                            <a href="#" class="anchorTagDetails" wire:click.prevent="showImage('{{ $record->getImageUrlAttribute() }}')">
                                View Image
                            </a>
                            @else
                            <a class="anchorTagDetails" href="{{ route('file.show', $record->id) }}" download="{{ $record->file_name }}" style="margin-top: 10px;">
                                Download file
                            </a>

                            @endif
                            @else
                            {{-- Show this message if no file is attached --}}
                            <p style="color: gray;">-</p>
                            @endif

                            @if ($showImageDialog)
                            <div class="modal fade show d-block" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">View File</h5>
                                        </div>
                                        <div class="modal-body text-center">
                                            <img src="{{ $imageUrl }}" class="img-fluid" alt="Image preview" style="width:50%;height:50%">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="submit-btn" wire:click.prevent="downloadImage">Download</button>
                                            <button type="button" class="cancel-btn1" wire:click="closeImageDialog">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-backdrop fade show"></div>
                            @endif












                            {{-- Generic download link for other file types --}}






                        </td>
                        <td class="helpdesk-request">
                            @php
                            $ccToArray = explode(',', $record->cc_to??'-');
                            @endphp
                            {{ count($ccToArray) <= 2 ? implode(', ', $ccToArray) : '-' }}
                        </td>
                        <td class="helpdesk-request">
                            {{ $record->priority ??'-' }}
                        </td>
                    </tr>
                    @if (count($ccToArray) > 2)
                    <tr class="no-border-top" style="border-top:none">
                        <td class="no-border-top" colspan="7" style="padding: 10px; font-size: 12px; text-transform: capitalize;">
                            <div class="no-border-top" style="margin-left: 10px; font-size: 12px; text-transform: capitalize; ">
                                CC TO: {{ implode(', ', $ccToArray) }}
                            </div>
                        </td>
                    </tr>
                    @endif

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
            <div class="col-12 col-md-3" style="margin-top:-2px" >
                <select wire:model="pendingCategory" wire:change="searchPendingHelpDesk"  id="pendingCategory" class="form-select" style="height:33px; font-size:0.8rem;">
                    <option value="" hidden>Select Request</option>
                    @foreach($requestCategories as $request => $categories)
                    <option value="{{ $request }}">{{ $request }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="help-desk-table" >

            <table class="help-desk-table-main">
            <thead>
                    <tr class="help-desk-table-row" >
                        <th class="help-desk-table-column" style=" width: 20%;">Request Raised By</th>
                        <th class="help-desk-table-column" style=" width: 10%;">Category</th>
                        <th class="help-desk-table-column" style=" width: 20%;">Subject</th>
                        <th class="help-desk-table-column" style="width: 10%;">Description</th>
                        <th class="help-desk-table-column" style=" width: 10%;">Attach Files</th>
                        <th class="help-desk-table-column" style=" width: 20%;">CC To</th>
                        <th class="help-desk-table-column" style=" width: 10%;">Priority</th>
                    </tr>
                </thead>
                <tbody>
                    @if($searchData->where('status', 'Pending')->isEmpty())
                    <tr class="search-data">
                        <td colspan="7" style="text-align: center;border:none">
                            <img style="width: 10em; margin: 20px;" src="https://media.istockphoto.com/id/1357284048/vector/no-item-found-vector-flat-icon-design-illustration-web-and-mobile-application-symbol-on.jpg?s=612x612&w=0&k=20&c=j0V0ww6uBl1LwQLH0U9L7Zn81xMTZCpXPjH5qJo5QyQ=" alt="No items found">
                        </td>
                    </tr>
                    @else
                    @foreach ($searchData->sortByDesc('created_at') as $index => $record)

                    @if($record->status=="Pending")
                    <tr style="background-color: white;">
                        <td class="helpdesk-request">
                            {{ ucfirst(strtolower($record->emp->first_name)) }} {{ ucfirst(strtolower($record->emp->last_name)) }} <br>
                            <strong style="font-size: 10px;">({{ $record->emp_id }})</strong>
                        </td>
                        <td class="helpdesk-request">
                            {{ $record->category ??'-'}}
                        </td>
                        <td class="helpdesk-request">
                            {{ $record->subject ??'-'}}
                        </td>
                        <td class="helpdesk-request">
                            {{ $record->description ??'-'}}
                        </td>
                        <td class="helpdesk-request">



                            @if ($record->file_path)
                            @if(strpos($record->mime_type, 'image') !== false)
                            <a href="#" class="anchorTagDetails" wire:click.prevent="showImage('{{ $record->getImageUrlAttribute() }}')">
                                View Image
                            </a>
                            @else
                            <a class="anchorTagDetails" href="{{ route('file.show', $record->id) }}" download="{{ $record->file_name }}" style="margin-top: 10px;">
                                Download file
                            </a>

                            @endif
                            @else
                            {{-- Show this message if no file is attached --}}
                            <p style="color: gray;">-</p>
                            @endif

                            @if ($showImageDialog)
                            <div class="modal fade show d-block" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">View File</h5>
                                        </div>
                                        <div class="modal-body text-center">
                                            <img src="{{ $imageUrl }}" class="img-fluid" alt="Image preview" style="width:50%;height:50%">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="submit-btn" wire:click.prevent="downloadImage">Download</button>
                                            <button type="button" class="cancel-btn1" wire:click="closeImageDialog">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-backdrop fade show"></div>
                            @endif












                            {{-- Generic download link for other file types --}}














                        </td>
                        <td style="padding: 10px; font-size: 12px; text-align: center; text-transform: capitalize; border-top: none;">
                            @php
                            $ccToArray = explode(',', $record->cc_to??'-');
                            @endphp
                            {{ count($ccToArray) <= 2 ? implode(', ', $ccToArray) : '-' }}
                        </td>
                        <td style="padding: 10px; font-size: 12px; text-align: center; text-transform: capitalize;">
                            {{ $record->priority ??'-'}}
                        </td>
                    </tr>
                    @if (count($ccToArray) > 2)
                    <tr class="no-border-top">
                        <td class="no-border-top" colspan="7" style="padding: 10px; font-size: 12px; text-transform: capitalize;">
                            <div class="no-border-top" style="margin-left: 10px; font-size: 12px; text-transform: capitalize; ">
                                CC TO: {{ implode(', ', $ccToArray) }}
                            </div>
                        </td>
                    </tr>
                    @endif

                    @endif
                    @endforeach
                    @endif
                </tbody>
            </table>

        </div>
        @endif
    </div>
</div>