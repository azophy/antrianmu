@extends('layouts._base')

@section('main')

<section class="hero is-primary">
  <div class="hero-body">
    <p class="title">
      Selamat datang di {{ config('app.name') }}
    </p>
    <p class="subtitle">
      Lindungi pengunjung usaha anda dari ancaman covid-19 . Gunakan sistem antrian berbasis online yang tanpa kontak, dan membantu mereka untuk tidak berkerumun. Coba gratis sekarang! Tidak perlu registrasi! Tidak perlu install aplikasi atau beli alat!
    </p>
    <form class="box" method="post" action="{{ route('queue.create') }}">
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

      <div class="field">
        <label class="label">{{config('app.url')}}/</label>
        <div class="control">
          <input class="input" type="text" name="slug" placeholder="nama-antrian-baru-kamu">
        </div>
      </div>

      <div class="field">
        <div class="control">
         {!! NoCaptcha::renderJs() !!}
         {!! NoCaptcha::display() !!}
        </div>
      </div>

      <button typw="submit" class="button is-primary">Buat sekarang</button>
    </form>
  </div>
</section>

<section class="section">
  <h1 class="title">Cara Menggunakan</h1>
  <p class="content">
    Gunakan <strong>{{ config('app.name') }}</strong> hari ini dengan 4 langkah mudah! Tidak perlu daftar, tidak perlu install aplikasi!
    <ol>
        <li>Buat antrian baru menggunakan form isian di atas, akan dibuatkan 2 jenis tautan: tautan untuk pengelola & tautan untuk pengunjung</li>
        <li>Bagikan tautan untuk pengunjung yang sudah didapatkan</li>
        <li>Pengunjung mengambil nomor antrian di tautan yang sudah dibagikan</li>
        <li>Pengelola bisa mengoperasikan antrian dari tautan khusus penyedia</li>
    </ol>
  </p>
</section>

<section class="section">
  <h1 class="title">Fitur</h1>

  <div class="box">
    <h2 class="title">Mudah digunakan</h2>
    <p class="content">
      <ul>
          <li>Tidak perlu registrasi untuk mencoba</li>
          <li>Tidak perlu install aplikasi</li>
          <li>Tidak perlu beli alat/hardware</li>
      </ul>
    </p>
  </div>

  <div class="box">
    <h2 class="title">Sesuai protokol kesehatan</h2>
    <p class="content">
      <ul>
          <li>Prediksi waktu tunggu untuk user, sehingga pengunjung tidak perlu berkerumun di lokasi</li>
          <li>Ambil nomor antrian mandiri bagi pengunjung, pengunjung cukup ke lokasi ketika nomor antriannya sudah akan dipanggil</li>
          <li>Tidak perlu alat/hardware, meminimalkan kontak fisik</li>
      </ul>
    </p>
  </div>

  <div class="box">
    <h2 class="title">Fitur spesial untuk perusahan (segera hadir)</h2>
    <p class="content">
      <ul>
          <li>Menyediakan lebih dari 1 counter pelayanan</li>
          <li>Membuat lebih dari 1 jenis antrian</li>
          <li>Edit tampilan dan branding sesuai kebutuhan</li>
      </ul>
    </p>
  </div>

</section>

<section class="section">
  <h1 class="title">Paket Harga</h1>

  <div class="card">
    <header class="card-header">
      <p class="card-header-title">
        Percobaan
      </p>
    </header>
    <div class="card-content">
      <div class="content">
        <strong>Gratis</strong>
        <ul>
            <li>Tidak perlu registrasi</li>
            <li>Antrian berlaku hanya selama 1 hari</li>
            <li>Jumlah nomor antrian maksimum 25</li>
        </ul>
      </div>
    </div>
  </div>

  <div class="card">
    <header class="card-header">
      <p class="card-header-title">
        Dasar (Segera Hadir)
      </p>
    </header>
    <div class="card-content">
      <div class="content">
        <strong>Gratis, hanya butuh registrasi</strong>
        <ul>
            <li>Antrian berlaku selama 3 hari</li>
            <li>Jumlah nomor antrian maksimum 50</li>
        </ul>
      </div>
    </div>
  </div>

</section>

{{--
<section class="section">
  <h1 class="title">Testimoni</h1>
  <h2 class="subtitle">
    A simple container to divide your page into <strong>sections</strong>, like the one you're currently reading.
  </h2>
</section>

<section>
    <div class="content">
        <p>{{ config('app.name') }} adalah aplikasi antrian online yang simpel dan mudah digunakan. Bisa digunakan untuk antrian perbankan, rumah sakit, instansi pemerintah, dll.</p>
        <p>Aplikasi ini ditujukan untuk 2 jenis pengguna: untuk "penyedia" yang menyediakan layanan dan mengadakan antrian, serta "pengunjung" yang akan mengambil nomor antrian.</p>
        <p>Untuk "penyedia", pertama buat antrian baru dengan mengisikan nama antrian di isian di bawah. Setelah itu anda akan mendapatkan 2 buah tautan, 1 untuk "penyedia" serta 1 untuk "pengunjung". Selain itu anda akan mendapatkan kode keamanan sementara, yang berguna untuk membuka kunci di tautan "penyedia". Ketika anda membuka tautan untuk "penyedia" dan mengisikan kode keamanan yang diberikan, anda akan masuk ke menu "pengaturan". Di sana anda bisa mengisikan informasi seperti "Nama lembaga penyedia" serta "Nama antrian".</p>
        <p>Adapun tautan "pengunjung" bisa anda berikan ke setiap pelanggan anda yang datang. Anda bisa mem-print tautan tersebut atau menampilkan QR Code yang bisa di scan oleh pengunjung. Di tautan tersebut pengunjung bisa melihat informasi jumlah & status antrian saat ini, serta bisa mengambil nomor antrian. Ketika pengunjung mengambil nomor antrian, pengunjung akan mendapatkan "tiket" berupa sebuah link tiket yang bisa disimpan oleh pengunjung. Tiket tersebut juga dapat dicetak jika dikehendaki, sebagai bukti fisik nomor antrian yang dimiliki pengunjung.</p>
    </div>
</section>
--}}

</div>
@endsection
