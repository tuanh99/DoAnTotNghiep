<!DOCTYPE html>
<html lang="en">
<meta name="csrf-token" content="{{ csrf_token() }}">

<head>
    @include('admin.head')
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">

            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>

            <li class="nav-item">
                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <a class="nav-link" href="{{ route('admin.logout') }}"
                   onclick="event.preventDefault();
                   document.getElementById('logout-form').submit();">
                   <i class="fas fa-sign-out-alt"></i> Đăng xuất
                </a>
            </li>
        </ul>
    </nav>



    <!-- /.navbar -->


    @include('admin.sidebar')


    <div class="content-wrapper">

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                @include('admin.alert')

                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- jquery validation -->
                        <!-- <div class="card card-primary mt-3">
                            <div class="card-header">
                                <h3 class="card-title">{{ $title }}</h3>
                            </div>

                       

                        </div> -->
                        <!-- /.card -->
                        @yield('content')
                    </div>
                    
                    <!--/.col (left) -->
                    <!-- right column -->
                    <div class="col-md-6">
                   
                    </div>
                    <!--/.col (right) -->
                </div>
                <!-- /.row -->
                
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>


    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
            <b></b>
        </div>
        
    </footer>
</div>
<!-- ./wrapper -->
@include('admin.footer')
</body>
</html>
