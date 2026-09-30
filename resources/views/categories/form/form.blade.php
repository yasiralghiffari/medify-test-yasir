<form method="POST">
    @csrf

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-group mb-3">
        <label class="form-label">Kode Kategori</label>
        <input type="text" class="form-control" name="kode" required value="{{ old('kode', $category->kode ?? '') }}" placeholder="Contoh: KAT-001">
    </div>

    <div class="form-group mb-3">
        <label class="form-label">Nama Kategori</label>
        <input type="text" class="form-control" name="nama" required value="{{ old('nama', $category->nama ?? '') }}" placeholder="Contoh: Obat Obatan">
    </div>

    <button class="btn btn-primary mt-2">Submit</button>
</form>
