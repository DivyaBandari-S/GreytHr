<div>
    <div class="logout-icon-container">
        <span wire:click="handleLogout"> <i class='fas fa-sign-out-alt'></i></span>
    </div>
    <!-- Logout Modal -->
    <!--[if BLOCK]><![endif]--><?php if($showLogoutModal): ?>
    <div class="modal" id="logoutModal" tabindex="-1" style="display: block;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header text-white" style=" background-color: rgb(2, 17, 79);">
                    <h6 class="modal-title " id="logoutModalLabel" style="align-items: center;">Confirm Logout</h6>
                </div>
                <div class="modal-body text-center" style="font-size: 14px;color:var( --main-heading-color);">
                    Are you sure you want to logout?
                </div>
                <div class="d-flex gap-3 justify-content-center p-3">
                    <button type="button" class="submit-btn mr-3" wire:click="confirmLogout">Logout</button>
                    <button type="button" class="cancel-btn1" wire:click="cancelLogout">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show"></div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->


</div><?php /**PATH C:\xampp\htdocs\GreytHr\resources\views/livewire/log-out.blade.php ENDPATH**/ ?>