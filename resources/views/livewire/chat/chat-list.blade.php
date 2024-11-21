<div class="sidebar-list-contacts" id="contacts">
    <div class="top">
        <a href="/">
            <div class="nav-toggle btn">
                <span class="material-icons">keyboard_backspace</span>
            </div>
        </a>
        <div class="title">Contacts</div>
    </div>

    <div class="body">
        <div class="input-group mb-3">
            <span class="input-group-text bg-white pe-0" id="basic-addon1">
                <i class="fa-solid fa-magnifying-glass"></i>
            </span>
            <input type="text" class="contSearch form-control" wire:model.live="search"
                placeholder="Search for a name, email, or phone number" aria-label="Search"
                aria-describedby="basic-addon1">
        </div>

        <div class="list-users">
            <!-- Display Filtered Conversations -->
            @forelse ($conversations as $employee)
                <div class="item @if ($employee->isOnline()) active @endif">
                    <div class="avatar-chart">
                        <img src="{{ $employee->image
                            ? 'data:image/jpeg;base64,' . $employee->image
                            : ($employee->gender === 'MALE'
                                ? asset('images/male-default.png')
                                : asset('images/female-default.jpg')) }}"
                            alt="Avatar">
                        <span class="dot @if ($employee->isOnline()) -online @else -offline @endif"></span>
                    </div>
                    <div class="text-content" wire:key='{{ $employee->id }}'
                        wire:click="$dispatch('chatUserSelected', { senderId: '{{ auth()->user()->emp_id }}', receiverId: '{{ $employee->emp_id }}' })">
                        <div class="name">{{ $employee->first_name }} {{ $employee->last_name }}</div>
                        <div class="pos">{{ $employee->job_role }}</div>
                    </div>

                    <div class="actions">
                        <button class="btn"
                            wire:click="$dispatch('chatUserSelected', { senderId: '{{ auth()->user()->emp_id }}', receiverId: '{{ $employee->emp_id }}' })">
                            <span class="material-icons position-relative">
                                question_answer
                                <span
                                    class="msgCount badge rounded-pill text-bg-danger">{{ $employee->unreadMessagesCount }}</span>
                            </span>
                        </button>
                    </div>
                </div>
            @empty
                <p class="text-center">No contacts found.</p>
            @endforelse
        </div>
    </div>
</div>
