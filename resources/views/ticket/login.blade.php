@extends('layouts.app')

@section('content')

<form class="box" method="post" action="{{ route('ticket.view', [ 'code' => $code ]) }}">
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

  <p>Mohon isikan form di bawah agar melihat tiket ini</p>
  <div class="field">
    <div class="control">
     {!! NoCaptcha::renderJs() !!}
     {!! NoCaptcha::display() !!}
    </div>
  </div>

  <button typw="submit" class="button is-primary">Lanjutkan</button>
</form>

@endsection
