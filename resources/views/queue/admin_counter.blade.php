@extends('layouts.app')

@section('content')

@include('common.package_type_notification', compact('queue'))

<h1 class="title">{{ $queue->title }}</h1>

@php
$counter_url = route('guest.counter', ['slug' => $queue->slug ]);
$admin_url = route('admin.setting', ['slug' => $queue->slug ]);
@endphp

<div></div>
<div id="counter-display">
@include('queue._admin_counter_display', compact('queue'))
</div>

<ul>
  <li>Batas berlaku antrian ini: <strong>{{ $queue->valid_until }}</strong></li>
  <li>Batas nomor antrian hari ini: <strong>{{ $queue->ticket_limit }}</strong></li>
  <li>Tautan untuk antrian ini (untuk pengunjung): <strong>
        <a target="_blank" href="{{ $counter_url }}">{{ $counter_url }}</a>
  </strong></li>
</ul>

<div class="modal" id="ticket-modal">
  <div class="modal-background"></div>
  <div class="modal-content" id="ticket-modal-content">
  </div>
  <button class="modal-close is-large" aria-label="close"></button>
</div>

<script>
var csrfToken = document.querySelector('meta[name="csrf-token"]').content
var defaultHeader = {
    'X-CSRF-TOKEN': csrfToken,
    'X-Requested-With': 'XMLHttpRequest',
}
var processingContent = '<progress class="progress is-small is-primary" max="100">15%</progress><p>processing....</p>'

function updateAdminCounter() {
    var url = '{{ route('admin.counter', [ 'slug' => $queue->slug ]) }}'
    fetch(url, {
        method: 'GET',
        headers: defaultHeader,
    })
        .then(r => r.text())
        .then((content) => {
            document.getElementById('counter-display').innerHTML = content
        })
}

function nextTicket() {
    var url = '{{ route('admin.next', [ 'slug' => $queue->slug ]) }}'
    document.getElementById('counter-display').innerHTML = processingContent
    fetch(url, {
        method: 'POST',
        headers: defaultHeader,
    })
    .then(() => updateAdminCounter())
}
function addTicket() {
    var url = '{{ route('guest.add', [ 'slug' => $queue->slug ]) }}'
    document.getElementById('counter-display').innerHTML = processingContent
    fetch(url, {
        method: 'POST',
        headers: defaultHeader,
    })
    .then(r => r.text())
    .then((content) => {
        document.getElementById('ticket-modal-content').innerHTML = content
        document.getElementById('ticket-modal').classList.toggle('is-active');
    })
    .then(() => updateAdminCounter())
}
</script>

@endsection
