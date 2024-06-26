@include('student.partials.header')
   <body class="hold-transition sidebar-mini layout-fixed">
      <div class="wrapper">
         <!--Nav bar -->
      @include('student.partials.navigation')
  <!-- Main Sidebar Container -->
      @include('student.partials.sidebar')
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
         <!-- Content Header (Page header) -->
         <div class="content-header">
            <div class="container-fluid">
               <div class="row mb-2">
                  <div class="col-sm-6">
                        <h1 class="m-0" style="color: rgb(31,108,163);"><span class="fa fa-file-word"></span> Subject Resources</h1>
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-6">
                     <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('student.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Resources</li>
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
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Subject</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Name</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Link</th>
                        {{-- <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">View Score</th>
                         <th class="text-secondary opacity-7"></th> --}}
                       </tr>
                     </thead>
                     <tbody>
                        @foreach($resources as $resource)
                       <tr>
                        <td>{{$resource->subject->name}}</td>
                        <td>{{$resource->name}}</td>
                         <td><a href="{{$resource->link}}" target="blank">{{$resource->link}}</a></td>
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
      $(function () {
         $("#example1").DataTable();
      });
   </script>
</body>

</html>