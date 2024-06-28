<div>
    <div class="row m-0">
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="filter-container" style="display: flex; flex-direction: column;">
                    <h4 class="m-0 pb-3 " style="font-size: 16px;">Catalog Filters</h4>
                    <div style="display: flex;gap:10px;">
                        <p class="m-0 pb-2 pt-2 catalogFilter activeCatalog" id="infTech" onclick="changeSideMenu('infTech')" style="font-size: 12px; padding: 5px;color:#778899;">Information Technology</p>
                        <p class="m-0 pb-2 pt-2 catalogFilter" id="standChanges" onclick="changeSideMenu('standChanges')" style="font-size: 12px; padding: 5px;color:#778899;">Standard Changes</p>
                    </div>
                </div>
            </div>
        </div>
        <div id="informationTech" class="col-12 mb-4 showIt">
            <div class="row m-0" style="background:white; border:1px solid grey; border-radius:5px;">
                <div class="row m-0">
                    <div class="col-6">
                        <h4 class="mb-4 mt-4" style="font-size: 16px;">Popular Items</h4>
                    </div>
                    <div class="col-6" style="text-align: right; margin: auto; font-size: 13px; padding-right: 15px;">
                        <i class="fas fa-table catalogCardIcon" id="catCardView" onclick="changeView('catCardView')" style="padding: 5px; border-radius: 50%; background-color: #f0f0f0; cursor: pointer; color: #333;"></i>
                        <span style="border: 1px solid" class="me-3 ms-1"></span>
                        <i class="far fa-list-alt catalogCardIcon" id="catListView" onclick="changeView('catListView')" style="padding: 5px; border-radius: 50%; background-color: #f0f0f0; cursor: pointer; color: #333;"></i>
                    </div>
                </div>
                <section id="catalogCardView" class="showIt">
                    <div class="row m-0">

                        <div class="col-md-4 mb-4">
                            <div style="background:white;border:1px solid #d3d3d3;border-radius:5px; padding: 10px 15px;">
                                <p style="font-size: 12px;"><b>Add Members to Distribution List</b></p>
                                <div class="row m-0">
                                    <div class="col-12 text-center mb-2">
                                        <img src="https://snow.payg.in/89294c29871c7510279786a50cbb35b5.iix?t=medium" style="height:4em;">
                                    </div>
                                    <div class="col-12 mb-2">
                                        <p style="text-decoration:underline;cursor: pointer; text-align: center;" wire:click="AddRequest" style="font-size: 10px;">Add Members to Distribution List</p>
                                    </div>
                                    @if($AddRequestaceessDialog)
                                    <div class="modal" tabindex="-1" role="dialog" style="{{ $showModal ? 'display: block;' : 'display: none;' }}">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">New Distribution List</h1>
                                                    <button type="button" class="close" wire:click="$set('showModal', false)">&times;</button>
                                                </div>

                                                <div class="modal-body">
                                                    <div class="row m-0">
                                                        <div class="col-4 m-auto">
                                                            <img src="https://snow.payg.in/89294c29871c7510279786a50cbb35b5.iix?t=medium" style="height:4em">
                                                        </div>
                                                        <div class="col-8 m-auto">
                                                            <p style="font-size:15px;">Use this Catalogue Item to raise New Request for Adding a New Distribution List</p>
                                                        </div>
                                                    </div>
                                                    <hr style="border: 1px solid #ccc;margin: 10px 0;">

                                                    <form wire:submit.prevent="DistributorRequest">
                                                        <div class="row m-0">
                                                            <div class="form-group mt-2">
                                                                <label for="contactDetails">Provide the Name of Distribution List</label>
                                                                <input wire:model="distributor_name" type="text" class="form-control">
                                                                @error('distributor_name') <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>

                                                            <div class="row">
                                                                <div class="mb-3">
                                                                    <label for="cc_to" class="form-label"> Members to be Added</label>
                                                                    <input wire:model="cc_to" type="text" id="cc_to" class="form-control" readonly>
                                                                </div>
                                                                <div class="row m-0">
                                                                    <div class="mb-3 p-0">
                                                                        <button type="button" class="btn btn-outline-primary" wire:click="NamesSearch">
                                                                            <i class="fa fa-plus me-4"></i>
                                                                            Add
                                                                        </button>
                                                                    </div>
                                                                    <div class="row m-0 p-0">
                                                                        <p style="font-size: 12px;">
                                                                            <strong>Request: </strong>
                                                                            {{ implode(', ', array_unique($selectedPeopleNames)) }}
                                                                        </p>
                                                                    </div>
                                                                    @error('cc_to') <span class="text-danger" style="margin-left:20px">{{ $message }}</span> @enderror
                                                                </div>
                                                            </div>
                                                            @if($isNames)
                                                            <div style="border-radius:5px;background-color:grey;padding:8px;width:320px;margin-top:10px;">
                                                                <div class="input-group" style="margin-bottom: 10px;">
                                                                    <input wire:model="searchTerm" style="font-size: 10px;cursor: pointer; border-radius: 5px 0 0 5px;" type="text" class="form-control" placeholder="Search for Emp.Name or ID" aria-label="Search" aria-describedby="basic-addon1">
                                                                    <div class="input-group-append">
                                                                        <button wire:click="filter" style="border-radius: 0 5px 5px 0; background-color: #007BFF; color: #fff; border: none;" class="btn me-3" type="button">
                                                                            <i style="text-align: center;" class="fa fa-search"></i>
                                                                        </button>
                                                                        <button wire:click="closePeoples" type="button" style="margin-top: -7px;" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true" style="color: white; font-size: 24px; font-weight: 300">x</span>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                @if ($peopleData->isEmpty())
                                                                <div class="container" style="text-align: center; color: white;font-size:12px;overflow-y:auto;max-height:300px">
                                                                    No People Found
                                                                </div>
                                                                @else
                                                                @foreach($peopleData as $people)
                                                                <div wire:model="cc_to" wire:click="selectPerson('{{ $people->emp_id }}')" class="container" style="cursor: pointer; background-color: darkgrey; padding: 5px; margin-bottom: 8px; width: 300px; border-radius: 5px;">
                                                                    <div class="row align-items-center">
                                                                        <div class="col-auto">
                                                                            <input type="checkbox" wire:model="selectedPeople" value="{{ $people->emp_id }}" wire:click="selectPerson({{ $people->emp_id }})">
                                                                        </div>

                                                                        <div class="col">
                                                                            <h6 class="username" style="font-size: 12px; color: white;">
                                                                                {{ $people->first_name }}
                                                                                {{ $people->last_name }}
                                                                            </h6>
                                                                            <p class="mb-0" style="font-size: 12px; color: white;">
                                                                                (#{{ $people->emp_id }})</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @endforeach
                                                                @endif
                                                            </div>
                                                            @endif
                                                        </div>


                                                        <div class="form-group mt-2">
                                                            <label for="contactDetails">Business Justification</label>
                                                            <input wire:model="subject" type="text" class="form-control">
                                                            @error('subject') <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group mt-2">
                                                            <label for="reason">Specific Information</label>
                                                            <textarea wire:model="description" class="form-control"></textarea>
                                                            @error('description') <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="row m-0">
                                                            <label for="fileInput" style="cursor: pointer;">
                                                                <i class="fa fa-paperclip"></i> Attach Image
                                                            </label>
                                                            @error('file_path') <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>

                                                        <div class="row m-0">
                                                            <input class="form-control" wire:model="image" type="file" accept="image/*">
                                                            @if ($image)
                                                            <div class="row m-0">
                                                                <img height="100" width="100" src="{{ $image->temporaryUrl() }}" alt="Image Preview" style="max-width: 300px;">
                                                            </div>
                                                            @endif
                                                        </div>

                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button wire:click="closecatalog" type="button" class="cancel-btn" style="border:1px solid rgb(2,17,79);">Cancel</button>
                                                    <button type="button" wire:click="DistributorRequest" class="submit-btn">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-backdrop fade show blurred-backdrop"></div>
                                    @endif

                                </div>

                                <a href="" style="color:blue; cursor: pointer; font-size:smaller; display: block; text-align: center;">View Details</a>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div style="background:white; border:1px solid #d3d3d3; border-radius:5px; padding: 10px 15px;">
                                <p style="font-size: 12px;"><b>Request for IT Accessories</b></p>
                                <div class="row m-0">
                                    <div class="col-12 text-center mb-2">
                                        <img src="https://snow.payg.in/cc7c281087dc7150fc21ed7bbbbb356b.iix?t=medium" style="width: 4em; height:4em;">
                                    </div>
                                    <div class="col-12 mb-2">
                                        <p style="text-decoration:underline;cursor: pointer; text-align: center;" wire:click="ItRequest">Request for IT Accessories</p>
                                    </div>
                                    @if($ItRequestaceessDialog)
                                    <div class="modal" tabindex="-1" role="dialog" style="{{ $showModal ? 'display: block;' : 'display: none;' }}">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Request for IT Accessories</h1>
                                                    <button type="button" class="close" wire:click="$set('showModal', false)">&times;</button>
                                                </div>

                                                <div class="modal-body">
                                                    <div class="row m-0">
                                                        <div class="col-4 m-auto">
                                                            <img src="https://milvusrobotics.com/assets/careers/support.b904d83a.png" style="height:7em">
                                                        </div>
                                                        <div class="col-8 m-auto">
                                                            <p style="font-size:15px;">
                                                                Please use this catalogue item to raise new request for IT accessories
                                                                like Headset, Mouse, Keyboard, Monitor etc.</p>
                                                        </div>
                                                    </div>
                                                    <hr style="border: 1px solid #ccc;margin: 10px 0;">
                                                    <form wire:submit.prevent="submit">
                                                        <div class="row m-0">
                                                            <div class="row">
                                                                <div class="mb-3">
                                                                    <label for="cc_to" class="form-label">Request For</label>
                                                                    <input wire:model="cc_to" type="text" id="cc_to" class="form-control" readonly>
                                                                </div>
                                                                <div class="row m-0">
                                                                    <div class="mb-3 p-0">
                                                                        <button type="button" class="btn btn-outline-primary" wire:click="NamesSearch">
                                                                            <i class="fa fa-plus me-4"></i>
                                                                            Add
                                                                        </button>
                                                                    </div>
                                                                    <div class="row m-0 p-0">
                                                                        <p style="font-size: 12px;">
                                                                            <strong>Request: </strong>
                                                                            {{ implode(', ', array_unique($selectedPeopleNames)) }}
                                                                        </p>
                                                                    </div>
                                                                    @error('cc_to') <span class="text-danger" style="margin-left:20px">{{ $message }}</span> @enderror
                                                                </div>
                                                            </div>
                                                            @if($isNames)
                                                            <div style="border-radius:5px;background-color:grey;padding:8px;width:320px;margin-top:10px;">
                                                                <div class="input-group" style="margin-bottom: 10px;">
                                                                    <input wire:model="searchTerm" style="font-size: 10px;cursor: pointer; border-radius: 5px 0 0 5px;" type="text" class="form-control" placeholder="Search for Emp.Name or ID" aria-label="Search" aria-describedby="basic-addon1">
                                                                    <div class="input-group-append">
                                                                        <button wire:click="filter" style="border-radius: 0 5px 5px 0; background-color: #007BFF; color: #fff; border: none;" class="btn me-3" type="button">
                                                                            <i style="text-align: center;" class="fa fa-search"></i>
                                                                        </button>
                                                                        <button wire:click="closePeoples" type="button" style="margin-top: -7px;" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true" style="color: white; font-size: 24px; font-weight: 300">x</span>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                @if ($peopleData->isEmpty())
                                                                <div class="container" style="text-align: center; color: white;font-size:12px;overflow-y:auto;max-height:300px">
                                                                    No People Found
                                                                </div>
                                                                @else
                                                                @foreach($peopleData as $people)
                                                                <div wire:model="cc_to" wire:click="selectPerson('{{ $people->emp_id }}')" class="container" style="cursor: pointer; background-color: darkgrey; padding: 5px; margin-bottom: 8px; width: 300px; border-radius: 5px;">
                                                                    <div class="row align-items-center">
                                                                        <div class="col-auto">
                                                                            <input type="checkbox" wire:model="selectedPeople" value="{{ $people->emp_id }}" wire:click="selectPerson({{ $people->emp_id }})">
                                                                        </div>

                                                                        <div class="col">
                                                                            <h6 class="username" style="font-size: 12px; color: white;">
                                                                                {{ $people->first_name }}
                                                                                {{ $people->last_name }}
                                                                            </h6>
                                                                            <p class="mb-0" style="font-size: 12px; color: white;">
                                                                                (#{{ $people->emp_id }})</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @endforeach
                                                                @endif
                                                            </div>
                                                            @endif
                                                        </div>

                                                        <div class="form-group mt-2">
                                                            <label for="selectedEquipment">Select Equipment</label>
                                                            <select wire:model="selected_equipment" class="form-control">
                                                                <option value="keyboard">Keyboard</option>
                                                                <option value="keyboard">Keyboard</option>
                                                                <option value="mouse">Mouse</option>
                                                                <option value="headset">Headset</option>
                                                                <option value="monitor">Monitor</option>
                                                            </select>

                                                            @error('selected_equipment')
                                                            <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>


                                                        <div class="form-group mt-2">
                                                            <label for="contactDetails">Business Justification</label>
                                                            <input wire:model="subject" type="text" class="form-control">
                                                            @error('subject') <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group mt-2">
                                                            <label for="reason">Specific Information</label>
                                                            <textarea wire:model="description" class="form-control"></textarea>
                                                            @error('description') <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="row m-0">
                                                            <label for="fileInput" style="cursor: pointer;">
                                                                <i class="fa fa-paperclip"></i> Attach Image
                                                            </label>
                                                            @error('file_path') <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>

                                                        <div class="row m-0">
                                                            <input class="form-control" wire:model="image" type="file" accept="image/*">
                                                            @if ($image)
                                                            <div class="row m-0">
                                                                <img height="100" width="100" src="{{ $image->temporaryUrl() }}" alt="Image Preview" style="max-width: 300px;">
                                                            </div>
                                                            @endif
                                                        </div>

                                                    </form>
                                                </div>
                                                <div class="modal-footer">

                                                    <button wire:click="closecatalog" type="button" class="cancel-btn" style="border:1px solid rgb(2,17,79);">Cancel</button>

                                                    <button type="button" wire:click="submit" class="submit-btn">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-backdrop fade show blurred-backdrop"></div>
                                    @endif

                                </div>
                                <a href="" style="color:blue; cursor: pointer; font-size:smaller; display: block; text-align: center;">View Details</a>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div style="background:white; border:1px solid #d3d3d3; border-radius:5px; padding: 10px 15px;">
                                <p style="font-size: 12px;"><b>Add Members to Mailbox</b></p>
                                <div class="row m-0">
                                    <div class="col-12 text-center mb-2">
                                        <img src="https://snow.payg.in/c3d8c429871c7510279786a50cbb3564.iix?t=medium" style="height:4em;">
                                    </div>
                                    <div class="col-12 mb-2">
                                        <p style="text-decoration:underline;cursor: pointer; text-align: center;" wire:click="MailRequest">Add Members to Mailbox</p>
                                    </div>
                                    @if($MailRequestaceessDialog)
                                    <div class="modal" tabindex="-1" role="dialog" style="{{ $showModal ? 'display: block;' : 'display: none;' }}">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Members to Mailbox</h1>
                                                    <button type="button" class="close" wire:click="$set('showModal', false)">&times;</button>
                                                </div>

                                                <div class="modal-body">
                                                    <div class="row m-0">
                                                        <div class="col-4 m-auto">
                                                            <img src="https://bookbird.io/wp-content/uploads/2022/06/Category-List-Icon-01.svg" style="height:7em">
                                                        </div>
                                                        <div class="col-8 m-auto">
                                                            <p style="font-size:15px;"> Use this Catalogue item to Add members to Mailbox</p>
                                                        </div>
                                                    </div>
                                                    <hr style="border: 1px solid #ccc;margin: 10px 0;">
                                                    <form wire:submit.prevent="Request">
                                                        <div class="row m-0">
                                                            <div class="row">
                                                                <div class="mb-3">
                                                                    <label for="cc_to" class="form-label">Please select the users to be added to New Mailbox</label>
                                                                    <input wire:model="cc_to" type="text" id="cc_to" class="form-control" readonly>
                                                                </div>
                                                                <div class="row m-0">
                                                                    <div class="mb-3 p-0">
                                                                        <button type="button" class="btn btn-outline-primary" wire:click="NamesSearch">
                                                                            <i class="fa fa-plus me-4"></i>
                                                                            Add
                                                                        </button>
                                                                    </div>
                                                                    <div class="row m-0 p-0">
                                                                        <p style="font-size: 12px;">
                                                                            <strong>Request: </strong>
                                                                            {{ implode(', ', array_unique($selectedPeopleNames)) }}
                                                                        </p>
                                                                    </div>
                                                                    @error('cc_to') <span class="text-danger" style="margin-left:20px">{{ $message }}</span> @enderror
                                                                </div>
                                                            </div>
                                                            @if($isNames)
                                                            <div style="border-radius:5px;background-color:grey;padding:8px;width:320px;margin-top:10px;">
                                                                <div class="input-group" style="margin-bottom: 10px;">
                                                                    <input wire:model="searchTerm" style="font-size: 10px;cursor: pointer; border-radius: 5px 0 0 5px;" type="text" class="form-control" placeholder="Search for Emp.Name or ID" aria-label="Search" aria-describedby="basic-addon1">
                                                                    <div class="input-group-append">
                                                                        <button wire:click="filter" style="border-radius: 0 5px 5px 0; background-color: #007BFF; color: #fff; border: none;" class="btn me-3" type="button">
                                                                            <i style="text-align: center;" class="fa fa-search"></i>
                                                                        </button>
                                                                        <button wire:click="closePeoples" type="button" style="margin-top: -7px;" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true" style="color: white; font-size: 24px; font-weight: 300">x</span>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                @if ($peopleData->isEmpty())
                                                                <div class="container" style="text-align: center; color: white;font-size:12px;overflow-y:auto;max-height:300px">
                                                                    No People Found
                                                                </div>
                                                                @else
                                                                @foreach($peopleData as $people)
                                                                <div wire:model="cc_to" wire:click="selectPerson('{{ $people->emp_id }}')" class="container" style="cursor: pointer; background-color: darkgrey; padding: 5px; margin-bottom: 8px; width: 300px; border-radius: 5px;">
                                                                    <div class="row align-items-center">
                                                                        <div class="col-auto">
                                                                            <input type="checkbox" wire:model="selectedPeople" value="{{ $people->emp_id }}" wire:click="selectPerson({{ $people->emp_id }})">
                                                                        </div>

                                                                        <div class="col">
                                                                            <h6 class="username" style="font-size: 12px; color: white;">
                                                                                {{ $people->first_name }}
                                                                                {{ $people->last_name }}
                                                                            </h6>
                                                                            <p class="mb-0" style="font-size: 12px; color: white;">
                                                                                (#{{ $people->emp_id }})</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @endforeach
                                                                @endif
                                                            </div>
                                                            @endif
                                                        </div>



                                                        <div class="form-group mt-2">
                                                            <label for="contactDetails">Provide the Name of Mailbox</label>
                                                            <input wire:model="mail" type="text" class="form-control">
                                                            @error('mail') <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group mt-2">
                                                            <label for="contactDetails">Business Justification</label>
                                                            <input wire:model="subject" type="text" class="form-control">
                                                            @error('subject') <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group mt-2">
                                                            <label for="reason">Specific Information</label>
                                                            <textarea wire:model="description" class="form-control"></textarea>
                                                            @error('description') <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="row m-0">
                                                            <label for="fileInput" style="cursor: pointer;">
                                                                <i class="fa fa-paperclip"></i> Attach Image
                                                            </label>
                                                            @error('file_path') <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>

                                                        <div class="row m-0">
                                                            <input class="form-control" wire:model="image" type="file" accept="image/*">
                                                            @if ($image)
                                                            <div class="row m-0">
                                                                <img height="100" width="100" src="{{ $image->temporaryUrl() }}" alt="Image Preview" style="max-width: 300px;">
                                                            </div>
                                                            @endif
                                                        </div>

                                                    </form>
                                                </div>
                                                <div class="modal-footer">

                                                    <button wire:click="closecatalog" type="button" class="cancel-btn" style="border:1px solid rgb(2,17,79);">Cancel</button>

                                                    <button type="button" wire:click="Request" class="submit-btn">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-backdrop fade show blurred-backdrop"></div>
                                    @endif

                                </div>
                                <a href="" style="color:blue; cursor: pointer; font-size:smaller; display: block; text-align: center;">View Details</a>
                            </div>
                        </div>

                        <div class="row m-0">
                            <div class="col-md-4 mb-4">
                                <div style="background:white; border:1px solid #d3d3d3; border-radius:5px; padding: 10px 15px;">
                                    <p style="font-size: 12px;"><b>ID Card Request</b></p>
                                    <div class="row m-0">
                                        <div class="col-12 text-center mb-2">
                                            <img src="https://snow.payg.in/673ac469871c7510279786a50cbb3563.iix?t=medium" style="height:4em;">
                                        </div>
                                        <div class="col-12 mb-2">
                                            <p style="text-decoration:underline;cursor: pointer; text-align: center;" wire:click="IdRequest">New ID Card Request</p>
                                        </div>
                                        @if($IdRequestaceessDialog)
                                        <div class="modal" tabindex="-1" role="dialog" style="{{ $showModal ? 'display: block;' : 'display: none;' }}">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">ID Card Request</h1>
                                                        <button type="button" class="close" wire:click="$set('showModal', false)">&times;</button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <div class="row m-0">
                                                            <div class="col-4 m-auto">
                                                                <img src="https://encrypted-tbn2.gstatic.com/images?q=tbn:ANd9GcQjGjkjvPfFt0_8-8s0JpLbQ4cDn7Jc_Oz2grDb09ZeXPm9oqJ8" style="height:7em">
                                                            </div>
                                                            <div class="col-8 m-auto">
                                                                <p style="font-size:15px;">New ID Card Request</p>
                                                            </div>
                                                        </div>
                                                        <hr style="border: 1px solid #ccc;margin: 10px 0;">
                                                        <form wire:submit.prevent="Devops">
                                                            <div class="row m-0">
                                                                <div class="row">
                                                                    <div class="mb-3">
                                                                        <label for="cc_to" class="form-label"> Request For</label>
                                                                        <input wire:model="cc_to" type="text" id="cc_to" class="form-control" readonly>
                                                                    </div>
                                                                    <div class="row m-0">
                                                                        <div class="mb-3 p-0">
                                                                            <button type="button" class="btn btn-outline-primary" wire:click="NamesSearch">
                                                                                <i class="fa fa-plus me-4"></i>
                                                                                Add
                                                                            </button>
                                                                        </div>
                                                                        <div class="row m-0 p-0">
                                                                            <p style="font-size: 12px;">
                                                                                <strong>Request: </strong>
                                                                                {{ implode(', ', array_unique($selectedPeopleNames)) }}
                                                                            </p>
                                                                        </div>
                                                                        @error('cc_to') <span class="text-danger" style="margin-left:20px">{{ $message }}</span> @enderror
                                                                    </div>
                                                                </div>
                                                                @if($isNames)
                                                                <div style="border-radius:5px;background-color:grey;padding:8px;width:320px;margin-top:10px;">
                                                                    <div class="input-group" style="margin-bottom: 10px;">
                                                                        <input wire:model="searchTerm" style="font-size: 10px;cursor: pointer; border-radius: 5px 0 0 5px;" type="text" class="form-control" placeholder="Search for Emp.Name or ID" aria-label="Search" aria-describedby="basic-addon1">
                                                                        <div class="input-group-append">
                                                                            <button wire:click="filter" style="border-radius: 0 5px 5px 0; background-color: #007BFF; color: #fff; border: none;" class="btn me-3" type="button">
                                                                                <i style="text-align: center;" class="fa fa-search"></i>
                                                                            </button>
                                                                            <button wire:click="closePeoples" type="button" style="margin-top: -7px;" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true" style="color: white; font-size: 24px; font-weight: 300">x</span>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    @if ($peopleData->isEmpty())
                                                                    <div class="container" style="text-align: center; color: white;font-size:12px;overflow-y:auto;max-height:300px">
                                                                        No People Found
                                                                    </div>
                                                                    @else
                                                                    @foreach($peopleData as $people)
                                                                    <div wire:model="cc_to" wire:click="selectPerson('{{ $people->emp_id }}')" class="container" style="cursor: pointer; background-color: darkgrey; padding: 5px; margin-bottom: 8px; width: 300px; border-radius: 5px;">
                                                                        <div class="row align-items-center">
                                                                            <div class="col-auto">
                                                                                <input type="checkbox" wire:model="selectedPeople" value="{{ $people->emp_id }}" wire:click="selectPerson({{ $people->emp_id }})">
                                                                            </div>

                                                                            <div class="col">
                                                                                <h6 class="username" style="font-size: 12px; color: white;">
                                                                                    {{ $people->first_name }}
                                                                                    {{ $people->last_name }}
                                                                                </h6>
                                                                                <p class="mb-0" style="font-size: 12px; color: white;">
                                                                                    (#{{ $people->emp_id }})</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    @endforeach
                                                                    @endif
                                                                </div>
                                                                @endif
                                                            </div>


                                                            <div style="display:flex">
                                                                <div class="form-group mt-2">
                                                                    <label for="contactDetails">Mobile Number</label>
                                                                    <input wire:model="mobile" type="text" class="form-control">
                                                                    @error('mobile') <span class="text-danger">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                                <div class="form-group mt-2 ml-3">
                                                                    <label for="contactDetails">Email</label>
                                                                    <input wire:model="mail" type="text" class="form-control">
                                                                    @error('mail') <span class="text-danger">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="form-group mt-2">
                                                                <label for="contactDetails">Business Justification</label>
                                                                <input wire:model="subject" type="text" class="form-control">
                                                                @error('subject') <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group mt-2">
                                                                <label for="reason">Specific Information</label>
                                                                <textarea wire:model="description" class="form-control"></textarea>
                                                                @error('description') <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="row m-0">
                                                                <label for="fileInput" style="cursor: pointer;">
                                                                    <i class="fa fa-paperclip"></i> Attach Image
                                                                </label>
                                                                @error('file_path') <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>

                                                            <div class="row m-0">
                                                                <input class="form-control" wire:model="image" type="file" accept="image/*">
                                                                @if ($image)
                                                                <div class="row m-0">
                                                                    <img height="100" width="100" src="{{ $image->temporaryUrl() }}" alt="Image Preview" style="max-width: 300px;">
                                                                </div>
                                                                @endif
                                                            </div>

                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">

                                                        <button wire:click="closecatalog" type="button" class="cancel-btn" style="border:1px solid rgb(2,17,79);">Cancel</button>

                                                        <button type="button" wire:click="Devops" class="submit-btn">Submit</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-backdrop fade show blurred-backdrop"></div>
                                        @endif
                                    </div>
                                    <a href="" style="color:blue; cursor: pointer; font-size:smaller; display: block; text-align: center">View Details</a>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <div style="background:white; border:1px solid #d3d3d3; border-radius:5px; padding: 10px 15px;">
                                    <p style="font-size: 12px;"><b>MMS Account Request</b></p>
                                    <div class="row m-0">
                                        <div class="col-12 text-center mb-2">
                                            <img src="https://snow.payg.in/79ee2f8187c0b510e34c63d70cbb355f.iix?t=medium" style="width: 4em; height:4em;">
                                        </div>
                                        <div class="col-12 mb-2">
                                            <p style="text-decoration:underline;cursor: pointer; text-align: center;" wire:click="MmsRequest">MMS Account Request</p>
                                        </div>
                                        @if($MmsRequestaceessDialog)
                                        <div class="modal" tabindex="-1" role="dialog" style="{{ $showModal ? 'display: block;' : 'display: none;' }}">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">MMS Account Request</h1>
                                                        <button type="button" class="close" wire:click="$set('showModal', false)">&times;</button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <div class="row m-0">
                                                            <div class="col-4 m-auto">
                                                                <img src="https://snow.payg.in/79ee2f8187c0b510e34c63d70cbb355f.iix?t=medium" style="height:7em">
                                                            </div>
                                                            <div class="col-8 m-auto">
                                                                <p style="font-size:15px;">MMS Account Request</p>
                                                            </div>
                                                        </div>
                                                        <hr style="border: 1px solid #ccc;margin: 10px 0;">
                                                        <form wire:submit.prevent="Devops">
                                                            <div class="row m-0">
                                                                <div class="row">
                                                                    <div class="mb-3">
                                                                        <label for="cc_to" class="form-label"> Request For</label>
                                                                        <input wire:model="cc_to" type="text" id="cc_to" class="form-control" readonly>
                                                                    </div>
                                                                    <div class="row m-0">
                                                                        <div class="mb-3 p-0">
                                                                            <button type="button" class="btn btn-outline-primary" wire:click="NamesSearch">
                                                                                <i class="fa fa-plus me-4"></i>
                                                                                Add
                                                                            </button>
                                                                        </div>
                                                                        <div class="row m-0 p-0">
                                                                            <p style="font-size: 12px;">
                                                                                <strong>Request: </strong>
                                                                                {{ implode(', ', array_unique($selectedPeopleNames)) }}
                                                                            </p>
                                                                        </div>
                                                                        @error('cc_to') <span class="text-danger" style="margin-left:20px">{{ $message }}</span> @enderror
                                                                    </div>
                                                                </div>
                                                                @if($isNames)
                                                                <div style="border-radius:5px;background-color:grey;padding:8px;width:320px;margin-top:10px;">
                                                                    <div class="input-group" style="margin-bottom: 10px;">
                                                                        <input wire:model="searchTerm" style="font-size: 10px;cursor: pointer; border-radius: 5px 0 0 5px;" type="text" class="form-control" placeholder="Search for Emp.Name or ID" aria-label="Search" aria-describedby="basic-addon1">
                                                                        <div class="input-group-append">
                                                                            <button wire:click="filter" style="border-radius: 0 5px 5px 0; background-color: #007BFF; color: #fff; border: none;" class="btn me-3" type="button">
                                                                                <i style="text-align: center;" class="fa fa-search"></i>
                                                                            </button>
                                                                            <button wire:click="closePeoples" type="button" style="margin-top: -7px;" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true" style="color: white; font-size: 24px; font-weight: 300">x</span>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    @if ($peopleData->isEmpty())
                                                                    <div class="container" style="text-align: center; color: white;font-size:12px;overflow-y:auto;max-height:300px">
                                                                        No People Found
                                                                    </div>
                                                                    @else
                                                                    @foreach($peopleData as $people)
                                                                    <div wire:model="cc_to" wire:click="selectPerson('{{ $people->emp_id }}')" class="container" style="cursor: pointer; background-color: darkgrey; padding: 5px; margin-bottom: 8px; width: 300px; border-radius: 5px;">
                                                                        <div class="row align-items-center">
                                                                            <div class="col-auto">
                                                                                <input type="checkbox" wire:model="selectedPeople" value="{{ $people->emp_id }}" wire:click="selectPerson({{ $people->emp_id }})">
                                                                            </div>

                                                                            <div class="col">
                                                                                <h6 class="username" style="font-size: 12px; color: white;">
                                                                                    {{ $people->first_name }}
                                                                                    {{ $people->last_name }}
                                                                                </h6>
                                                                                <p class="mb-0" style="font-size: 12px; color: white;">
                                                                                    (#{{ $people->emp_id }})</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    @endforeach
                                                                    @endif
                                                                </div>
                                                                @endif
                                                            </div>


                                                            <div style="display:flex">
                                                                <div class="form-group mt-2">
                                                                    <label for="contactDetails">Mobile Number</label>
                                                                    <input wire:model="mobile" type="text" class="form-control">
                                                                    @error('mobile') <span class="text-danger">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                                <div class="form-group mt-2 ml-3">
                                                                    <label for="contactDetails">Email</label>
                                                                    <input wire:model="mail" type="text" class="form-control">
                                                                    @error('mail') <span class="text-danger">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="form-group mt-2">
                                                                <label for="contactDetails">Business Justification</label>
                                                                <input wire:model="subject" type="text" class="form-control">
                                                                @error('subject') <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group mt-2">
                                                                <label for="reason">Specific Information</label>
                                                                <textarea wire:model="description" class="form-control"></textarea>
                                                                @error('description') <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="row m-0">
                                                                <label for="fileInput" style="cursor: pointer;">
                                                                    <i class="fa fa-paperclip"></i> Attach Image
                                                                </label>
                                                                @error('file_path') <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>

                                                            <div class="row m-0">
                                                                <input class="form-control" wire:model="image" type="file" accept="image/*">
                                                                @if ($image)
                                                                <div class="row m-0">
                                                                    <img height="100" width="100" src="{{ $image->temporaryUrl() }}" alt="Image Preview" style="max-width: 300px;">
                                                                </div>
                                                                @endif
                                                            </div>

                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">

                                                        <button wire:click="closecatalog" type="button" class="cancel-btn" style="border:1px solid rgb(2,17,79);">Cancel</button>

                                                        <button type="button" wire:click="Devops" class="submit-btn">Submit</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-backdrop fade show blurred-backdrop"></div>
                                        @endif
                                    </div>
                                    <a href="" style="color:blue; cursor: pointer; font-size:smaller; display: block; text-align: center;">View Details</a>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <div style="background:white; border:1px solid #d3d3d3; border-radius:5px; padding: 10px 15px;">
                                    <p style="font-size: 12px;"><b>New Distribution List</b></p>
                                    <div class="row m-0">
                                        <div class="col-12 text-center mb-2">
                                            <img src="https://snow.payg.in/feaa4ca9871c7510279786a50cbb3576.iix?t=medium" style="height:4em;">
                                        </div>
                                        <div class="col-12 mb-2">
                                            <p style="text-decoration:underline;cursor: pointer; text-align: center;" wire:click="DistributionRequest">New Distribution List</p>
                                        </div>
                                        @if($DistributionRequestaceessDialog)
                                        <div class="modal" tabindex="-1" role="dialog" style="{{ $showModal ? 'display: block;' : 'display: none;' }}">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">New Distribution List</h1>
                                                        <button type="button" class="close" wire:click="$set('showModal', false)">&times;</button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <div class="row m-0">
                                                            <div class="col-4 m-auto">
                                                                <img src="https://snow.payg.in/feaa4ca9871c7510279786a50cbb3576.iix?t=medium" style="height:7em">
                                                            </div>
                                                            <div class="col-8 m-auto">
                                                                <p style="font-size:15px;">Use this Catalogue Item to raise New Request for Adding a New Distribution List</p>
                                                            </div>
                                                        </div>
                                                        <hr style="border: 1px solid #ccc;margin: 10px 0;">

                                                        <form wire:submit.prevent="DistributorRequest">
                                                            <div class="row m-0">
                                                                <div class="form-group mt-2">
                                                                    <label for="contactDetails">Provide the Name of Distribution List</label>
                                                                    <input wire:model="distributor_name" type="text" class="form-control">
                                                                    @error('distributor_name') <span class="text-danger">{{ $message }}</span>
                                                                    @enderror
                                                                </div>

                                                                <div class="row">
                                                                    <div class="mb-3">
                                                                        <label for="cc_to" class="form-label"> Members to be Added</label>
                                                                        <input wire:model="cc_to" type="text" id="cc_to" class="form-control" readonly>
                                                                    </div>
                                                                    <div class="row m-0">
                                                                        <div class="mb-3 p-0">
                                                                            <button type="button" class="btn btn-outline-primary" wire:click="NamesSearch">
                                                                                <i class="fa fa-plus me-4"></i>
                                                                                Add
                                                                            </button>
                                                                        </div>
                                                                        <div class="row m-0 p-0">
                                                                            <p style="font-size: 12px;">
                                                                                <strong>Request: </strong>
                                                                                {{ implode(', ', array_unique($selectedPeopleNames)) }}
                                                                            </p>
                                                                        </div>
                                                                        @error('cc_to') <span class="text-danger" style="margin-left:20px">{{ $message }}</span> @enderror
                                                                    </div>
                                                                </div>
                                                                @if($isNames)
                                                                <div style="border-radius:5px;background-color:grey;padding:8px;width:320px;margin-top:10px;">
                                                                    <div class="input-group" style="margin-bottom: 10px;">
                                                                        <input wire:model="searchTerm" style="font-size: 10px;cursor: pointer; border-radius: 5px 0 0 5px;" type="text" class="form-control" placeholder="Search for Emp.Name or ID" aria-label="Search" aria-describedby="basic-addon1">
                                                                        <div class="input-group-append">
                                                                            <button wire:click="filter" style="border-radius: 0 5px 5px 0; background-color: #007BFF; color: #fff; border: none;" class="btn me-3" type="button">
                                                                                <i style="text-align: center;" class="fa fa-search"></i>
                                                                            </button>
                                                                            <button wire:click="closePeoples" type="button" style="margin-top: -7px;" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true" style="color: white; font-size: 24px; font-weight: 300">x</span>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    @if ($peopleData->isEmpty())
                                                                    <div class="container" style="text-align: center; color: white;font-size:12px;overflow-y:auto;max-height:300px">
                                                                        No People Found
                                                                    </div>
                                                                    @else
                                                                    @foreach($peopleData as $people)
                                                                    <div wire:model="cc_to" wire:click="selectPerson('{{ $people->emp_id }}')" class="container" style="cursor: pointer; background-color: darkgrey; padding: 5px; margin-bottom: 8px; width: 300px; border-radius: 5px;">
                                                                        <div class="row align-items-center">
                                                                            <div class="col-auto">
                                                                                <input type="checkbox" wire:model="selectedPeople" value="{{ $people->emp_id }}" wire:click="selectPerson({{ $people->emp_id }})">
                                                                            </div>

                                                                            <div class="col">
                                                                                <h6 class="username" style="font-size: 12px; color: white;">
                                                                                    {{ $people->first_name }}
                                                                                    {{ $people->last_name }}
                                                                                </h6>
                                                                                <p class="mb-0" style="font-size: 12px; color: white;">
                                                                                    (#{{ $people->emp_id }})</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    @endforeach
                                                                    @endif
                                                                </div>
                                                                @endif
                                                            </div>


                                                            <div class="form-group mt-2">
                                                                <label for="contactDetails">Business Justification</label>
                                                                <input wire:model="subject" type="text" class="form-control">
                                                                @error('subject') <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group mt-2">
                                                                <label for="reason">Specific Information</label>
                                                                <textarea wire:model="description" class="form-control"></textarea>
                                                                @error('description') <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="row m-0">
                                                                <label for="fileInput" style="cursor: pointer;">
                                                                    <i class="fa fa-paperclip"></i> Attach Image
                                                                </label>
                                                                @error('file_path') <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>

                                                            <div class="row m-0">
                                                                <input class="form-control" wire:model="image" type="file" accept="image/*">
                                                                @if ($image)
                                                                <div class="row m-0">
                                                                    <img height="100" width="100" src="{{ $image->temporaryUrl() }}" alt="Image Preview" style="max-width: 300px;">
                                                                </div>
                                                                @endif
                                                            </div>

                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">

                                                        <button wire:click="closecatalog" type="button" class="cancel-btn" style="border:1px solid rgb(2,17,79);">Cancel</button>

                                                        <button type="button" wire:click="DistributorRequest" class="submit-btn">Submit</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-backdrop fade show blurred-backdrop"></div>
                                        @endif
                                    </div>
                                    <a href="" style="color:blue; cursor: pointer; font-size:smaller; display: block; text-align: center;">View Details</a>
                                </div>
                            </div>
                        </div>

                        <div class="row m-0">
                            <div class="col-md-4 mb-4">
                                <div style="background:white; border:1px solid #d3d3d3; border-radius:5px; padding: 10px 15px;">
                                    <p style="font-size: 12px;"><b>New Laptop</b></p>
                                    <div class="row m-0">
                                        <div class="col-12 text-center mb-2">
                                            <img src="https://snow.payg.in/1a00f1cb878cb950279786a50cbb35ea.iix?t=medium" style="height:4em;">
                                        </div>
                                        <div class="col-12 mb-2">
                                            <p style="text-decoration:underline;cursor: pointer; text-align: center;" wire:click="LapRequest">Laptop Request</p>
                                        </div>
                                        @if($LapRequestaceessDialog)
                                        <div class="modal" tabindex="-1" role="dialog" style="{{ $showModal ? 'display: block;' : 'display: none;' }}">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">New Laptop</h1>
                                                        <button type="button" class="close" wire:click="$set('showModal', false)">&times;</button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <div class="row m-0">
                                                            <div class="col-4 m-auto">
                                                                <img src="https://snow.payg.in/1a00f1cb878cb950279786a50cbb35ea.iix?t=medium" style="height:7em">
                                                            </div>
                                                            <div class="col-8 m-auto">
                                                                <p style="font-size:15px;">New Laptop</p>
                                                            </div>
                                                        </div>
                                                        <hr style="border: 1px solid #ccc;margin: 10px 0;">
                                                        <form wire:submit.prevent="Devops">
                                                            <div class="row m-0">
                                                                <div class="row">
                                                                    <div class="mb-3">
                                                                        <label for="cc_to" class="form-label"> Request For</label>
                                                                        <input wire:model="cc_to" type="text" id="cc_to" class="form-control" readonly>
                                                                    </div>
                                                                    <div class="row m-0">
                                                                        <div class="mb-3 p-0">
                                                                            <button type="button" class="btn btn-outline-primary" wire:click="NamesSearch">
                                                                                <i class="fa fa-plus me-4"></i>
                                                                                Add
                                                                            </button>
                                                                        </div>
                                                                        <div class="row m-0 p-0">
                                                                            <p style="font-size: 12px;">
                                                                                <strong>Request: </strong>
                                                                                {{ implode(', ', array_unique($selectedPeopleNames)) }}
                                                                            </p>
                                                                        </div>
                                                                        @error('cc_to') <span class="text-danger" style="margin-left:20px">{{ $message }}</span> @enderror
                                                                    </div>
                                                                </div>
                                                                @if($isNames)
                                                                <div style="border-radius:5px;background-color:grey;padding:8px;width:320px;margin-top:10px;">
                                                                    <div class="input-group" style="margin-bottom: 10px;">
                                                                        <input wire:model="searchTerm" style="font-size: 10px;cursor: pointer; border-radius: 5px 0 0 5px;" type="text" class="form-control" placeholder="Search for Emp.Name or ID" aria-label="Search" aria-describedby="basic-addon1">
                                                                        <div class="input-group-append">
                                                                            <button wire:click="filter" style="border-radius: 0 5px 5px 0; background-color: #007BFF; color: #fff; border: none;" class="btn me-3" type="button">
                                                                                <i style="text-align: center;" class="fa fa-search"></i>
                                                                            </button>
                                                                            <button wire:click="closePeoples" type="button" style="margin-top: -7px;" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true" style="color: white; font-size: 24px; font-weight: 300">x</span>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    @if ($peopleData->isEmpty())
                                                                    <div class="container" style="text-align: center; color: white;font-size:12px;overflow-y:auto;max-height:300px">
                                                                        No People Found
                                                                    </div>
                                                                    @else
                                                                    @foreach($peopleData as $people)
                                                                    <div wire:model="cc_to" wire:click="selectPerson('{{ $people->emp_id }}')" class="container" style="cursor: pointer; background-color: darkgrey; padding: 5px; margin-bottom: 8px; width: 300px; border-radius: 5px;">
                                                                        <div class="row align-items-center">
                                                                            <div class="col-auto">
                                                                                <input type="checkbox" wire:model="selectedPeople" value="{{ $people->emp_id }}" wire:click="selectPerson({{ $people->emp_id }})">
                                                                            </div>

                                                                            <div class="col">
                                                                                <h6 class="username" style="font-size: 12px; color: white;">
                                                                                    {{ $people->first_name }}
                                                                                    {{ $people->last_name }}
                                                                                </h6>
                                                                                <p class="mb-0" style="font-size: 12px; color: white;">
                                                                                    (#{{ $people->emp_id }})</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    @endforeach
                                                                    @endif
                                                                </div>
                                                                @endif
                                                            </div>


                                                            <div style="display:flex">
                                                                <div class="form-group mt-2">
                                                                    <label for="contactDetails">Mobile Number</label>
                                                                    <input wire:model="mobile" type="text" class="form-control">
                                                                    @error('mobile') <span class="text-danger">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                                <div class="form-group mt-2 ml-3">
                                                                    <label for="contactDetails">Email</label>
                                                                    <input wire:model="mail" type="text" class="form-control">
                                                                    @error('mail') <span class="text-danger">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="form-group mt-2">
                                                                <label for="contactDetails">Business Justification</label>
                                                                <input wire:model="subject" type="text" class="form-control">
                                                                @error('subject') <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group mt-2">
                                                                <label for="reason">Specific Information</label>
                                                                <textarea wire:model="description" class="form-control"></textarea>
                                                                @error('description') <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="row m-0">
                                                                <label for="fileInput" style="cursor: pointer;">
                                                                    <i class="fa fa-paperclip"></i> Attach Image
                                                                </label>
                                                                @error('file_path') <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>

                                                            <div class="row m-0">
                                                                <input class="form-control" wire:model="image" type="file" accept="image/*">
                                                                @if ($image)
                                                                <div class="row m-0">
                                                                    <img height="100" width="100" src="{{ $image->temporaryUrl() }}" alt="Image Preview" style="max-width: 300px;">
                                                                </div>
                                                                @endif
                                                            </div>

                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">

                                                        <button wire:click="closecatalog" type="button" class="cancel-btn" style="border:1px solid rgb(2,17,79);">Cancel</button>

                                                        <button type="button" wire:click="Devops" class="submit-btn">Submit</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-backdrop fade show blurred-backdrop"></div>
                                        @endif
                                    </div>
                                    <a href="" style="color:blue; cursor: pointer; font-size:smaller; display: block; text-align: center;">View Details</a>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <div style="background:white; border:1px solid #d3d3d3; border-radius:5px; padding: 10px 15px;">
                                    <p style="font-size: 12px;"><b>New Mailbox Request</b></p>
                                    <div class="row m-0">
                                        <div class="col-12 text-center mb-2">
                                            <img src="https://snow.payg.in/723bc4e9871c7510279786a50cbb3585.iix?t=medium" style="width: 4em; height:4em;">
                                        </div>
                                        <div class="col-12 mb-2">
                                            <p style="text-decoration:underline;cursor: pointer; text-align: center;">New Mailbox Request</p>
                                        </div>
                                    </div>
                                    <a href="" style="color:blue; cursor: pointer; font-size:smaller; display: block; text-align: center;">View Details</a>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <div style="background:white; border:1px solid #d3d3d3; border-radius:5px; padding: 10px 15px;">
                                    <p style="font-size: 12px;"><b>Devops Access Request</b></p>
                                    <div class="row m-0">
                                        <div class="col-12 text-center mb-2">
                                            <img src="https://snow.payg.in/3111f90f878cb950279786a50cbb359b.iix?t=medium" style="height:4em;">
                                        </div>
                                        <div class="col-12 mb-2">
                                            <p style="text-decoration:underline;cursor: pointer; text-align: center;" wire:click="DevopsRequest">Devops Access Request</p>
                                        </div>
                                        @if($DevopsRequestaceessDialog)
                                        <div class="modal" tabindex="-1" role="dialog" style="{{ $showModal ? 'display: block;' : 'display: none;' }}">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Devops Access Request</h1>
                                                        <button type="button" class="close" wire:click="$set('showModal', false)">&times;</button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <div class="row m-0">
                                                            <div class="col-4 m-auto">
                                                                <img src="https://snow.payg.in/3111f90f878cb950279786a50cbb359b.iix?t=medium" style="height:7em">
                                                            </div>
                                                            <div class="col-8 m-auto">
                                                                <p style="font-size:15px;"> Devops Access Request</p>
                                                            </div>
                                                        </div>
                                                        <hr style="border: 1px solid #ccc;margin: 10px 0;">
                                                        <form wire:submit.prevent="Devops">
                                                            <div class="row m-0">
                                                                <div class="row">
                                                                    <div class="mb-3">
                                                                        <label for="cc_to" class="form-label"> Request For</label>
                                                                        <input wire:model="cc_to" type="text" id="cc_to" class="form-control" readonly>
                                                                    </div>
                                                                    <div class="row m-0">
                                                                        <div class="mb-3 p-0">
                                                                            <button type="button" class="btn btn-outline-primary" wire:click="NamesSearch">
                                                                                <i class="fa fa-plus me-4"></i>
                                                                                Add
                                                                            </button>
                                                                        </div>
                                                                        <div class="row m-0 p-0">
                                                                            <p style="font-size: 12px;">
                                                                                <strong>Request: </strong>
                                                                                {{ implode(', ', array_unique($selectedPeopleNames)) }}
                                                                            </p>
                                                                        </div>
                                                                        @error('cc_to') <span class="text-danger" style="margin-left:20px">{{ $message }}</span> @enderror
                                                                    </div>
                                                                </div>
                                                                @if($isNames)
                                                                <div style="border-radius:5px;background-color:grey;padding:8px;width:320px;margin-top:10px;">
                                                                    <div class="input-group" style="margin-bottom: 10px;">
                                                                        <input wire:model="searchTerm" style="font-size: 10px;cursor: pointer; border-radius: 5px 0 0 5px;" type="text" class="form-control" placeholder="Search for Emp.Name or ID" aria-label="Search" aria-describedby="basic-addon1">
                                                                        <div class="input-group-append">
                                                                            <button wire:click="filter" style="border-radius: 0 5px 5px 0; background-color: #007BFF; color: #fff; border: none;" class="btn me-3" type="button">
                                                                                <i style="text-align: center;" class="fa fa-search"></i>
                                                                            </button>
                                                                            <button wire:click="closePeoples" type="button" style="margin-top: -7px;" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true" style="color: white; font-size: 24px; font-weight: 300">x</span>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    @if ($peopleData->isEmpty())
                                                                    <div class="container" style="text-align: center; color: white;font-size:12px;overflow-y:auto;max-height:300px">
                                                                        No People Found
                                                                    </div>
                                                                    @else
                                                                    @foreach($peopleData as $people)
                                                                    <div wire:model="cc_to" wire:click="selectPerson('{{ $people->emp_id }}')" class="container" style="cursor: pointer; background-color: darkgrey; padding: 5px; margin-bottom: 8px; width: 300px; border-radius: 5px;">
                                                                        <div class="row align-items-center">
                                                                            <div class="col-auto">
                                                                                <input type="checkbox" wire:model="selectedPeople" value="{{ $people->emp_id }}" wire:click="selectPerson({{ $people->emp_id }})">
                                                                            </div>

                                                                            <div class="col">
                                                                                <h6 class="username" style="font-size: 12px; color: white;">
                                                                                    {{ $people->first_name }}
                                                                                    {{ $people->last_name }}
                                                                                </h6>
                                                                                <p class="mb-0" style="font-size: 12px; color: white;">
                                                                                    (#{{ $people->emp_id }})</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    @endforeach
                                                                    @endif
                                                                </div>
                                                                @endif
                                                            </div>


                                                            <div style="display:flex">
                                                                <div class="form-group mt-2">
                                                                    <label for="contactDetails">Mobile Number</label>
                                                                    <input wire:model="mobile" type="text" class="form-control">
                                                                    @error('mobile') <span class="text-danger">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                                <div class="form-group mt-2 ml-3">
                                                                    <label for="contactDetails">Email</label>
                                                                    <input wire:model="mail" type="text" class="form-control">
                                                                    @error('mail') <span class="text-danger">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="form-group mt-2">
                                                                <label for="contactDetails">Business Justification</label>
                                                                <input wire:model="subject" type="text" class="form-control">
                                                                @error('subject') <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group mt-2">
                                                                <label for="reason">Specific Information</label>
                                                                <textarea wire:model="description" class="form-control"></textarea>
                                                                @error('description') <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="row m-0">
                                                                <label for="fileInput" style="cursor: pointer;">
                                                                    <i class="fa fa-paperclip"></i> Attach Image
                                                                </label>
                                                                @error('file_path') <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>

                                                            <div class="row m-0">
                                                                <input class="form-control" wire:model="image" type="file" accept="image/*">
                                                                @if ($image)
                                                                <div class="row m-0">
                                                                    <img height="100" width="100" src="{{ $image->temporaryUrl() }}" alt="Image Preview" style="max-width: 300px;">
                                                                </div>
                                                                @endif
                                                            </div>

                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">

                                                        <button wire:click="closecatalog" type="button" class="cancel-btn" style="border:1px solid rgb(2,17,79);">Cancel</button>

                                                        <button type="button" wire:click="Devops" class="submit-btn">Submit</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-backdrop fade show blurred-backdrop"></div>
                                        @endif
                                    </div>
                                    <a href="" style="color:blue; cursor: pointer; font-size:smaller; display: block; text-align: center;">View Details</a>
                                </div>
                            </div>
                        </div>



                        <div id="showBtnDiv" class="row m-0 mb-4 showIt" style="text-align: center">
                            <div>
                                <button class="cancel-btn" onclick="showMoreItems()" style="border: 1px solid rgb(2,17,79);">Show More Items</button>
                            </div>
                        </div>

                        <div id="requestCard" class="row m-0 hideIt">
                            <div class="row m-0">
                                <div class="col-md-4 mb-4">
                                    <div style="background:white; border:1px solid #d3d3d3; border-radius:5px; padding: 10px 15px;height: 220px;">
                                        <p style="font-size: 12px;"><b>O365 Desktop License Access</b></p>
                                        <div class="row m-0">
                                            <div class="col-12 text-center mb-2">
                                                <img src="https://snow.payg.in/a9fa00e9871c7510279786a50cbb3525.iix?t=medium" style="height:4em;">
                                            </div>
                                            <div class="col-12 mb-2">
                                                <p style="text-decoration:underline;cursor: pointer; text-align: center;">O365 Desktop License Access</p>
                                            </div>
                                        </div>
                                        <a href="" style="color:blue; cursor: pointer; font-size:smaller; display: block; text-align: center;">View Details</a>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-4">
                                    <div style="background:white; border:1px solid #d3d3d3; border-radius:5px; padding: 10px 15px;height: 220px;">
                                        <p style="font-size: 12px;"><b>Other Request</b></p>
                                        <div class="row m-0 mb-5">
                                            <p class="p-0" style="cursor: pointer; margin-bottom: 4.4em;text-decoration:underline;text-align: center;">Other Service Request</p>
                                        </div>
                                        <a href="" style="color:blue; cursor: pointer; font-size:smaller; display: block; text-align: center;">View Details</a>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <div style="background:white; border:1px solid #d3d3d3; border-radius:5px; padding: 10px 15px;height: 220px;">
                                        <p style=" font-size: 12px;"><b>Privilege Access Request</b></p>
                                        <div class="row m-0 mb-5">
                                            <p class="p-0" style="cursor: pointer; margin-bottom: 4.4em;text-decoration:underline;text-align: center;">Privilege Access Request</p>
                                        </div>
                                        <a href="" style="color:blue; cursor: pointer; font-size:smaller; display: block; text-align: center;">View Details</a>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-0">
                                <div class="col-md-4 mb-4">
                                    <div style="background:white; border:1px solid #d3d3d3; border-radius:5px; padding: 10px 15px;height: 220px;">
                                        <p style="font-size: 12px;"><b>Remove from Distribution List</b></p>
                                        <div class="row m-0">
                                            <div class="col-12 text-center mb-2">
                                                <img src="https://snow.payg.in/6dfb082d871c7510279786a50cbb3590.iix?t=medium" style="height:4em;">
                                            </div>
                                            <div class="col-12 mb-2 text-center">
                                                <div style="max-width: 100%; overflow: hidden;">
                                                    <p style="text-decoration:underline; cursor: pointer; white-space: nowrap;">Remove Members from Distribution List</p>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="" style="color:blue; cursor: pointer; font-size:smaller; display: block; text-align: center;">View Details</a>
                                    </div>
                                </div>




                                <div class="col-md-4 mb-4">
                                    <div style="background:white; border:1px solid #d3d3d3; border-radius:5px; padding: 10px 15px;height: 220px;">
                                        <p style="font-size: 12px;"><b>Remove from Mailbox</b></p>
                                        <div class="row m-0">
                                            <div class="col-12 text-center mb-2">
                                                <img src="https://snow.payg.in/6dfb082d871c7510279786a50cbb3590.iix?t=medium" style="height:4em;">
                                            </div>
                                            <div class="col-12 mb-2">
                                                <p style="text-decoration:underline;cursor: pointer; text-align: center;">Remove Members from Mailbox</p>
                                            </div>
                                        </div>
                                        <a href="" style="color:blue; cursor: pointer; font-size:smaller; display: block; text-align: center;">View Details</a>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-4">
                                    <div style="background:white; border:1px solid #d3d3d3; border-radius:5px; padding: 10px 15px;height: 220px;">
                                        <p style="font-size: 12px;"><b>SIM Request</b></p>
                                        <div class="row m-0">
                                            <div class="col-12 text-center mb-2">
                                                <img src="https://snow.payg.in/ef99c469871c7510279786a50cbb357f.iix?t=medium" style="height:4em;">
                                            </div>
                                            <div class="col-12 mb-2">
                                                <p style="text-decoration:underline;cursor: pointer; text-align: center;">New SIM Request</p>
                                            </div>
                                        </div>
                                        <a href="" style="color:blue; cursor: pointer; font-size:smaller; display: block; text-align: center;">View Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                </section>

                <section id="cataLogListView" class="hideIt table-responsive">
                    <table class="custom-table-catalog px-2 border rounded " style="font-size: 12px;">
                        <thead>
                            <tr>
                                <th style="width:40%;padding:10px;">Item</th>
                                <th style="width:60%;padding:10px;">Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="item-td">
                                    <img src="https://snow.payg.in/89294c29871c7510279786a50cbb35b5.iix?t=medium" class="me-3" style="height:4em;">
                                    <a style="cursor: pointer; color: blue; text-decoration: underline; font-size: 12px" wire:click="ItRequest">Add Members to Distribution List</a>
                                </td>
                                <td class="descrption-td" style="vertical-align: middle;">
                                    <p style="font-size: 12px">Add Members to Distribution List</p>
                                </td>
                            </tr>
                            <tr>
                                <td class="item-td">
                                    <img src="https://snow.payg.in/c3d8c429871c7510279786a50cbb3564.iix?t=medium" class="me-3" style="height:4em;">
                                    <a style="cursor: pointer; color: blue; text-decoration: underline; font-size: 12px">Add Members to Mailbox</a>
                                </td>
                                <td  class="descrption-td" style="vertical-align: middle;">
                                    <p style="font-size: 12px">Add Members to Mailbox</p>
                                </td>
                            </tr>
                            <tr>
                                <td class="item-td">
                                    <img src="https://snow.payg.in/3111f90f878cb950279786a50cbb359b.iix?t=medium" class="me-3" style="height:4em;">
                                    <a style="cursor: pointer; color: blue; text-decoration: underline; font-size: 14px">Devops Access Request</a>
                                </td>
                                <td class="descrption-td" style="vertical-align: middle;">
                                    <p style="font-size: 12px">Devops Access Request</p>
                                </td>
                            </tr>
                            <tr>
                                <td class="item-td">
                                    <img src="https://snow.payg.in/673ac469871c7510279786a50cbb3563.iix?t=medium" class="me-3" style="height:4em;">
                                    <a style="cursor: pointer; color: blue; text-decoration: underline; font-size: 12px">ID Card Request</a>
                                </td>
                                <td class="descrption-td" style="vertical-align: middle;">
                                    <p style="font-size: 12px">New ID Card Request</p>
                                </td>
                            </tr>
                            <tr>
                                <td class="item-td">
                                    <img src="https://snow.payg.in/79ee2f8187c0b510e34c63d70cbb355f.iix?t=medium" class="me-3" style="height:4em;">
                                    <a style="cursor: pointer; color: blue; text-decoration: underline; font-size: 12px">MMS Account Request</a>
                                </td>
                                <td class="descrption-td" style="vertical-align: middle;">
                                    <p style="font-size: 12px">MMS Account Request</p>
                                </td>
                            </tr>
                            <tr>
                                <td class="item-td">
                                    <img src="https://snow.payg.in/feaa4ca9871c7510279786a50cbb3576.iix?t=medium" class="me-3" style="height:4em;">
                                    <a style="cursor: pointer; color: blue; text-decoration: underline; font-size: 12px">New Distribution List</a>
                                </td>
                                <td class="descrption-td" style="vertical-align: middle;">
                                    <p style="font-size: 12px">New Distribution List</p>
                                </td>
                            </tr>
                            <tr>
                                <td class="item-td">
                                    <img src="https://snow.payg.in/1a00f1cb878cb950279786a50cbb35ea.iix?t=medium" class="me-3" style="height:4em;">
                                    <a style="cursor: pointer; color: blue; text-decoration: underline; font-size: 12px">New Laptop Request</a>
                                </td>
                                <td class="descrption-td" style="vertical-align: middle;">
                                    <p style="font-size: 12px">New Laptop Request</p>
                                </td>
                            </tr>
                            <tr>
                                <td class="item-td">
                                    <img src="https://snow.payg.in/723bc4e9871c7510279786a50cbb3585.iix?t=medium" class="me-3" style="height:4em;">
                                    <a style="cursor: pointer; color: blue; text-decoration: underline; font-size: 14px">New Mailbox Request</a>
                                </td>
                                <td class="descrption-td" style="vertical-align: middle;">
                                    <p style="font-size: 12px">New Mailbox Request</p>
                                </td>
                            </tr>
                            <tr>
                                <td class="item-td">
                                    <img src="https://snow.payg.in/a9fa00e9871c7510279786a50cbb3525.iix?t=medium" class="me-3" style="height:4em;">
                                    <a style="cursor: pointer; color: blue; text-decoration: underline; font-size: 12px">O365 Desktop License Access</a>
                                </td>
                                <td class="descrption-td" style="vertical-align: middle;">
                                    <p style="font-size: 12px">O365 Desktop License Access</p>
                                </td>
                            </tr>
                            <tr>
                                <td class="item-td">
                                    <a style="cursor: pointer; color: blue; text-decoration: underline; font-size: 12px">Other Request</a>
                                </td>
                                <td class="descrption-td" style="vertical-align: middle;">
                                    <p style="font-size: 12px">Other Service Request</p>
                                </td>
                            </tr>
                            <tr>
                                <td class="item-td">
                                    <a style="cursor: pointer; color: blue; text-decoration: underline; font-size: 12px">Privilege Access Request</a>
                                </td>
                                <td class="descrption-td" style="vertical-align: middle;">
                                    <p style="font-size: 12px">Privilege Access Request</p>
                                </td>
                            </tr>
                            <tr>
                                <td class="item-td">
                                    <img src="https://snow.payg.in/6dfb082d871c7510279786a50cbb3590.iix?t=medium" class="me-3" style="height:4em;">
                                    <a style="cursor: pointer; color: blue; text-decoration: underline; font-size: 12px">Remove Members from Distribution List</a>
                                </td>
                                <td class="descrption-td" style="vertical-align: middle;">
                                    <p style="font-size: 12px">Remove Members from Distribution List</p>
                                </td>
                            </tr>
                            <tr>
                                <td class="item-td">
                                    <img src="https://snow.payg.in/6dfb082d871c7510279786a50cbb3590.iix?t=medium" class="me-3" style="height:4em;">
                                    <a style="cursor: pointer; color: blue; text-decoration: underline; font-size: 12px">Remove Members from Mailbox</a>
                                </td>
                                <td class="descrption-td" style="vertical-align: middle;">
                                    <p style="font-size: 12px">Remove Members from Mailbox</p>
                                </td>
                            </tr>
                            <tr>
                                <td class="item-td">
                                    <img src="https://snow.payg.in/cc7c281087dc7150fc21ed7bbbbb356b.iix?t=medium" class="me-3" style="height:4em;">
                                    <a style="cursor: pointer; color: blue; text-decoration: underline; font-size: 12px">Request for IT Accessories</a>
                                </td>
                                <td class="descrption-td" style="vertical-align: middle;">
                                    <p style="font-size: 12px">Request for IT Accessories</p>
                                </td>
                            </tr>
                            <tr>
                                <td class="item-td">
                                    <img src="https://snow.payg.in/ef99c469871c7510279786a50cbb357f.iix?t=medium" class="me-3" style="height:4em;">
                                    <a style="cursor: pointer; color: blue; text-decoration: underline; font-size: 12px">SIM Request</a>
                                </td>
                                <td class="descrption-td" style="vertical-align: middle;">
                                    <p style="font-size: 12px">New SIM Request</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </section>

            </div>
        </div>

        <div id="standardChanges" class="col-md-9 mb-4 hideIt">
            <div class="row m-0" style="background:white; border:1px solid grey; border-radius:5px;">
                <div class="row m-0">
                    <div class="col-6">
                        <h4 class="mt-4 mb-2">Standard Changes</h4>
                        <p class="mb-4">Standard Change Template Library</p>
                    </div>
                    <div class="col-6" style="text-align: right; margin: auto; font-size: 13px;">
                        <i class="fas fa-table catalogCardIcon activeCatalog" id="standCardView" onclick="changeView('standCardView')"></i>
                        <span style="border: 1px solid" class="me-3 ms-1"></span>
                        <i class="far fa-list-alt catalogCardIcon" id="standListView" onclick="changeView('standListView')"></i>
                    </div>
                </div>

                <section id="standardCardView" class="showIt">
                    <div class="row m-0">
                        <div class="col-md-4 mb-4">
                            <div style="background:white; border:1px solid #d3d3d3; border-radius:5px; padding: 10px 15px;">
                                <p style="text-decoration:underline; font-size: 12px;"><b>Shifting Distribution List to Shared Mailbox</b></p>
                                <div class="row m-0 mb-5">
                                    <p class="p-0" style="cursor: pointer">Shifting Distribution List to Shared Mailboxt</p>
                                </div>
                                <a href="" style="color:blue; cursor: pointer">View Details</a>
                            </div>
                        </div>
                    </div>
                </section>

                <section id="standardListView" class="hideIt table-responsive">
                    <table class="custom-table-catalog px-2 rounded border" style="font-size: 12px;">
                        <thead>
                            <tr>
                                <th style="width:40%;padding:10px;">Item</th>
                                <th style="width:60%;padding:10px;">Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="item-td">
                                    <a style="cursor: pointer; color: blue; text-decoration: underline; font-size: 12px">Shifting Distribution List to Shared Mailbox</a>
                                </td>
                                <td class="descrption-td" style="vertical-align: middle;">
                                    <p style="font-size: 12px">Shifting Distribution List to Shared Mailbox</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </section>

            </div>
        </div>



        <script>
            $(document).ready(function() {
                $('#example').hierarchySelect({
                    hierarchy: false,
                    width: 'auto'
                });
            });

            function changeSideMenu(txt) {
                if (txt == 'infTech') {
                    $('#infTech').addClass('activeCatalog');
                    $('#standChanges').removeClass('activeCatalog');
                    $('#informationTech').addClass('showIt').removeClass('hideIt');
                    $('#standardChanges').addClass('hideIt').removeClass('showIt');
                } else {
                    $('#standChanges').addClass('activeCatalog');
                    $('#infTech').removeClass('activeCatalog');
                    $('#informationTech').addClass('hideIt').removeClass('showIt');
                    $('#standardChanges').addClass('showIt').removeClass('hideIt');
                }
            }

            function changeView(txt) {
                if (txt == 'catCardView') {
                    $('#catCardView').addClass('activeCatalog');
                    $('#catListView').removeClass('activeCatalog');
                    $('#catalogCardView').addClass('showIt').removeClass('hideIt');
                    $('#cataLogListView').addClass('hideIt').removeClass('showIt');
                } else if (txt == 'catListView') {
                    $('#catListView').addClass('activeCatalog');
                    $('#catCardView').removeClass('activeCatalog');
                    $('#catalogCardView').addClass('hideIt').removeClass('showIt');
                    $('#cataLogListView').addClass('showIt').removeClass('hideIt');
                } else if (txt == 'standCardView') {
                    $('#standCardView').addClass('activeCatalog');
                    $('#standListView').removeClass('activeCatalog');
                    $('#standardCardView').addClass('showIt').removeClass('hideIt');
                    $('#standardListView').addClass('hideIt').removeClass('showIt');
                } else if (txt == 'standListView') {
                    $('#standListView').addClass('activeCatalog');
                    $('#standCardView').removeClass('activeCatalog');
                    $('#standardCardView').addClass('hideIt').removeClass('showIt');
                    $('#standardListView').addClass('showIt').removeClass('hideIt');
                }
            }

            function showMoreItems() {
                $('#requestCard').removeClass('hideIt');
                $('#removeCard').removeClass('hideIt');
                $('#showBtnDiv').addClass('hideIt').removeClass('showIt');
            }
        </script>
        <script>
            document.addEventListener('livewire:load', function() {
                Livewire.on('closeModal', function() {
                    $('#yourModal').modal('hide'); // Replace 'yourModal' with the ID of your modal
                });
            });
        </script>