@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="form-group mb-2 d-flex justify-content-between">
                <a href="{{url('categories')}}" class="btn btn-secondary">Kembali ke Daftar Kategori</a>
                <a href="{{route('categories.pdf', $category->id)}}" class="btn btn-danger">📄 Download PDF Printout</a>
            </div>
            <div class="card mb-4">
                <div class="card-header fw-bold">Detail Master Kategori</div>

                <div class="card-body">
                    <table class="table table-borderless" style="width: auto;">
                        <tr>
                            <th style="width: 150px;">Kode Kategori</th>
                            <td style="width: 20px;">:</td>
                            <td><span class="badge bg-primary fs-6">{{ $category->kode }}</span></td>
                        </tr>
                        <tr>
                            <th>Nama Kategori</th>
                            <td>:</td>
                            <td class="fw-bold">{{ $category->nama }}</td>
                        </tr>
                    </table>

                    <div class="mt-3 mb-2">
                        <a class="btn btn-info" href="{{url('categories/form/edit')}}/{{$category->id}}">Edit Kategori</a>
                        <a class="btn btn-danger" href="{{url('categories/delete')}}/{{$category->id}}" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">Delete Kategori</a>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header fw-bold">Daftar Item dalam Kategori "{{ $category->nama }}"</div>
                <div class="card-body">
                    @if($category->masterItems->count() > 0)
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Item</th>
                                    <th>Nama Item</th>
                                    <th>Jenis</th>
                                    <th>Supplier</th>
                                    <th>Harga Beli</th>
                                    <th>Harga Jual</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($category->masterItems as $index => $item)
                                    @php
                                        $hargaJual = round($item->harga_beli + ($item->harga_beli * $item->laba / 100));
                                    @endphp
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->kode }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->jenis }}</td>
                                        <td>{{ $item->supplier }}</td>
                                        <td>Rp {{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($hargaJual, 0, ',', '.') }}</td>
                                        <td>
                                            <a href="{{ url('master-items/view/' . $item->kode) }}" class="btn btn-sm btn-primary">View Item</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="alert alert-info mb-0">
                            Belum ada item yang terhubung dengan kategori ini.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
@endsection
