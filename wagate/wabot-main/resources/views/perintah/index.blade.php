<x-base-layout :scrollspy="false">
    <x-slot:title>Commands</x-slot:title>

    <x-slot:headers>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>

        @vite(['resources/scss/dark/assets/elements/alert.scss'])
    </x-slot:headers>

    <!-- breadcrumb -->
    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('perintah.index') }}">Commands</a></li>
                <li class="breadcrumb-item active" aria-current="page">List</li>
            </ol>
        </nav>
    </div>
    <!-- /breadcrumb -->

    <div class="row layout-top-spacing">

        @if (session('success'))
            <div class="col-12">
                <div class="alert alert-arrow-right alert-icon-right alert-light-warning alert-dismissible fade show mb-4" role="alert">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12" y2="16"></line></svg>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-8">
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>

    <x-slot:footers>
        {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    </x-slot:footers>
</x-base-layout>
