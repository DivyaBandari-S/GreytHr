<div class="bg-white">
    <div class="text-end pt-3">
        <button class="btn btn-primary btn-sm mb-2 me-3" wire:click="openRequestModal"
            style="background-color: #02114f;">Request Feedback</button>
        <button class="btn btn-primary btn-sm mb-2 me-3" wire:click="openGiveModal" style="background-color: #02114f;">Give
            Feedback</button>
    </div>
    <div>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button wire:click="loadTabData('received')"
                    class="nav-link {{ $activeTab === 'received' ? 'active' : '' }}">Received</button>
            </li>
            <li class="nav-item" role="presentation">
                <button wire:click="loadTabData('given')"
                    class="nav-link {{ $activeTab === 'given' ? 'active' : '' }}">Given</button>
            </li>
            <li class="nav-item" role="presentation">
                <button wire:click="loadTabData('pending')"
                    class="nav-link {{ $activeTab === 'pending' ? 'active' : '' }}">Pending</button>
            </li>
            <li class="nav-item" role="presentation">
                <button wire:click="loadTabData('drafts')"
                    class="nav-link {{ $activeTab === 'drafts' ? 'active' : '' }}">Drafts</button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" role="tabpanel">
                <div class="row m-0">
                    <div class="col-md-8 p-0">
                        @if ($feedbacks->count() > 0)
                            <div class="p-4" style="max-height: 400px; overflow-y: auto;">
                                <div class="mb-3 d-flex">
                                    <div class="col-auto">
                                        <input type="text" class="form-control" placeholder="Search feedback..."
                                            wire:model.live="searchFeedback">
                                    </div>
                                </div>
                                @foreach ($feedbacks as $feedback)
                                    <div class="border p-3 mb-3 rounded shadow-sm">
                                        <div class="d-flex align-items-start">
                                            <!-- Determine if auth user is the receiver -->
                                            @php
                                                $isReceiver = $feedback->feedback_to == auth()->id();
                                                $displayUser = $isReceiver
                                                    ? $feedback->feedbackFromEmployee
                                                    : $feedback->feedbackToEmployee;
                                            @endphp

                                            <!-- User Avatar (Show sender if auth is receiver, else show receiver) -->
                                            <div class="rounded-circle bg-warning text-white d-flex align-items-center justify-content-center"
                                                style="width: 40px; height: 36px; font-weight: bold;">
                                                {{ strtoupper(substr($displayUser->first_name ?? 'A', 0, 1)) }}
                                            </div>

                                            <div class="ms-3 w-100">
                                                <div class="d-flex justify-content-between">
                                                    <div class="fs12">
                                                        <!-- Show the correct user's details -->
                                                        <strong>
                                                            {{ $displayUser->first_name ?? 'Unknown' }}
                                                            {{ $displayUser->last_name ?? '' }}
                                                        </strong>
                                                        <small class="text-muted">#{{ $displayUser->emp_id }}</small>
                                                    </div>

                                                    <div class="fs12">
                                                        @if ($feedback->is_declined)
                                                            <span class="badge bg-danger">Declined</span>
                                                        @endif
                                                        <small
                                                            class="text-muted">{{ $feedback->created_at->diffForHumans() }}</small>
                                                        @if ($feedback->feedback_from == auth()->id() && $feedback->feedback_type === 'give')
                                                            <div class="btn-group dropcust">
                                                                <button type="button"
                                                                    class="btn dropdown-toggle btn-sm"
                                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i class="bi bi-three-dots-vertical"></i>
                                                                </button>
                                                                <ul class="dropdown-menu dropdown-menu-end fs12">
                                                                    <!-- Dropdown menu links -->
                                                                    <li><a class="dropdown-item" href="#"
                                                                            wire:click="editGiveFeedback({{ $feedback->id }})">Edit
                                                                            Feedback</a></li>
                                                                    <li><a class="dropdown-item" href="#"
                                                                            wire:click="confirmDelete({{ $feedback->id }})">Delete
                                                                            Feedback</a></li>
                                                                    @if ($feedback->is_draft)
                                                                        <li><a class="dropdown-item" href="#"
                                                                                wire:click="withDrawnGivenFeedback({{ $feedback->id }})">Withdraw
                                                                                Feedback</a></li>
                                                                    @endif
                                                                </ul>
                                                            </div>
                                                        @endif
                                                    </div>

                                                </div>

                                                <p class="fs12">
                                                    @if ($isReceiver)
                                                        <small class="text-muted">Feedback request from
                                                            {{ $displayUser->first_name ?? 'Unknown' }}</small>
                                                    @else
                                                        <small class="text-muted">Feedback given to
                                                            {{ $displayUser->first_name ?? 'Unknown' }}</small>
                                                    @endif
                                                </p>

                                                <p class="feedBackMsg fs12">{{ $feedback->feedback_message }}</p>

                                                @if ($feedback->is_accepted)
                                                    <div class="reply-box fs12">
                                                        <p class="feedBackMsg"><strong>Reply:</strong>
                                                            {{ $feedback->replay_feedback_message }}</p>
                                                        <p class="feedBackMsg"><strong>Replied At:</strong>
                                                            {{ $feedback->updated_at->diffForHumans() }}</p>
                                                    </div>
                                                @endif

                                                @if ($isReceiver && $activeTab === 'pending')
                                                    <button class="btn btn-sm btn-success"
                                                        wire:click="openReplyModal({{ $feedback->id }})">
                                                        Reply
                                                    </button>

                                                    <button class="btn btn-sm btn-danger fs12"
                                                        wire:click="declineFeedback({{ $feedback->id }})">
                                                        Decline
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        @else
                            <div class="m-0 pt-4 row text-center">
                                <img src="{{ asset('images/' . $activeTab . '.png') }}" class="m-auto"
                                    style="width: 10em" />
                                <h5>No {{ ucfirst($activeTab) }} Feedback</h5>
                                <p>
                                    @if ($activeTab === 'received')
                                        Let's gather a new outlook from your coworkers.
                                    @elseif($activeTab === 'given')
                                        Share your valuable feedback with your colleagues.
                                    @elseif($activeTab === 'pending')
                                        Your requests and feedback requests from peers will appear here. Once feedback
                                        is
                                        shared, it will move to received or given sections.
                                    @elseif($activeTab === 'drafts')
                                        Capture your thoughts on feedback and find it later.
                                    @endif
                                </p>
                                <div>
                                    <button class="btn btn-primary" style="background-color: #02114f;"
                                        wire:click="{{ $activeTab === 'given' || $activeTab === 'drafts' ? 'openGiveModal' : 'openRequestModal' }}">
                                        {{ $activeTab === 'given' || $activeTab === 'drafts' ? 'Give Feedback' : 'Request Feedback' }}
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-4 text-center border-start border-1 ps-3"
                        wire:key="feedback-section-{{ $activeTab }}">
                        <img src="{{ asset('images/' . $feedbackImage) }}" class="mb-1 mt-5" style="width: 10em" />
                        <p class="fs12 fw-bold" wire:key="empty-text-{{ $activeTab }}">{{ $feedbackEmptyText }}</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Modal -->
    <!-- Request Feedback Modal -->
    @if ($isRequestModalOpen)
        <div class="modal show d-block" tabindex="-1" style="background: rgba(0, 0, 0, 0.5);">
            <div class="modal-dialog reqModal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Request Feedback</h1>
                        <button type="button" class="btn-close" wire:click="closeModal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row m-0">
                            <div class="col-md-12 reqForm">
                                <form wire:submit.prevent="saveFeedback">
                                    <div class="mb-3">
                                        <label class="form-label">Search Employee <span
                                                class="text-danger">*</span></label>

                                        <!-- If an employee is selected, show a structured display -->
                                        @if ($selectedEmployee)
                                            <div class="selected-employee-display p-2 border rounded d-flex align-items-center"
                                                style="background: #f8f9fa;">
                                                <div class="initials-circle text-white d-flex justify-content-center align-items-center"
                                                    style="width: 40px; height: 40px; border-radius: 10%; background: #f5c391; font-weight: bold;">
                                                    {{ strtoupper(substr($selectedEmployee['first_name'], 0, 1)) }}{{ strtoupper(substr($selectedEmployee['last_name'], 0, 1)) }}
                                                </div>
                                                <div class="ms-2">
                                                    <strong>{{ $selectedEmployee['first_name'] }}
                                                        {{ $selectedEmployee['last_name'] }}</strong>
                                                    <div style="color: #5e6e8f; font-size: 14px;">
                                                        #{{ $selectedEmployee['emp_id'] }}</div>
                                                </div>
                                                <button type="button" class="btn btn-sm btn-outline-danger ms-auto"
                                                    wire:click="clearSelectedEmployee"><i
                                                        class="bi bi-dash"></i></button>
                                            </div>
                                        @else
                                            <!-- Show input field when no employee is selected -->
                                            <input type="text" class="form-control"
                                                wire:model.live="searchEmployee"
                                                placeholder="Search by name or employee ID">
                                        @endif

                                        @error('selectedEmployee')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                        <!-- Display the search results as a dropdown -->
                                        @if (count($employees) > 0)
                                            <ul class="list-group mt-2" style="max-height: 150px; overflow-y: auto;">
                                                @foreach ($employees as $employee)
                                                    <li class="list-group-item d-flex align-items-center mb-1"
                                                        style="cursor: pointer; border-radius: 8px; border: 1px solid #e3e3e3; padding: 10px;"
                                                        wire:click="selectEmployee('{{ $employee->emp_id }}')">
                                                        <div
                                                            style="background-color: #f5c391; color: white; font-weight: bold;
                                                                    text-align: center; width: 40px; height: 40px; border-radius: 50%;
                                                                    display: flex; justify-content: center; align-items: center; margin-right: 10px;">
                                                            {{ strtoupper(substr($employee->first_name, 0, 1)) }}{{ strtoupper(substr($employee->last_name, 0, 1)) }}
                                                        </div>
                                                        <div>
                                                            <div style="font-weight: bold;">
                                                                {{ $employee->first_name }}
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
                                        {{-- <div id="requestRichText"></div> --}}
                                        {{-- <div id="requestRichText" wire:model.lazy="feedbackMessage"></div> --}}
                                        <textarea id="requestRichText" class="form-control" wire:model.lazy="feedbackMessage"></textarea>
                                        @error('feedbackMessage')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="row m-0 text-end">
                                        <p class="p-0">
                                            <span class="aiChip" onclick="openAIAssist()">
                                                <img src="images/fav.jpeg" style="width: 1.4em; margin-right: 2px;" />
                                                hrXpertAI
                                            </span>
                                        </p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            wire:click="closeModal">Close</button>
                                        <button type="submit" class="btn btn-primary"
                                            style="background-color: #02114f;">Save changes</button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-5 reqAssist d-none">
                                <div class="row m-0" style="border: 1px solid #02114f; border-radius: 10px;">
                                    <p class="textAI mb-0">
                                        <img src="images/fav.jpeg" style="width: 1.4em; margin-right: 6px;" />
                                        hrXpertAI Assistant
                                    </p>
                                    <div class="m-0 pb-4 row text-center">
                                        <img src="images/tree.png" style="width: 6em; margin: 10px auto;" />
                                        <p class="fs-6 fw-bold">Ready to asisst</p>
                                        <p>Write something to see suggestions</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Give Feedback Modal -->
    @if ($isGiveModalOpen)
        <div class="modal show d-block" tabindex="-1" style="background: rgba(0, 0, 0, 0.5);">
            <div class="modal-dialog reqModal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Give Feedback</h1>
                        <button type="button" class="btn-close" wire:click="closeModal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row m-0">
                            <div class="col-md-12 reqForm">
                                <form wire:submit.prevent="saveFeedback">
                                    <div class="mb-3">
                                        <label class="form-label">Search Employee <span
                                                class="text-danger">*</span></label>

                                        <!-- If an employee is selected, show a structured display -->
                                        @if ($selectedEmployee)
                                            <div class="selected-employee-display p-2 border rounded d-flex align-items-center"
                                                style="background: #f8f9fa;">
                                                <div class="initials-circle text-white d-flex justify-content-center align-items-center"
                                                    style="width: 40px; height: 40px; border-radius: 10%; background: #f5c391; font-weight: bold;">
                                                    {{ strtoupper(substr($selectedEmployee['first_name'], 0, 1)) }}{{ strtoupper(substr($selectedEmployee['last_name'], 0, 1)) }}
                                                </div>
                                                <div class="ms-2">
                                                    <strong>{{ $selectedEmployee['first_name'] }}
                                                        {{ $selectedEmployee['last_name'] }}</strong>
                                                    <div style="color: #5e6e8f; font-size: 14px;">
                                                        #{{ $selectedEmployee['emp_id'] }}</div>
                                                </div>
                                                <button type="button" class="btn btn-sm btn-outline-danger ms-auto"
                                                    wire:click="clearSelectedEmployee"><i
                                                        class="bi bi-dash"></i></button>
                                            </div>
                                        @else
                                            <!-- Show input field when no employee is selected -->
                                            <input type="text" class="form-control"
                                                wire:model.live="searchEmployee"
                                                placeholder="Search by name or employee ID">
                                        @endif

                                        @error('selectedEmployee')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                        <!-- Display the search results as a dropdown -->
                                        @if (count($employees) > 0)
                                            <ul class="list-group mt-2" style="max-height: 150px; overflow-y: auto;">
                                                @foreach ($employees as $employee)
                                                    <li class="list-group-item d-flex align-items-center mb-1"
                                                        style="cursor: pointer; border-radius: 8px; border: 1px solid #e3e3e3; padding: 10px;"
                                                        wire:click="selectEmployee('{{ $employee->emp_id }}')">
                                                        <div
                                                            style="background-color: #f5c391; color: white; font-weight: bold;
                                                                text-align: center; width: 40px; height: 40px; border-radius: 50%;
                                                                display: flex; justify-content: center; align-items: center; margin-right: 10px;">
                                                            {{ strtoupper(substr($employee->first_name, 0, 1)) }}{{ strtoupper(substr($employee->last_name, 0, 1)) }}
                                                        </div>
                                                        <div>
                                                            <div style="font-weight: bold;">
                                                                {{ $employee->first_name }}
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

                                    <div class="mb-4">
                                        <label class="form-label">Personalized Message <span
                                                class="text-danger">*</span></label>
                                        <textarea id="requestRichText" class="form-control" wire:model.lazy="feedbackMessage"></textarea>
                                        @error('feedbackMessage')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="row m-0 text-end">
                                        <p class="p-0">
                                            <span class="aiChip" onclick="openAIAssist()">
                                                <img src="images/fav.jpeg" style="width: 1.4em; margin-right: 2px;" />
                                                hrXpertAI
                                            </span>
                                        </p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            wire:click="closeModal">Close</button>
                                        <button type="button" class="btn btn-warning"
                                            wire:click="saveAsGivenDraft">Save as Draft</button>
                                        <button type="submit" class="btn btn-primary"
                                            style="background-color: #02114f;">Save changes</button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-5 reqAssist d-none">
                                <div class="row m-0" style="border: 1px solid #02114f; border-radius: 10px;">
                                    <p class="textAI mb-0">
                                        <img src="images/fav.jpeg" style="width: 1.4em; margin-right: 6px;" />
                                        hrXpertAI Assistant
                                    </p>
                                    <div class="m-0 pb-4 row text-center">
                                        <img src="images/tree.png" style="width: 6em; margin: 10px auto;" />
                                        <p class="fs-6 fw-bold">Ready to asisst</p>
                                        <p>Write something to see suggestions</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endif
    {{-- accept or reply the request feedback --}}
    <!-- Request Feedback Modal -->
    @if ($isReplyModalOpen)
        <div class="modal fade show d-block" tabindex="-1" role="dialog" style="background: rgba(0,0,0,0.5);">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Reply to Feedback</h1>
                        <button type="button" class="btn-close" wire:click="closeModal"
                            aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <!-- Selected Employee -->
                        @if ($selectedEmployee)
                            <div class="selected-employee-display p-2 border rounded d-flex align-items-center"
                                style="background: #f8f9fa;">
                                <div class="initials-circle text-white d-flex justify-content-center align-items-center"
                                    style="width: 40px; height: 40px; border-radius: 10%; background: #f5c391; font-weight: bold;">
                                    {{ strtoupper(substr($selectedEmployee['first_name'], 0, 1)) }}{{ strtoupper(substr($selectedEmployee['last_name'], 0, 1)) }}
                                </div>
                                <div class="ms-2">
                                    <strong>{{ $selectedEmployee['first_name'] }}
                                        {{ $selectedEmployee['last_name'] }}</strong>
                                    <div style="color: #5e6e8f; font-size: 14px;">
                                        #{{ $selectedEmployee['emp_id'] }}</div>
                                </div>
                            </div>
                        @endif
                        <!-- Original Feedback -->
                        <div class="form-group">
                            <label>Original Feedback</label>
                            <textarea class="form-control" rows="3" wire:model="originalFeedbackText" disabled></textarea>
                        </div>

                        <!-- Reply Textarea -->
                        <div class="form-group">
                            <label>Your Reply</label>
                            <textarea class="form-control" rows="3" wire:model="replyText" placeholder="Type your reply..."></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeReplyModal">Cancel</button>
                        <button type="button" class="btn btn-primary" wire:click="submitReply">Send Reply</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- Edit Feedback Modal -->
    @if ($isEditModalVisible)
        <div class="modal fade show d-block" tabindex="-1" id="editFeedbackModal"
            style="background: rgba(0, 0, 0, 0.5);">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Feedback for {{ $employeeName }}</h5>
                        <button type="button" class="btn-close" wire:click="$set('isEditModalVisible', false)"
                            data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Selected Employee -->
                        @if ($selectedEmployee)
                            <div class="selected-employee-display p-2 border rounded d-flex align-items-center"
                                style="background: #f8f9fa;">
                                <div class="initials-circle text-white d-flex justify-content-center align-items-center"
                                    style="width: 40px; height: 40px; border-radius: 10%; background: #f5c391; font-weight: bold;">
                                    {{ strtoupper(substr($selectedEmployee['first_name'], 0, 1)) }}{{ strtoupper(substr($selectedEmployee['last_name'], 0, 1)) }}
                                </div>
                                <div class="ms-2">
                                    <strong>{{ $selectedEmployee['first_name'] }}
                                        {{ $selectedEmployee['last_name'] }}</strong>
                                    <div style="color: #5e6e8f; font-size: 14px;">
                                        #{{ $selectedEmployee['emp_id'] }}</div>
                                </div>
                            </div>
                        @endif

                        <!-- Editable Feedback Message -->
                        <div class="mb-3">
                            <label class="form-label">Personalized Message <span class="text-danger">*</span></label>
                            <textarea class="form-control" wire:model="updatedFeedbackMessage" rows="4">{{ $updatedFeedbackMessage }}</textarea>
                            @error('updatedFeedbackMessage')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm"
                            wire:click="$set('isEditModalVisible', false)">Cancel</button>
                        @if ($feedback->id && $feedback->is_draft)
                            <button type="button" class="btn btn-warning btn-sm"
                                wire:click="updateGiveFeedback">Save as
                                Draft</button>
                            <button type="button" class="btn btn-primary btn-sm" style="background-color: #02114f;"
                                wire:click="updateDraftGiveFeedback">Save
                                changes</button>
                        @else
                            <button type="button" class="btn btn-primary btn-sm" style="background-color: #02114f;"
                                wire:click="updateGiveFeedback">Save
                                changes</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Delete Confirmation Modal -->
    @if ($showDeleteModal)
        <div class="modal fade show d-block" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirm Delete</h5>
                        <button type="button" class="btn-close"
                            wire:click="$set('showDeleteModal', false)"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this feedback?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm"
                            wire:click="$set('showDeleteModal', false)">Cancel</button>
                        <button type="button" class="btn btn-danger btn-sm"
                            wire:click="deleteGiveFeedback">Delete</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    @endif



</div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function(event) {
        var quill = new Quill('#requestRichText', {
            theme: 'snow'
        });
    });
</script>
</script>
