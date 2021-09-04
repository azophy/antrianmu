@extends('layouts.app')

@section('content')

<h1 class="title">{{ $title }}</h1>

<ul>
  <li>Nomor antrian saat ini: <strong>{{ $ticket_current }}</strong></li>
  <li>Nomor antrian terakhir: <strong>{{ $ticket_last }}</strong></li>
  <li>Batas nomor antrian hari ini: <strong>{{ $ticket_limit }}</strong></li>
</ul>

<form action="{{ route('guest.add', compact('slug')) }}" method="post">
    @csrf
    <button class="button is-medium is-info">Ambil nomor antrian baru</button>
</form>

@endsection
