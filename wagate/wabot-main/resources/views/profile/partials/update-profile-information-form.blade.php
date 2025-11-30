<div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="section general-info">
        @csrf
        @method('patch')
        <div class="info">
            <h6 class="">General Information</h6>
            <div class="row">
                <div class="col-lg-11 mx-auto">
                    <div class="row">
                        <div class="col-xl-2 col-lg-12 col-md-4">
                            <div class="profile-image  mt-4 pe-md-4">

                                <!-- // The classic file input element we'll enhance
                                // to a file pond, we moved the configuration
                                // properties to JavaScript -->

                                <div class="img-uploader-content">
                                    <input type="file" class="filepond"
                                           name="filepond" accept="image/png, image/jpeg, image/gif"/>
                                </div>

                            </div>
                        </div>
                        <div class="col-xl-10 col-lg-12 col-md-8 mt-md-0 mt-4">
                            <div class="form">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <x-input-label for="name" :value="__('Name')" />
                                            <x-text-input id="name" name="name" type="text" class="form-control mb-3" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <x-input-label for="email" :value="__('Email')" />
                                            <x-text-input id="email" name="email" type="email" class="form-control mb-3" :value="old('email', $user->email)" required autocomplete="username" />
                                            <x-input-error class="mt-2" :messages="$errors->get('email')" />

                                            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                                <div>
                                                    <p class="text-sm mt-2 text-gray-800">
                                                        {{ __('Your email address is unverified.') }}

                                                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                            {{ __('Click here to re-send the verification email.') }}
                                                        </button>
                                                    </p>

                                                    @if (session('status') === 'verification-link-sent')
                                                        <p class="mt-2 font-medium text-sm text-green-600">
                                                            {{ __('A new verification link has been sent to your email address.') }}
                                                        </p>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-12 mt-1">
                                        <div class="form-group text-end">
                                            <button class="btn btn-primary mt-4">{{ __('Save') }}</button>

                                            @if (session('status') === 'profile-updated')
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

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
