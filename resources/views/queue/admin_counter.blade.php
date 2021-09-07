@extends('layouts.app')

@section('content')

<h1 class="title">{{ $queue->title }}</h1>

@php
$counter_url = route('guest.counter', ['slug' => $queue->slug ]);
$admin_url = route('admin.setting', ['slug' => $queue->slug ]);
@endphp

<ul>
  <li>Nomor antrian saat ini: <strong>{{ $queue->ticket_current }}</strong></li>
  <li>Nomor antrian terakhir: <strong>{{ $queue->ticket_last }}</strong></li>
  <li>Batas berlaku antrian ini: <strong>{{ $queue->valid_until }}</strong></li>
  <li>Batas nomor antrian hari ini: <strong>{{ $queue->ticket_limit }}</strong></li>
  <li>Tautan untuk antrian ini (untuk pengunjung): <strong>
        <a target="_blank" href="{{ $counter_url }}">{{ $counter_url }}</a>
  </strong></li>
</ul>

<form action="{{ route('admin.next', [ 'slug' => $queue->slug ]) }}" method="post">
    @csrf
    <button class="button is-medium is-primary" {{ ($queue->ticket_current >= $queue->ticket_last) ? 'disabled' : '' }}>Lanjutkan nomor antrian</button>
</form>
<form action="{{ route('guest.add', [ 'slug' => $queue->slug ]) }}" method="post" target="_blank" onsubmit="setTimeout('location.reload();', 2000)">
    @csrf
    <button class="button is-medium is-info" {{ ($queue->ticket_last >= $queue->ticket_limit) ? 'disabled' : '' }}>Ambil nomor antrian baru</button>
</form>

@endsection
