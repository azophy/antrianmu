@extends('layouts.app')

@section('content')
<div class="notification is-warning">
  <strong>Mohon simpan halaman tiket ini</strong>
  <p>Halaman ini adalah tanda bukti nomor antrian yang anda ambil. Silahkan simpan tautan/link halaman ini</p>
</div>

<div class="card mx-auto" style="max-width:400px">
  <header class="card-header">
    <p class="card-header-title">
        Tiket untuk antrian "{{ $queue->title }}"
    </p>
    <button class="card-header-icon" aria-label="more options">
      <span class="icon">
        <i class="fas fa-angle-down" aria-hidden="true"></i>
      </span>
    </button>
  </header>
  <div class="card-content">
    <div class="content has-text-centered">

      <div class="box is-primary">
        <p>Nomor antrian anda:</p>
        <p class="title" style="font-size:4rem">{{ $ticket->order }}</p>
        <p>Kode tiket anda:</p>
        <p class="title is-3 is-uppercase">{{ $ticket->secret_code }}</p>
      </div>

        <nav class="level is-mobile">
          <div class="level-item">
            <div>
              <p class="heading">Antrian sekarang:</p>
              <p class="title">{{ $queue->ticket_current }}</p>
            </div>
          </div>
          <div class="level-item has-text-centered">
            <div>
              <p class="heading">Antrian terakhir:</p>
              <p class="title">{{ $queue->ticket_last }}</p>
            </div>
          </div>
        </nav>

        <br>
        Perkiraan giliran: <strong>
            <time datetime="2016-1-1">{{ $ticket->turn_prediction->format('h:i') }}</time>
        </strong>
        <br>
        Rata-rata per giliran:
        <strong>
            <time>{{ $queue->meta['last_average'] }} detik</time>
        </strong>
        <br>
        <p>Tautan untuk tiket ini: </p>
        <a href="{{ route('ticket.view', ['code' => $ticket->secret_code ]) }}">
            {{ route('ticket.view', ['code' => $ticket->secret_code ]) }}
        </a>
    </div>
  </div>
</div>
@endsection
