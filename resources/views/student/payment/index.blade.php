@include('student.partials.header')

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
                            <form action="{{route('student.payment.store')}}" method="post">
                                @csrf
                               <input type="submit" value="make payment" class="btn btn-success float-right mb-2">
                            </form>
                            <div class="col-md-12 table-responsive">
                                <h4 class="text-center">Payment History</h4>
                                <table id="example1" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Sn.</th>
                                            <th>Amount(&#8358;)</th>
                                            <th>Reference Id</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       @foreach($user_payments as $user_payment)
                                        <tr>
                                            <td>{{$sn++}}.</td>
                                            <td>{{$user_payment->amount}}</td>
                                            <td>{{$user_payment->reference_no}}</td>
                                            <td>
                                                @if($user_payment->status =="success")
                                                <span class="badge bg-success">{{$user_payment->status}}</span>
                                                @else
                                                <span class="badge bg-warning">{{$user_payment->status}}</span>
                                                @endif
                                            </td> 
                                            <td>{{$user_payment->created_at->toFormattedDateString()}}</td>                       
                                        </tr>
                            
                                        @endforeach

                                    </tbody>
                                </table>
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
    <script>

      

        $(function() {
            $("#example1").DataTable();
        });
    </script>
</body>

</html>


