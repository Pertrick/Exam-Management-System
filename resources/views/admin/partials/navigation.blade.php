<nav class="main-header navbar navbar-expand navbar-white navbar-light" style="background-color: rgba(24,57,46);">
    <!-- Left navbar links -->
<ul class="navbar-nav">
<li class="nav-item">
<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars" style="color: rgb(211, 209, 207);"></i></a>
</li>
</ul>
<!-- Right navbar links -->
<ul class="navbar-nav ml-auto">
  <li class="nav-item">
    <p class="nav-link" style="color: rgb(211, 209, 207);">
     <img src="EMS/asset/img/avatar.png" width="40"
         style="border-radius:5px" alt="{{auth()->user()->name}}">
     {{ auth()->user()->name }}</p>
</li>
<li class="nav-item">
   <a class="nav-link mt-2" data-widget="fullscreen" role="button">
   <i class="fas fa-expand-arrows-alt" title="Fullscreen"  style="color: rgb(211, 209, 207);"></i>
   </a>
</li>
<li class="nav-item">
    <form action="{{route('logout')}}" method="post">
      @csrf
      <button class="nav-link mt-1" title="Logout" type="submit" style="background-color: transparent; border:none"><i class="fas fa-power-off" style="color: rgb(211, 209, 207);"></i></button>
    </form>
</li>
</ul>
</nav>