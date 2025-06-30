@extends('layouts.mahasiswa')

@section('title', 'Data Mahasiswa')
@section('page_title', 'Data Mahasiswa')

@section('content')
    <div class="main-card custom-form-card"> {{-- Tambahkan class custom-form-card di sini --}}
        @if (session('success'))
            <div class="alert alert-success success-animation">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger error-animation">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('mahasiswa.profile.update') }}" method="POST" class="profile-edit-form">
            @csrf
            @method('POST')

            <div class="form-grid"> {{-- Wrapper untuk input menjadi grid --}}
                <div class="form-group">
                    <label for="nama"><i class="fas fa-user"></i> Nama Lengkap</label>
                    <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $mahasiswa->nama_lengkap) }}" required class="form-input @error('nama') is-invalid @enderror">
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="nim"><i class="fas fa-id-card"></i> NIM</label>
                    <input type="text" id="nim" name="nim" value="{{ old('nim', $mahasiswa->nim) }}" required class="form-input @error('nim') is-invalid @enderror">
                    @error('nim')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email"><i class="fas fa-envelope"></i> Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $mahasiswa->email) }}" required class="form-input @error('email') is-invalid @enderror">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="prodi"><i class="fas fa-graduation-cap"></i> Program Studi</label>
                    <input type="text" id="prodi" name="prodi" value="{{ old('prodi', $mahasiswa->prodi) }}" class="form-input @error('prodi') is-invalid @enderror">
                    @error('prodi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="angkatan"><i class="fas fa-calendar-alt"></i> Angkatan</label>
                    <input type="number" id="angkatan" name="angkatan" value="{{ old('angkatan', $mahasiswa->angkatan) }}" class="form-input @error('angkatan') is-invalid @enderror">
                    @error('angkatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="nomor_hp"><i class="fas fa-phone"></i> Nomor HP</label>
                    <input type="text" id="nomor_hp" name="nomor_hp" value="{{ old('nomor_hp', $mahasiswa->nomor_hp) }}" class="form-input @error('nomor_hp') is-invalid @enderror">
                    @error('nomor_hp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div> {{-- End of form-grid --}}

            <div class="form-actions">
                <a href="{{ route('mahasiswa.dashboard') }}" class="btn btn-secondary action-btn-back">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary action-btn-save">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        // Any specific scripts for edit_profile can go here.
    </script>
@endpush