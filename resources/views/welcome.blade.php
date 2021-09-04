@extends('layouts.app')

@section('content')

<div style="max-width: 800px; margin:auto; padding: 5px">
    <h1 class="title">Selamat datang di {{ config('app.name') }}</h1>
    <p class="content is-size-6">Lindungi pengunjung usaha anda dari ancaman covid-19 . Gunakan sistem antrian berbasis online yang tanpa kontak, dan membantu mereka untuk tidak berkerumun. Coba gratis sekarang! Tidak perlu registrasi! Tidak perlu install aplikasi atau beli alat!</p>

    <h3>Buat antrian baru</h3>
    <form class="box" method="post" action="{{ route('queue.create') }}">
      @csrf

      <div class="field">
        <label class="label">{{config('app.url')}}/</label>
        <div class="control">
          <input class="input" type="text" name="slug" placeholder="nama-antrian-baru-kamu">
        </div>
      </div>

      <button typw="submit" class="button is-primary">Buat sekarang</button>
    </form>

    <div class="content">
        <p>{{ config('app.name') }} adalah aplikasi antrian online yang simpel dan mudah digunakan. Bisa digunakan untuk antrian perbankan, rumah sakit, instansi pemerintah, dll.</p>
        <p>Aplikasi ini ditujukan untuk 2 jenis pengguna: untuk "penyedia" yang menyediakan layanan dan mengadakan antrian, serta "pengunjung" yang akan mengambil nomor antrian.</p>
        <p>Untuk "penyedia", pertama buat antrian baru dengan mengisikan nama antrian di isian di bawah. Setelah itu anda akan mendapatkan 2 buah tautan, 1 untuk "penyedia" serta 1 untuk "pengunjung". Selain itu anda akan mendapatkan kode keamanan sementara, yang berguna untuk membuka kunci di tautan "penyedia". Ketika anda membuka tautan untuk "penyedia" dan mengisikan kode keamanan yang diberikan, anda akan masuk ke menu "pengaturan". Di sana anda bisa mengisikan informasi seperti "Nama lembaga penyedia" serta "Nama antrian".</p>
        <p>Adapun tautan "pengunjung" bisa anda berikan ke setiap pelanggan anda yang datang. Anda bisa mem-print tautan tersebut atau menampilkan QR Code yang bisa di scan oleh pengunjung. Di tautan tersebut pengunjung bisa melihat informasi jumlah & status antrian saat ini, serta bisa mengambil nomor antrian. Ketika pengunjung mengambil nomor antrian, pengunjung akan mendapatkan "tiket" berupa sebuah link tiket yang bisa disimpan oleh pengunjung. Tiket tersebut juga dapat dicetak jika dikehendaki, sebagai bukti fisik nomor antrian yang dimiliki pengunjung.</p>
    </div>
</div>
@endsection
