@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="form-group mb-2">
                <a href="{{url('master-items')}}" class="btn btn-secondary">Kembali ke Daftar Item</a>
            </div>
            <div class="card">
                <div class="card-header">Detail Master Item</div>

                <div class="card-body">
                    <table class="table table-borderless">
                        @if($data->foto)
                        <tr>
                            <th style="width: 30%">Foto</th>
                            <td style="width: 5%">:</td>
                            <td>
                                <img src="{{ asset('storage/' . $data->foto) }}" alt="Foto Item" width="150" class="img-thumbnail">
                            </td>
                        </tr>
                        @endif
                        <tr>
                            <th style="width: 30%">Kode</th>
                            <td style="width: 5%">:</td>
                            <td>{{$data->kode}}</td>
                        </tr>
                        <tr>
                            <th>Nama</th>
                            <td>:</td>
                            <td>{{$data->nama}}</td>
                        </tr>
                        <tr>
                            <th>Kategori</th>
                            <td>:</td>
                            <td>
                                @if($data->categories->count() > 0)
                                    @foreach($data->categories as $cat)
                                        <span class="badge bg-info text-dark">{{ $cat->nama }}</span>
                                    @endforeach
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Harga Beli</th>
                            <td>:</td>
                            <td>Rp {{ number_format($data->harga_beli, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Laba</th>
                            <td>:</td>
                            <td>{{$data->laba}} %</td>
                        </tr>
                        <tr>
                            <th>Harga Jual</th>
                            <td>:</td>
                            <td>Rp {{ number_format(round($data->harga_beli + ($data->harga_beli * $data->laba / 100)), 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Supplier</th>
                            <td>:</td>
                            <td>{{$data->supplier}}</td>
                        </tr>
                        <tr>
                            <th>Jenis</th>
                            <td>:</td>
                            <td>{{$data->jenis}}</td>
                        </tr>
                    </table>
                    <a class="btn btn-info" href="{{url('master-items/form/edit')}}/{{$data->id}}">Edit</a>
                    <a class="btn btn-danger" href="{{url('master-items/delete')}}/{{$data->id}}" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
@endsection