<div>
    <div class="logout-icon-container">
        <i wire:click="handleLogout" class="fas fa-sign-out-alt"></i>
        <div wire:click="handleLogout" class="tooltip">Logout</div>a
    </div>

    <!-- Logout Modal -->
    @if ($showLogoutModal)
    <div class="modal" id="logoutModal" tabindex="-1" style="display: block;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header text-white" style="background-color: #9E9E9E;">
                    <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="cancelLogout"></button>
                </div>
                <div class="modal-body text-start">
                    Are you sure you want to logout?
                </div>
                <div class="d-flex justify-content-start p-3">
                    <button type="button" class="btn btn-primary" wire:click="confirmLogout">Confirm</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show"></div>
    @endif


</div>