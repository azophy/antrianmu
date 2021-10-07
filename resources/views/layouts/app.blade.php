<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('page_title', config('app.name'))</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
  </head>
<body>
<nav class="navbar is-primary" role="navigation" aria-label="main navigation">
  <div class="navbar-brand">
    <a class="navbar-item title is-4" href="{{ url('/') }}">
        {{ config('app.name') }}
    </a>

    <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
    </a>
  </div>
  <div id="navbarBasicExample" class="navbar-menu">
    <div class="navbar-start">
      @if (!empty($queue) && $queue->isCurrentUserAdmin())
        <a class="navbar-item" href="{{ route('guest.counter', [ $queue->slug ]) }}">Counter untuk Tamu</a>

        <a class="navbar-item" href="{{ route('admin.counter', [ $queue->slug ]) }}">Counter untuk Penyedia</a>

        <a class="navbar-item" href="{{ route('admin.setting', [ $queue->slug ]) }}">Pengaturan</a>
      @endif

      {{--
      <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link">
          More
        </a>

        <div class="navbar-dropdown">
          <a class="navbar-item">
            About
          </a>
          <a class="navbar-item">
            Jobs
          </a>
          <a class="navbar-item">
            Contact
          </a>
          <hr class="navbar-divider">
          <a class="navbar-item">
            Report an issue
          </a>
        </div>
      </div>
      --}}
    </div><!-- end .navbar-start -->

    {{--
    <div class="navbar-end">
      <div class="navbar-item">
        <div class="buttons">
          <a class="button is-primary">
            <strong>Sign up</strong>
          </a>
          <a class="button is-light">
            Log in
          </a>
        </div>
      </div>
    </div><!-- end .navbar-end -->
    --}}
  </div><!-- end .navbar-menu -->
</nav>

<section class="section">
  <div class="container">
    @yield('content')
  </div>
</section>

<footer class="footer">
  <div class="content has-text-centered">
    <p>
      <strong>{{ config('app.name') }}</strong> by <a target="_blank" href="https://abdurrahman.adianto.id">Abdurrahman Shofy Adianto</a>. All right reserved.
    </p>
  </div>
</footer>

<script>
document.addEventListener('DOMContentLoaded', () => {

  // Get all "navbar-burger" elements
  const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);

  // Check if there are any navbar burgers
  if ($navbarBurgers.length > 0) {

    // Add a click event on each of them
    $navbarBurgers.forEach( el => {
      el.addEventListener('click', () => {

        // Get the target from the "data-target" attribute
        const target = el.dataset.target;
        const $target = document.getElementById(target);

        // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
        el.classList.toggle('is-active');
        $target.classList.toggle('is-active');

      });
    });
  }

  // allow all modal to be able to be deleted
  // ref: https://bulma.io/documentation/elements/notification/#javascript-example
  (document.querySelectorAll('.modal .modal-close') || []).forEach(($close) => {
     const $modal = $close.parentNode;

     $close.addEventListener('click', () => {
       $modal.classList.toggle('is-active');
     });
   });
});

// update timer on ticket view page
function updateTimeLeft() {
    var now = new Date().getTime() / 1000
    console.log('update time left: ' + now)

    var time_prediction = document.getElementById('time_prediction')
    if (time_prediction == null) return

    var time_left =  Math.floor( (time_prediction.value - now) / 60 )
    console.log('time_left : ' + time_left)

    document.getElementById('time_left_prediction').innerText = '(' + time_left + ' menit lagi)'
}
var timer = setInterval(updateTimeLeft, 1000);

</script>
</body>
</html>
