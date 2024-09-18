@extends('TEKA.dashboard')

@section('content')
    <div class="container mt-1">
        <h4>Selamat Datang {{ Auth::user()->name }}, Anda Login Sebagai {{ Auth::user()->role }}</h4>
        <div class="d-flex justify-content-center my-4">
            <div class="border border-secondary p-5" style="width: 250px; height: 250px; background-image: url('{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('path/to/default/image.jpg') }}'); background-size: cover; background-position: center; margin-bottom: 20px;">
            </div>
        </div>
        <p>
        <strong>Silahkan <a href="{{ route('lengkapi-kompetensi-teka') }}" class="text-decoration-none">Isi Kompetensi</a> Anda!</strong>
        </p>
        @if(count($notifications) > 0)
            <div class="alert alert-warning">
                <ul>
                    @foreach($notifications as $notification)
                        <li>{{ $notification }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
@endsection
