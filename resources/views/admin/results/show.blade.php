@include('admin.partials.header')

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        @include('admin.partials.navigation')
        <!-- /.navbar -->
        <!-- Main Sidebar Container -->
        @include('admin.partials.sidebar')
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0" style="color: rgb(31,108,163);"><span class="fa fa-book"></span> Results
                            </h1>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Results</li>
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
                            <input type="hidden" value="{{ $testId }}" id="testId" />
                            <div class="table-responsive">
                                <table class="table" id="example1">
                                    <thead>
                                        <tr>
                                            <th>Sn.</th>
                                            <th>Student</th>
                                            <th>Scores</th>
                                            <th>Percentages(%)</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($results as $result)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td class="font-weight-bold">{{ $result->user->name }}</td>
                                                <td>{{ $result->score }}</td>
                                                <td>{{ $result->score_percentage }}</td>
                                                <td>
                                                    @if ($result->status)
                                                        <span class="text-success font-weight-bold">Passed</span>
                                                    @else
                                                        <span class="text-danger font-weight-bold">Failed</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>


                            <p class="text-center font-weight-bold">Graphical Representation</p>
                            <div style="display:flex; justify-content:space-between" class="mt-5">

                                <div style="width: 50%">
                                    <canvas id="myBarChart"></canvas>
                                </div>
                                <div style="width: 50%">
                                    <canvas id="myPieChart"></canvas>
                                </div>


                            </div>
                        </div>
                    </div>
                    <!-- form start -->

                </div>
                <!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    @include('admin.partials.footer')
    <script>
        $(function() {
                    $("#example1").DataTable();

                    const ctx = document.getElementById('myBarChart');
                    const pie = document.getElementById('myPieChart');

                    const id = $('#testId').val();


                    $.get(`api/results/${id}`).done(function(response, status) {
                            const results = [];
                            const users = [];
                            const percent = [];
                            response.forEach(element => {
                                results.push(element.average_result);
                                users.push(element.user_name);
                                percent.push(element.average_percentage);
                            });

                            new Chart(ctx, {
                                    type: 'bar',
                                    data: {
                                        labels: users,
                                        datasets: [{
                                            label: '#scores',
                                            data: results,
                                            borderWidth: 1,
                                            backgroundColor: 'rgb(79,129,189)',
                                        }]
                                    },
                                    options: {
                                        animations: {
                                            tension: {
                                                duration: 1000,
                                                easing: 'linear',
                                                from: 1,
                                                to: 0,
                                                loop: true
                                            }
                                        },
                                            scales: {
                                                y: {
                                                    beginAtZero: true,
                                                    min: 0,
                                                    max: 100
                                                }
                                            }
                                        }
                                    });


                                new Chart(pie, {
                                    type: 'pie',
                                    data: {
                                        labels: users,
                                        datasets: [{
                                            label: '# percentage scores',
                                            data: percent,
                                            borderWidth: 1,
                                            backgroundColor: [
                                            'rgb(255, 99, 132)',
                                            'rgb(54, 162, 235)',
                                            'rgb(255, 205, 86)',
                                            'rgb(79,129,189)'
                                        ]

                                        }]
                                    },
                                    options: {
                                        scales: {
                                            y: {
                                                beginAtZero: true
                                            }
                                        }
                                    }
                                });
                            });
                    });
    </script>
</body>

</html>
