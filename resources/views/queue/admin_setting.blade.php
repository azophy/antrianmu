@extends('layouts.app')

@section('content')

<h1 class="title">Setting untuk antrian: "{{ $queue->title }}"</h1>

@php
$guest_counter_url = route('guest.counter', ['slug' => $queue->slug ]);
$admin_counter_url = route('admin.counter', ['slug' => $queue->slug ]);
$admin_setting_url = route('admin.setting', ['slug' => $queue->slug ]);
@endphp

@if (session('new'))
<div class="notification is-success">
  <strong>
      Selamat! Antrian anda sudah berhasil dibuat!
  </strong>

  <p>
      Sekarang anda bisa memberikan tautan/link halaman antrian anda ke pengunjung anda. Beberapa tautan penting:
  </p>

  <ul>
      <li>Tautan untuk antrian ini (untuk pengunjung): <strong>
            <a target="_blank" href="{{ $guest_counter_url }}">{{ $guest_counter_url }}</a>
      </strong></li>
      <li>Tautan untuk halaman counter antrian ini (untuk penyedia layanan/pengelola): <strong>
            <a href="{{ $admin_counter_url }}">{{ $admin_counter_url }}</a>
      </strong></li>
      <li>Tautan untuk halaman admin antrian ini (untuk penyedia layanan/pengelola): <strong>
            <a href="{{ $admin_setting_url }}">{{ $admin_setting_url }}</a>
      </strong></li>
  </ul>
</div>
@endif

@include('common.package_type_notification', compact('queue'))

<ul>
  <li>Kode rahasia untuk admin: <strong>{{ $queue->secret_code }}</strong></li>
  <li>Nomor antrian saat ini: <strong>{{ $queue->ticket_current }}</strong></li>
  <li>Nomor antrian terakhir: <strong>{{ $queue->ticket_last }}</strong></li>
  <li>Batas berlaku antrian ini: <strong>{{ $queue->valid_until }}</strong></li>
  <li>Batas nomor antrian hari ini: <strong>{{ $queue->ticket_limit }}</strong></li>
</ul>

<h3 class="title is-3">Ubah setting antrian</h3>
<form class="box" method="post" action="{{ route('admin.setting.update', [ $queue->slug ]) }}">
  @csrf

  @if ($errors->any())
  <div class="notification is-danger">
     <strong>Error!</strong> <br>
     <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
     </ul>
  </div>
  @endif

  <div class="field">
    <label class="label">Judul Antrian</label>
    <div class="control">
      <input class="input" type="text" name="title" value="{{$queue->title}}">
    </div>
  </div>

  <div class="field">
    <label class="label">Deskripsi</label>
    <div class="control">
      <textarea class="input" name="description" placeholder="beri paragraf penjelasan untuk halaman antrian anda">{{$queue->description}}</textarea>
    </div>
  </div>

  <button typw="submit" class="button is-primary">Simpan</button>
</form>

@endsection
