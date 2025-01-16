<div class="bg-white">
    <div class="text-end pt-3">
        <button class="btn btn-primary me-3" wire:click="openRequestModal">Request Feedback</button>
        <button class="btn btn-primary me-3" wire:click="openGiveModal">Give Feedback</button>
    </div>
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" id="nav-recieved-tab" data-bs-toggle="tab" data-bs-target="#nav-recieved"
                type="button" role="tab" aria-controls="nav-recieved" aria-selected="true">Recieved</button>
            <button class="nav-link" id="nav-given-tab" data-bs-toggle="tab" data-bs-target="#nav-given" type="button"
                role="tab" aria-controls="nav-given" aria-selected="false">Given</button>
            <button class="nav-link" id="nav-pending-tab" data-bs-toggle="tab" data-bs-target="#nav-pending"
                type="button" role="tab" aria-controls="nav-pending" aria-selected="false">Pending Request</button>
            <button class="nav-link" id="nav-drafts-tab" data-bs-toggle="tab" data-bs-target="#nav-drafts"
                type="button" role="tab" aria-controls="nav-drafts" aria-selected="false">Drafts</button>
        </div>
    </nav>
    <div class="tab-content bg-white pb-5" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-recieved" role="tabpanel" aria-labelledby="nav-recieved-tab"
            tabindex="0">
            <div class="m-0 pt-4 row text-center">
                <img src="images/recieved-feed.png" class="m-auto" style="width: 10em" />
                <h5>Seeking Advice?</h5>
                <p>Let's gather a new outlook from ypur coworkers</p>
                <div>
                    <button class="btn btn-primary" wire:click="openRequestModal">Request Feedback</button>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="given-tab-pane" role="tabpanel" aria-labelledby="given-tab" tabindex="0">
            <div class="m-0 pt-4 row text-center">
                <img src="images/given.png" class="m-auto" style="width: 10em" />
                <h5>Seeking Advice?</h5>
                <p>Let's gather a new outlook from your co-workers</p>
                <div>
                    <button class="btn btn-primary" wire:click="openGiveModal">Give Feedback</button>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="pending-tab-pane" role="tabpanel" aria-labelledby="pending-tab" tabindex="0">
            <div class="m-0 pt-4 row text-center">
                <img src="images/pending-request.png" class="m-auto" style="width: 10em" />
                <h5>See feedback requests and responses here</h5>
                <p>Your requests and feedback requests from peers will appear here. Once feedback is shared, it will
                    moved to recived or given sections</p>
                <div>
                    <button class="btn btn-primary" wire:click="openRequestModal">Request Feedback</button>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="drafts-tab-pane" role="tabpanel" aria-labelledby="drafts-tab" tabindex="0">
            <div class="m-0 pt-4 row text-center">
                <img src="images/drafts.png" class="m-auto" style="width: 10em" />
                <h5>Draft your feedback</h5>
                <p>Capture your thoughts on feedback and find it later</p>
                <div>
                    <button class="btn btn-primary"wire:click="openGiveModal">Give Feedback</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <!-- Request Feedback Modal -->
    @if ($isRequestModalOpen)
        <div class="modal show d-block" tabindex="-1" style="background: rgba(0, 0, 0, 0.5);">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Request Feedback</h1>
                        <button type="button" class="btn-close" wire:click="closeModal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="saveRequestFeedback">
                            <div class="mb-3">
                                <label class="form-label">Search Employee <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" wire:model.live="searchEmployee"
                                    placeholder="Search by name or employee ID">

                                @error('searchEmployee')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                                <!-- Display the search results as a dropdown -->
                                @if (count($employees) > 0)
                                    <ul class="list-group mt-2" style="max-height: 150px; overflow-y: auto;">
                                        @foreach ($employees as $employee)
                                            <li class="list-group-item d-flex align-items-center"
                                                style="cursor: pointer; border-radius: 8px; border: 1px solid #e3e3e3; padding: 10px;"
                                                wire:click="selectEmployee('{{ $employee->emp_id }}')">
                                                <div
                                                    style="
                                    background-color: #f5c391;
                                    color: white;
                                    font-weight: bold;
                                    text-align: center;
                                    width: 40px;
                                    height: 40px;
                                    border-radius: 50%;
                                    display: flex;
                                    justify-content: center;
                                    align-items: center;
                                    margin-right: 10px;
                                ">
                                                    {{ strtoupper(substr($employee->first_name, 0, 1)) }}{{ strtoupper(substr($employee->last_name, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <div style="font-weight: bold;">{{ $employee->first_name }}
                                                        {{ $employee->last_name }}</div>
                                                    <div style="color: #5e6e8f; font-size: 14px;">
                                                        #{{ $employee->emp_id }}</div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @elseif(strlen($searchEmployee) > 0)
                                    <p>No employees found</p>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Personalized Message <span
                                        class="text-danger">*</span></label>
                                <textarea id="requestRichText" class="form-control" wire:model.lazy="personalizedMessage"></textarea>
                                @error('personalizedMessage')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    wire:click="closeModal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Give Feedback Modal -->
    @if ($isGiveModalOpen)
        <div class="modal show d-block" tabindex="-1" style="background: rgba(0, 0, 0, 0.5);">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Give Feedback</h1>
                        <button type="button" class="btn-close" wire:click="closeModal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="saveGiveFeedback">
                            <div class="mb-3">
                                <label class="form-label">Search Employee <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" wire:model.live="searchEmployee"
                                    placeholder="Search by name or employee ID">

                                @error('searchEmployee')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                                <!-- Display the search results as a dropdown -->
                                @if (count($employees) > 0)
                                    <ul class="list-group mt-2" style="max-height: 150px; overflow-y: auto;">
                                        @foreach ($employees as $employee)
                                            <li class="list-group-item d-flex align-items-center"
                                                style="cursor: pointer; border-radius: 8px; border: 1px solid #e3e3e3; padding: 10px;"
                                                wire:click="selectEmployee('{{ $employee->emp_id }}')">
                                                <div
                                                    style="
                                            background-color: #f5c391;
                                            color: white;
                                            font-weight: bold;
                                            text-align: center;
                                            width: 40px;
                                            height: 40px;
                                            border-radius: 50%;
                                            display: flex;
                                            justify-content: center;
                                            align-items: center;
                                            margin-right: 10px;
                                        ">
                                                    {{ strtoupper(substr($employee->first_name, 0, 1)) }}{{ strtoupper(substr($employee->last_name, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <div style="font-weight: bold;">{{ $employee->first_name }}
                                                        {{ $employee->last_name }}</div>
                                                    <div style="color: #5e6e8f; font-size: 14px;">
                                                        #{{ $employee->emp_id }}</div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @elseif(strlen($searchEmployee) > 0)
                                    <p>No employees found</p>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Personalized Message <span
                                        class="text-danger">*</span></label>
                                <div id="giveRichText" class="form-control" style="height: 150px;"></div>
                                <input type="hidden" wire:model.lazy="personalizedMessage" id="hiddenGiveRichText">
                                @error('personalizedMessage')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    wire:click="closeModal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
</div>
