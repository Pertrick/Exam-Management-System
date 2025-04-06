@include('student.partials.header')
<style>
    body {
      background: linear-gradient(135deg, #e3ffe7 0%, #d9e7ff 100%);
      font-family: 'Poppins', sans-serif;
    }
    .success-icon {
      font-size: 80px;
      color: #28a745;
    }
    .card {
      border-radius: 15px;
    }
    .cta-buttons a {
      text-decoration: none;
    }
  </style>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        @include('student.partials.navigation')
        <!-- /.navbar -->
        <!-- Main Sidebar Container -->
        @include('student.partials.sidebar')
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0" style="color: rgb(31,108,163);"><span class="fa fa-credit-card"></span>
                                Payment</h1>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Payment</li>
                            </ol>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="card card-info">
                        <div class="card-body">
                            <div class="container d-flex justify-content-center align-items-center min-vh-100">
                                <div class="card text-center shadow p-4" style="max-width: 500px;">
                                    <div class="card-body">
                                        <div class="success-icon mb-3">✔️</div>
                                        <h2 class="text-success">Payment Successful!</h2>
                                        <p class="text-muted mb-4">Thank you for your payment. Your transaction was
                                            completed successfully.</p>
                                        <ul class="list-group list-group-flush text-start mb-4">
                                            <li class="list-group-item"><strong>Transaction ID:</strong>
                                                {{ $details['transaction_id'] }}</li>
                                            <li class="list-group-item"><strong>Amount Paid:</strong>
                                                {{ $details['amount'] }}</li>
                                            <li class="list-group-item"><strong>Date:</strong> {{ $details['date'] }}
                                            </li>
                                            <li class="list-group-item"><strong>Payment Method:</strong>
                                                {{ $details['payment_method'] }}</li>
                                        </ul>
                                        <div class="cta-buttons">
                                            <a href="#" class="btn btn-success btn-lg mx-2">Download Receipt</a>
                                            <a href="{{ route('student.subject.index') }}"
                                                class="btn btn-outline-success btn-lg mx-2">Go to Course</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

        </div>
        <!-- /.card-body -->
    </div>
    </div>
    <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    </div>
    <!-- ./wrapper -->


    <!-- jQuery -->
    @include('student.partials.footer')
    <script></script>
