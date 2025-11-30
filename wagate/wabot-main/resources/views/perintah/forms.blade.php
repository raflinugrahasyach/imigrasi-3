<div class="col-md-12">
    <label for="token" class="form-label">Nama</label>
    <input type="text" class="form-control" id="nama" name="nama" value="{{ $perintah?->nama }}">
    <x-input-error :messages="$errors->get('nama')" class="mt-2" />
</div>
<div class="col-md-12">
    <label for="pesan" class="form-label">Isi Pesan</label>
    <textarea id="pesan" name="pesan" class="form-control" cols="30" rows="10">{{ $perintah?->pesan }}</textarea>
    <x-input-error :messages="$errors->get('pesan')" class="mt-2" />
</div>
<div class="col-12">
    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
</div>
