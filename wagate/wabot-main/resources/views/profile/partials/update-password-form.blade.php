<div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
    <div class="section general-info payment-info">
        <form method="post" action="{{ route('password.update') }}">
            @csrf
            @method('put')

            <div class="info">
                <h6 class="">{{ __('Update Password') }}</h6>
                <p>{{ __('Ensure your account is using a long, random password to stay secure.') }}</p>

                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <x-input-label class="form-label" for="update_password_current_password" :value="__('Current Password')" />
                            <x-text-input id="update_password_current_password" name="current_password" type="password" class="form-control" autocomplete="current-password" />
                            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <x-input-label class="form-label" for="update_password_password" :value="__('New Password')" />
                            <x-text-input id="update_password_password" name="password" type="password" class="form-control" autocomplete="new-password" />
                            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-3">
                            <x-input-label class="form-label" for="update_password_password_confirmation" :value="__('Confirm Password')" />
                            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password" />
                            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <div class="form-group text-end">
                    <button class="btn btn-primary mt-4">{{ __('Save') }}</button>

                    @if (session('status') === 'password-updated')
                        <p
                            x-data="{ show: true }"
                            x-show="show"
                            x-transition
                            x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-gray-600"
                        >{{ __('Saved.') }}</p>
                   @endif
                </div>
            </div>
        </form>
    </div>
</div>
