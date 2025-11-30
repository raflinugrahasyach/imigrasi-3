<x-base-layout :scrollspy="false">
    <x-slot:title>WhatsApp Template</x-slot:title>

    <x-slot:headers>
        @vite(['resources/scss/dark/assets/pages/contact_us.scss'])
    </x-slot:headers>

    <!-- breadcrumb -->
    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Template</a></li>
                <li class="breadcrumb-item active" aria-current="page">Notifikasi</li>
            </ol>
        </nav>
    </div>
    <!-- /breadcrumb -->

    <div class="statbox widget box box-shadow layout-top-spacing">
        <div class="widget-content widget-content-area">
            <div class="contact-us-form">
                <div class="row gx-5">
                    <div class="col-md-6">
                        <form method="post" action="{{ route('template.notifikasi.update', $template ?? 0) }}" class="row g-4">
                            @csrf
                            @method('patch')
                            <div class="col-md-12">
                                <h5>Template Notifikasi</h5>
                            </div>
                            <div class="col-md-12">
                                <label for="token" class="form-label">Token</label>
                                <input type="text" class="form-control" id="token" name="token" value="{{ $template?->token }}">
                                <x-input-error :messages="$errors->get('token')" class="mt-2" />
                            </div>
                            <div class="col-md-12">
                                <label for="pesan" class="form-label">Isi Pesan</label>
                                <textarea id="pesan" name="pesan" class="form-control" cols="30" rows="10">{{ $template?->pesan }}</textarea>
                                <x-input-error :messages="$errors->get('pesan')" class="mt-2" />
                            </div>
                            <div class="col-12">
                                <label for="peringatan" class="form-label">Isi Pesan Peringatan</label>
                                <textarea id="peringatan" name="peringatan" class="form-control" cols="30" rows="10">{{ $template?->pesan_peringatan }}</textarea>
                                <x-input-error :messages="$errors->get('peringatan')" class="mt-2" />
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot:footers></x-slot:footers>
</x-base-layout>
