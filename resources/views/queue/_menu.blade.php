<aside class="menu">
  <p class="menu-label">
    Queue Menu
  </p>
  <ul class="menu-list">
    <li><a href="{{ route('admin.counter', [ $queue->slug ]) }}">Admin's Counter</a></li>
    <li><a href="{{ route('admin.setting', [ $queue->slug ]) }}">Settings</a></li>
  </ul>
</aside>
