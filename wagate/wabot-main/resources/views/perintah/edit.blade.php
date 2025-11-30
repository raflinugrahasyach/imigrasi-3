<x-base-layout :scrollspy="false">
    <x-slot:title>Edit Commands</x-slot:title>

    <x-slot:headers>
        @vite(['resources/scss/dark/assets/pages/contact_us.scss'])
    </x-slot:headers>

    <!-- breadcrumb -->
    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('perintah.index') }}">Commands</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>
    </div>
    <!-- /breadcrumb -->

    <div class="statbox widget box box-shadow layout-top-spacing">
        <div class="widget-content widget-content-area">
            <div class="contact-us-form">
                <div class="row gx-5">
                    <div class="col-md-12">
                        <form method="post" action="{{ route('perintah.update', $perintah) }}" class="row g-4">
                            @csrf
                            @method('patch')

                            <div class="col-md-12">
                                <h5>Edit Commands</h5>
                            </div>
                            @include('perintah.forms')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot:footers></x-slot:footers>
</x-base-layout>
