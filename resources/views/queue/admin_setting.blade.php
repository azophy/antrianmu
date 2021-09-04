@extends('layouts.app')

@section('content')

<h1 class="title">Judul antrian: "{{ $queue->title }}"</h1>

@php
$counter_url = route('guest.counter', ['slug' => $queue->slug ]);
$admin_url = route('admin.setting', ['slug' => $queue->slug ]);
@endphp

@if (session('new'))
<div class="notification is-success">
  Selamat! Antrian anda sudah berhasil dibuat!
  Sekarang anda bisa memberikan tautan/link halaman antrian anda ke pengunjung anda.
</div>
@endif

<ul>
  <li>Kode rahasia untuk admin: <strong>{{ $queue->secret_code }}</strong></li>
  <li>Nomor antrian saat ini: <strong>{{ $queue->ticket_current }}</strong></li>
  <li>Nomor antrian terakhir: <strong>{{ $queue->ticket_last }}</strong></li>
  <li>Batas berlaku antrian ini: <strong>{{ $queue->valid_until }}</strong></li>
  <li>Batas nomor antrian hari ini: <strong>{{ $queue->ticket_limit }}</strong></li>
  <li>Tautan untuk antrian ini (untuk pengunjung): <strong>
        <a href="{{ $counter_url }}">{{ $counter_url }}</a>
  </strong></li>
  <li>Tautan untuk halaman admin antrian ini (untuk penyedia layanan/pengelola): <strong>
        <a href="{{ $admin_url }}">{{ $admin_url }}</a>
  </strong></li>
</ul>

@endsection
