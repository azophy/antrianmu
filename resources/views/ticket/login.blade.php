@extends('layouts.app')

@section('content')

<form class="box" method="post" action="#" name="ticket_login_form" onsubmit="return evalSubmit()">
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

  @if ($isSearchTicketEnabled ?? false)
  <div class="field">
    <label class="label">Masukkan kode tiket anda</label>
    <div class="control">
      <input class="input" type="text" name="ticket_secret_code" placeholder="Kode tiket anda">
    </div>
  </div>
  @else
  <p>Mohon isikan form di bawah terlebih dahulu agar dapat melihat tiket ini</p>
  @endif

  <div class="field">
    <div class="control">
     {!! NoCaptcha::renderJs() !!}
     {!! NoCaptcha::display() !!}
    </div>
  </div>

  <button typw="submit" class="button is-primary">Lanjutkan</button>
</form>

<script>
function evalSubmit() {
    var base_url = '{{ route('ticket.view', ['code'=>'/']) }}'
    var ticket_secret_code = document.querySelector('input[name="ticket_secret_code"]')

    if (ticket_secret_code != null) {
        document.ticket_login_form.action = base_url + '/' + ticket_secret_code.value
    }
}
</script>
@endsection
