@if ($queue->type == $queue::TYPE_FREE)
<div class="notification is-info">
    <p>
        Antrian ini saat ini menggunakan paket "percobaan", yang artinya antrian ini hanya berlaku di tanggal ini ({{ $queue->created_at->format('d-m-Y') }}), dan dibatasi hanya sampai <strong>{{$queue->ticket_limit}} nomor</strong> saja. Silahkah upgrade paket antrian anda untuk mendapatkan lebih banyak fasilitas.
    </p>
</div>
@endif

