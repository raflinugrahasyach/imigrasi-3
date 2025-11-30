<x-base-layout :scrollspy="false">
    <x-slot:title>Autoresponse Template</x-slot:title>

    <x-slot:headers>
        @vite(['resources/scss/dark/assets/pages/contact_us.scss'])
    </x-slot:headers>

    <!-- breadcrumb -->
    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Template</a></li>
                <li class="breadcrumb-item active" aria-current="page">Autoresponse</li>
            </ol>
        </nav>
    </div>
    <!-- /breadcrumb -->

    <div class="statbox widget box box-shadow layout-top-spacing">
        <div class="widget-content widget-content-area">
            <div class="contact-us-form">
                <div class="row gx-5">
                    <div class="col-md-6">
                        <form method="post" action="{{ route('template.autoresponse.update', $template ?? 0) }}" class="row g-4">
                            @csrf
                            @method('patch')
                            <div class="col-md-12">
                                <h5>Template Autoresponse</h5>
                            </div>
                            <div class="col-md-12">
                                <label for="pesan" class="form-label">Isi Pesan Ketika Kosong</label>
                                <textarea id="kosong" name="kosong" class="form-control" cols="30" rows="10">{{ $template?->kosong }}</textarea>
                            </div>
                            <div class="col-md-12">
                                <label for="pesan" class="form-label">Isi Pesan Belum Diambil</label>
                                <textarea id="belum" name="belum" class="form-control" cols="30" rows="10">{{ $template?->belum_diambil }}</textarea>
                            </div>
                            <div class="col-12">
                                <label for="peringatan" class="form-label">Isi Pesan Sudah Diambil</label>
                                <textarea id="sudah" name="sudah" class="form-control" cols="30" rows="10">{{ $template?->sudah_diambil }}</textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                            </div>
                        </form>
                    </div>

                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12">
                                <h5>Panduan Kode Pesan</h5>
                                <p>{name} : Nama pemohon</p>
                                <p>{var1} : Nomor pemohon</p>
                                <p>{var2} : Catatan petugas</p>
                                <p>{var3} : Nomor paspor</p>
                                <p>{var4} : Tanggal input ke Krisna</p>
                                <p>{var5} : Lama paspor belum diambil</p>
                                <p>{var6} : Nama penerima</p>
                                <p>{var7} : Tanggal serah paspor</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot:footers></x-slot:footers>
</x-base-layout>
