<x-umum-layout :scrollspy="false">
    <x-slot:title>Login - {{ config('app.name', 'Laravel') }}</x-slot:title>

    <x-slot:headers>
        @vite(['resources/scss/dark/assets/authentication/auth-cover.scss'])
    </x-slot:headers>

    <div class="auth-container d-flex">
        <div class="container mx-auto align-self-center">
            <div class="row">
                <div class="col-6 d-lg-flex d-none h-100 my-auto top-0 start-0 text-center justify-content-center flex-column">
                    <div class="auth-cover-bg-image"></div>
                    <div class="auth-overlay"></div>

{{--                    <div class="auth-cover">--}}
{{--                        <div class="position-relative">--}}
{{--                            <img src="{{Vite::asset('resources/images/auth-cover.svg')}}" alt="auth-img">--}}
{{--                            <h2 class="mt-5 text-white font-weight-bolder px-2">Join the community of expert developers</h2>--}}
{{--                            <p class="text-white px-2">It is easy to setup with great customer experience. Start your 7-day free trial</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>


                <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-8 col-12 d-flex flex-column align-self-center ms-lg-auto me-lg-0 mx-auto">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <h2>Sign In</h2>
                                        <p>Enter your email and password to login</p>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <x-input-label for="email" :value="__('Email')" />

                                            <x-text-input id="email" class="form-control"
                                                          type="email"
                                                          name="email"
                                                          :value="old('email')"
                                                          required autofocus autocomplete="username" />

                                            <x-input-error :messages="$errors->get('email')" />
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-4">
                                            <x-input-label for="password" :value="__('Password')" />

                                            <x-text-input id="password" class="form-control"
                                                          type="password"
                                                          name="password"
                                                          required auto-complete="current-password" />

                                            <x-input-error :messages="$errors->get('password')" />
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <div class="form-check form-check-primary form-check-inline">
                                                <label class="form-check-label" for="remember_me">
                                                    <input class="form-check-input me-3" type="checkbox" id="remember_me" name="remember_me">
                                                    Remember me
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="mb-4">
                                            <x-primary-button class="btn btn-secondary w-100">
                                                {{ __('Log in') }}
                                            </x-primary-button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>

    <x-slot:footers>

    </x-slot:footers>
</x-umum-layout>
