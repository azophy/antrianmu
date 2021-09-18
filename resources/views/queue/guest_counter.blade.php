@extends('layouts.app')

@section('content')

<h1 class="title">{{ $queue->title }}</h1>

<p class="content is-normal">{{ $queue->description }}</p>

<div
    class="notification is-primary has-text-centered"
    style="max-width: 300px;"
>
    <p>Nomor antrian saat ini:</p>
    <h1 class="title is-1">{{ $queue->ticket_current }}</h1>
</div>

<div
    class="notification is-info has-text-centered"
    style="max-width: 300px;"
>
    <p>Nomor antrian terakhir:</p>
    <h1 class="title is-1">{{ $queue->ticket_last }}</h1>
</div>

<ul>
  <li>Batas nomor antrian hari ini: <strong>{{ $queue->ticket_limit }}</strong></li>
  <li>Rata-rata lama per giliran: <strong>{{ $queue->displayLastAverage() }}</strong></li>
</ul>

<form action="{{ route('guest.add', [ 'slug' => $queue->slug ]) }}" method="post">
    @csrf
    <button class="button is-medium is-success" {{ ($queue->ticket_last >= $queue->ticket_limit) ? 'disabled' : '' }}>Ambil nomor antrian baru</button>
</form>

@endsection
