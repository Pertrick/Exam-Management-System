<aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: rgba(22,34,57,0.99);">
    <!-- Brand Logo -->
    <a href="/" class="brand-link animated swing">
        <img src="EMS/asset/img/logo.png" alt="DSMS Logo" width="200" style="margin-bottom: -50px;">
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item" title="Dashboard">
                    <a href="{{route('student.dashboard')}}" class="nav-link {{ request()->is('student/dashboard') ? 'active' : ''}}">
                        <i class="nav-icon fa fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item" title="Dashboard">
                    <a href="{{route('student.subject.index')}}" class="nav-link {{ request()->is('student/subject') ? 'active' : ''}}">
                        <i class="nav-icon fa fa-tachometer-alt"></i>
                        <p>
                            Subjects
                        </p>
                    </a>
                </li>
                <li class="nav-item" title="Upcoming Exam">
                    <a href="{{route('student.test.index')}}" class="nav-link {{ request()->is('student/exam') ? 'active' : ''}}">
                        <i class="nav-icon fa fa-file-signature"></i>
                        <p>
                            Upcoming Exam
                        </p>
                    </a>
                </li>
                <li class="nav-item" title="Result">
                    <a href="{{route('student.result.index')}}" class="nav-link {{ request()->is('student/result') ? 'active' : ''}}">
                        <i class="nav-icon fa fa-star"></i>
                        <p>
                            Result
                        </p>
                    </a>
                </li>
                <li class="nav-item" title="Payment">
                    <a href="{{route('student.payment.index')}}" class="nav-link {{ request()->is('student/payment') ? 'active' : ''}}">
                        <i class="nav-icon fa fa-credit-card"></i>
                        <p>
                            payment
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
