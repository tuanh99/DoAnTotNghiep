<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.head')
    
</head>
<body 
 class="hold-transition login-page"> 
        <!-- <img src="https://treobangron.com.vn/wp-content/uploads/2022/09/background-phong-lam-viec-31.jpg" alt=""> -->
        <div class="login-box">
        <div class="login-logo">
            <a href="#"><b>Admin</b></a>
        </div>
       
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>
                @include('admin.alert')
                <form action="/admin/users/login/store" method="post">
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" name="remember" id="remember">
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>
                        
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                       
                    </div>
                    @csrf
                </form>
            </div>
        </div>
    </div>


    @include('admin.footer')
</body>
</html>



