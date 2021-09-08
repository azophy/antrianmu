@extends('layouts.app')

@section('content')

@include('common.package_type_notification', compact('queue'))

<h1 class="title">{{ $queue->title }}</h1>

@php
$counter_url = route('guest.counter', ['slug' => $queue->slug ]);
$admin_url = route('admin.setting', ['slug' => $queue->slug ]);
@endphp

<div
    class="notification is-primary has-text-centered is-clickable"
    style="max-width: 300px;"
    onclick="nextTicket()"
    disabled
>
    <p>Nomor antrian saat ini:</p>
    <h1 class="title is-1">{{ $queue->ticket_current }}</h1>
    <p>(klik tombol ini untuk ke nomor antrian berikutnya)</p>
</div>

<div
    class="notification is-info has-text-centered is-clickable"
    style="max-width: 300px;"
    onclick="addTicket()"
>
    <p>Nomor antrian terakhir:</p>
    <h1 class="title is-1">{{ $queue->ticket_last }}</h1>
    <p>(klik tombol ini untuk mengambil nomor antrian baru)</p>
</div>

<ul>
  <li>Batas berlaku antrian ini: <strong>{{ $queue->valid_until }}</strong></li>
  <li>Batas nomor antrian hari ini: <strong>{{ $queue->ticket_limit }}</strong></li>
  <li>Tautan untuk antrian ini (untuk pengunjung): <strong>
        <a target="_blank" href="{{ $counter_url }}">{{ $counter_url }}</a>
  </strong></li>
</ul>

<script>
function nextTicket() {
    document.getElementById('formNextTicket').submit();
}
function addTicket() {
    document.getElementById('formAddTicket').submit();
    setTimeout('location.reload();', 2000)
}
</script>

<form id="formNextTicket" action="{{ route('admin.next', [ 'slug' => $queue->slug ]) }}" method="post">
    @csrf
</form>
<form id="formAddTicket" action="{{ route('guest.add', [ 'slug' => $queue->slug ]) }}" method="post" target="_blank">
    @csrf
</form>

@endsection
