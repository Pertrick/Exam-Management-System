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
                     <h1 class="m-0" style="color: rgb(31,108,163);"><span class="fa fa-file-word"></span> Upcoming Exams</h1>
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-6">
                     <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Upcoming Exams</li>
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
                     <div class="col-md-12 table-responsive">
                        <table class="table align-items-center mb-0">
                           <thead>
                              <tr>
                                 <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Exam Name</th>
                                 <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Subject</th>
                                 <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Duration</th>
                                 <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Take Exam</th>
                                 <th class="text-secondary opacity-7"></th>
                              </tr>
                           </thead>
                           <tbody>
                              <tr>
                                 <td>EXAM 1</td>
                                 <td>Mathematics</td>
                                 <td>60 mins</td>
                                 <td>
                                    <a class="btn btn-sm bg3" href="#"><i class="fa fa-file-word"></i> Take Exam</a>
                                 </td>
                              </tr>
                              <tr>
                                 <td>EXAM 2</td>
                                 <td>Programming</td>
                                 <td>75 mins</td>
                                 <td>
                                    <a class="btn btn-sm bg3" href="#"><i class="fa fa-file-word"></i> Take Exam</a>
                                 </td>
                              </tr>
                              <tr>
                                 <td>EXAM 3</td>
                                 <td>English</td>
                                 <td>45 mins</td>
                                 <td>
                                    <a class="btn btn-sm bg3" href="#"><i class="fa fa-file-word"></i> Take Exam</a>
                                 </td>
                              </tr>
                              <tr>
                                 <td>EXAM 4</td>
                                 <td>Science</td>
                                 <td>60 mins</td>
                                 <td>
                                    <a class="btn btn-sm bg3" href="#"><i class="fa fa-file-word"></i> Take Exam</a>
                                 </td>
                              </tr>
                              <tr>
                                 <td>EXAM 5</td>
                                 <td>Data Structure</td>
                                 <td>80 mins</td>
                                 <td>
                                    <a class="btn btn-sm bg3" href="#"><i class="fa fa-file-word"></i> Take Exam</a>
                                 </td>
                              </tr>
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
   <div id="delete" class="modal animated rubberBand delete-modal" role="dialog">
      <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
            <div class="modal-body text-center">
               <img src="../asset/img/sent.png" alt="" width="50" height="46">
               <h3>Are you sure want to delete this Result?</h3>
               <div class="m-t-20"> <a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
                  <button type="submit" class="btn bg1">Delete</button>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- jQuery -->
   @include('student.partials.footer')
   <script>
      $(function() {
         $("#example1").DataTable();
      });
   </script>
</body>

</html>