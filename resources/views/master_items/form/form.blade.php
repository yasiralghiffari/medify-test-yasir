<form method="POST" enctype="multipart/form-data">
    @csrf
    @if($method == 'edit')
    <div class="form-group mb-3">
        <label class="form-label">Kode Barang</label>
        <input type="text" class="form-control" name="kode_barang" required readonly value="{{$item->kode ?? ''}}">
    </div>
    @endif

    <div class="form-group mb-3">
        <label class="form-label">Nama</label>
        <input type="text" class="form-control" name="nama" required value="{{$item->nama ?? ''}}">
    </div>

    <div class="form-group mb-3">
        <label class="form-label">Kategori</label>
        <div class="border rounded p-2" style="max-height: 150px; overflow-y: auto;">
            @if(isset($categories) && count($categories) > 0)
                @foreach($categories as $cat)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="categories[]" value="{{ $cat->id }}" id="cat-{{ $cat->id }}"
                            @if(in_array($cat->id, $selectedCategories ?? [])) checked @endif>
                        <label class="form-check-label" for="cat-{{ $cat->id }}">
                            [{{ $cat->kode }}] {{ $cat->nama }}
                        </label>
                    </div>
                @endforeach
            @else
                <small class="text-muted">Belum ada data kategori. Silakan buat di menu <a href="{{ url('/categories') }}" target="_blank">Kategori Items</a>.</small>
            @endif
        </div>
    </div>

    <div class="form-group mb-3">
        <label class="form-label">Foto Item</label>
        @if(!empty($item->foto))
            <div class="mb-2">
                <img src="{{ asset('storage/' . $item->foto) }}" alt="Foto Item" width="100" class="img-thumbnail">
            </div>
        @endif
        <input type="file" class="form-control" name="foto" accept="image/*">
        <small class="text-muted">Format: JPG, PNG, GIF (Maks. 2MB)</small>
    </div>

    <div class="form-group mb-3">
        <label class="form-label">Harga Beli</label>
        <input type="number" class="form-control" name="harga_beli" required value="{{$item->harga_beli ?? ''}}">
    </div>

    <div class="form-group mb-3">
        <label class="form-label">Laba (dalam persen)</label>
        <input type="number" class="form-control" name="laba" required value="{{$item->laba ?? ''}}">
    </div>

    @php $selected = $item->supplier ?? ''; @endphp
    <div class="form-group mb-3">
        <label class="form-label">Supplier</label>
        <select class="form-control" required name="supplier">
            <option @if($selected == '') selected @endif value="">--Pilih--</option>
            <option @if($selected == 'Tokopaedi') selected @endif>Tokopaedi</option>
            <option @if($selected == 'Bukulapuk') selected @endif>Bukulapuk</option>
            <option @if($selected == 'TokoBagas') selected @endif>TokoBagas</option>
            <option @if($selected == 'E Commurz') selected @endif>E Commurz</option>
            <option @if($selected == 'Blublu') selected @endif>Blublu</option>
        </select>
    </div>

    @php $selected = $item->jenis ?? ''; @endphp
    <div class="form-group mb-3">
        <label class="form-label">Jenis</label>
        <select class="form-control" required name="jenis">
            <option @if($selected == '') selected @endif value="">--Pilih--</option>
            <option @if($selected == 'Obat') selected @endif>Obat</option>
            <option @if($selected == 'Alkes') selected @endif>Alkes</option>
            <option @if($selected == 'Matkes') selected @endif>Matkes</option>
            <option @if($selected == 'Umum') selected @endif>Umum</option>
            <option @if($selected == 'ATK') selected @endif>ATK</option>
        </select>
    </div>

    <button class="btn btn-primary mt-3">Submit</button>
</form>