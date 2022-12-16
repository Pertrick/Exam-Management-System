@include('student.partials.header')
   <body class="hold-transition sidebar-mini layout-fixed">
      <div class="wrapper">
            <!--Nav bar -->
      @include('student.partials.navigation')
  <!-- Main Sidebar Container -->
      @include('student.partials.sidebar')
      <!-- Content Wrapper. Contains page content -->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
         <!-- Content Header (Page header) -->
         <div class="content-header">
            <div class="container-fluid">
               <div class="row mb-2">
                  <div class="col-sm-6">
                        <h1 class="m-0" style="color: rgb(31,108,163);"><span class="fa fa-file-word"></span> Exam Result Details</h1>
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-6">
                     <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Exam Result Details</li>
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
                         <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">#</th>
                         <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Questions</th>
                         <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Selected Answer</th>
                         <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Correct Answers</th>
                         <th class="text-secondary opacity-7"></th>
                       </tr>
                     </thead>
                     <tbody>
                       <tr>
                         <td>
                           <div class="d-flex px-2 py-1">
                             <div class="d-flex flex-column justify-content-center">
                               <h6 class="text-xs text-secondary mb-0">1</h6>
                             </div>
                           </div>
                         </td>
                         <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit, <br>sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</td>
                         <td><span class="badge bg-warning">Choice 2</span></td>
                         <td><span class="badge bg-success">Choice 3</span></td>
                       </tr>
                       <tr>
                         <td>
                           <div class="d-flex px-2 py-1">
                             <div class="d-flex flex-column justify-content-center">
                               <h6 class="text-xs text-secondary mb-0">2</h6>
                             </div>
                           </div>
                         </td>
                         <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit, <br>sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</td>
                         
                         <td><span class="badge bg-warning">Choice 3</span></td>
                         <td><span class="badge bg-success">Choice 4</span></td>
                       </tr>
                       <tr>
                         <td>
                           <div class="d-flex px-2 py-1">
                             <div class="d-flex flex-column justify-content-center">
                               <h6 class="text-xs text-secondary mb-0">3</h6>
                             </div>
                           </div>
                         </td>
                         <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit, <br>sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</td>
                         
                         <td><span class="badge bg-warning">Choice 1</span></td>
                         <td><span class="badge bg-success">Choice 4</span></td>
                       </tr>
                       <tr>
                         <td>
                           <div class="d-flex px-2 py-1">
                             <div class="d-flex flex-column justify-content-center">
                               <h6 class="text-xs text-secondary mb-0">4</h6>
                             </div>
                           </div>
                         </td>
                         <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit, <br>sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</td>
                         
                         <td><span class="badge bg-success">Choice 3</span></td>
                         <td><span class="badge bg-success">Choice 3</span></td>
                       </tr>
                       <tr>
                         <td>
                           <div class="d-flex px-2 py-1">
                             <div class="d-flex flex-column justify-content-center">
                               <h6 class="text-xs text-secondary mb-0">5</h6>
                             </div>
                           </div>
                         </td>
                         <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit, <br>sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</td>
                         
                         <td><span class="badge bg-success">Choice 2</span></td>
                         <td><span class="badge bg-success">Choice 2</span></td>
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
               <h3>Are you sure want to delete this Questionaire?</h3>
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
      $(function () {
         $("#example1").DataTable();
      });
   </script>
</body>

</html>