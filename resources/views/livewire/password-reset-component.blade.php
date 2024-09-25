<div class="container vh-100 d-flex align-items-center justify-content-center">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header text-center bg-primary text-white">
                <h5>{{ __('Reset Password') }}</h5>
            </div>

            <div class="card-body">
                <form wire:submit.prevent="resetPassword">
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="form-group mb-3">
                        <label for="password" class="form-label">{{ __('Password') }}</label>
                        <input type="password" id="password" wire:model="newPassword" class="form-control @error('newPassword') is-invalid @enderror" placeholder="Enter your new password">
                        @error('newPassword')
                        <div class="invalid-feedback">
                            <span>{{ $message }}</span>
                        </div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                        <input type="password" id="password_confirmation" wire:model="confirmNewPassword" class="form-control @error('confirmNewPassword') is-invalid @enderror" placeholder="Confirm your new password">
                        @error('confirmNewPassword')
                        <div class="invalid-feedback">
                            <span>{{ $message }}</span>
                        </div>
                        @enderror
                    </div>

                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary btn-sm w-50">
                            {{ __('Reset Password') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>