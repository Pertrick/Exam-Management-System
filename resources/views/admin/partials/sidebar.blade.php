<aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: rgba(39,93,43);">
    <!-- Brand Logo -->
<a href="index.html" class="brand-link animated swing">
<img src="EMS/asset/img/logo.png" alt="DSMS Logo" width="200" style="margin-bottom: -50px;">
</a>
<!-- Sidebar -->
<div class="sidebar">
<!-- Sidebar Menu -->
<nav class="mt-2">
<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
 <li class="nav-item">
    <a href="{{route('admin.dashboard')}}" class="nav-link {{ request()->is('admin/dashboard') ? 'active' : ''}}">
       <i class="nav-icon fa fa-tachometer-alt "></i>
       <p>
          Dashboard
       </p>
    </a>
 </li>
 <li class="nav-item">
    <a href="{{route('admin.subject.index')}}" class="nav-link {{ request()->is('admin/subject') ? 'active' : ''}}">
       <i class="nav-icon fa fa-book"></i>
       <p>
          Subject
       </p>
    </a>
 </li>
 <li class="nav-item">
   <a href="{{route('admin.question.index')}}" class="nav-link {{ request()->is('admin/question') ? 'active' : ''}}">
      <i class="nav-icon fa fa-certificate "></i>
      <p>
         Question
      </p>
   </a>
</li>
<li class="nav-item">
   <a href="{{route('admin.student.index')}}" class="nav-link {{ request()->is('admin/student') ? 'active' : ''}}">
      <i class="nav-icon fa fa-user-graduate "></i>
      <p>
         Student
      </p>
   </a>
</li>
 <li class="nav-item">
    <a href="{{route('admin.test.index')}}" class="nav-link {{ request()->is('admin/exam') ? 'active' : ''}}">
       <i class="nav-icon fa fa-chalkboard-teacher "></i>
       <p>
          Exam
       </p>
    </a>
 </li>

 {{-- <li class="nav-item">
    <a href="assign-teacher.html" class="nav-link">
       <i class="nav-icon fa fa-file"></i>
       <p>
          Assign Teacher
       </p>
    </a>
 </li> --}}
</ul>
</nav>
<!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
</aside>