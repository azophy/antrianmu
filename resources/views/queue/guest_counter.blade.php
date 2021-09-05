@extends('layouts.app')

@section('content')

<h1 class="title">{{ $queue->title }}</h1>

<p class="content is-normal">{{ $queue->description }}</p>

<ul>
  <li>Nomor antrian saat ini: <strong>{{ $queue->ticket_current }}</strong></li>
  <li>Nomor antrian terakhir: <strong>{{ $queue->ticket_last }}</strong></li>
  <li>Batas nomor antrian hari ini: <strong>{{ $queue->ticket_limit }}</strong></li>
</ul>

<form action="{{ route('guest.add', [ 'slug' => $queue->slug ]) }}" method="post">
    @csrf
    <button class="button is-medium is-info" {{ ($queue->ticket_last >= $queue->ticket_limit) ? 'disabled' : '' }}>Ambil nomor antrian baru</button>
</form>

@endsection
