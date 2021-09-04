@extends('layouts.app')

@section('content')

<h1 class="title">Tiket untuk antrian "{{ $queue->title }}"</h1>

<ul>
  <li>Nomor antrian anda: <strong>{{ $ticket->order }}</strong></li>
  <li>Nomor antrian saat ini: <strong>{{ $queue->ticket_current }}</strong></li>
  <li>Nomor antrian terakhir: <strong>{{ $queue->ticket_last }}</strong></li>
  <li>Tautan untuk tiket ini: <strong>
        <a href="{{ route('ticket.view', ['code' => $ticket->secret_code ]) }}">
            {{ route('ticket.view', ['code' => $ticket->secret_code ]) }}
        </a>
  </strong></li>
</ul>

@endsection
