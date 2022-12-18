@extends('layouts.master')
@section('title', 'Edit Menu')
@section('content')
    <h2>Update Menu</h2>
    <form action="{{ route('menus.update', ['menu' => $menu->id]) }}" method="POST"> {{-- action buat ke update; method secara HTML tetap POST --}}
        @csrf
        @method('PATCH') {{-- Untuk update --}}
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="id">Menu Type</label>
                <select class="form-control @error('id') is-invalid @enderror" name="id" id="id">
                    <option value="none" disabled selected>Menu Type</option>
                    <option value="food"
                        @if (old('id') == null) @if (substr($menu->id, 0, 2) == 'FD')
                            selected @endif
                    @else {{ old('id') == 'food' ? 'selected' : '' }} @endif>Food</option>
                    <option value="drink"
                        @if (old('id') == null) @if (substr($menu->id, 0, 2) == 'DR')
                            selected @endif
                    @else {{ old('id') == 'drink' ? 'selected' : '' }} @endif>Drink</option>
                    <option value="dessert"
                        @if (old('id') == null) @if (substr($menu->id, 0, 2) == 'DS')
                            selected @endif
                    @else {{ old('id') == 'dessert' ? 'selected' : '' }} @endif>Dessert</option>
                </select>
                @error('id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-8 mb-3">
                <label for="nama">Nama</label>
                <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" id="nama"
                    value="{{ old('nama') ?? $menu->nama }}">
                @error('nama')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="harga">Harga</label>
                <input type="number" class="form-control @error('harga') is-invalid @enderror" name="harga"
                    id="harga" value="{{ old('harga') ?? $menu->harga }}" min="0">
                @error('harga')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-2 mb-3">
                <input type="hidden" name="rekomendasi" id="rekomendasi" value="0">
                <label for="rekomendasi">Rekomendasi</label>
                <input type="checkbox" class="form-check-input form-control @error('rekomendasi') is-invalid @enderror"
                    name="rekomendasi" id="rekomendasi" value="1"
                    @if (old('rekomendasi') == null)
                        @if ($menu->rekomendasi)
                            checked
                        @endif
                        @else
                            {{ old('rekomendasi') == 'true' ? 'checked' : '' }}
                    @endif>
                @error('rekomendasi')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <button class="btn btn-primary btn-lg btn-block" type="submit">Update</button>
</form> @endsection
