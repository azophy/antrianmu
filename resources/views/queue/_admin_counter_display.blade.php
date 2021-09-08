<div
    class="notification is-primary has-text-centered is-clickable"
    style="max-width: 300px;"
    onclick="nextTicket()"
    disabled
>
    <p>Nomor antrian saat ini:</p>
    <h1 class="title is-1">{{ $queue->ticket_current }}</h1>
    <p>(klik tombol ini untuk ke nomor antrian berikutnya)</p>
</div>

<div
    class="notification is-info has-text-centered is-clickable"
    style="max-width: 300px;"
    onclick="addTicket()"
>
    <p>Nomor antrian terakhir:</p>
    <h1 class="title is-1">{{ $queue->ticket_last }}</h1>
    <p>(klik tombol ini untuk mengambil nomor antrian baru)</p>
</div>

