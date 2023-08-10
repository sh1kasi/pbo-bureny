<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Responsive Admin Dashboard Template">
    <meta name="keywords" content="admin,dashboard">
    <meta name="author" content="stacks">
    <!-- The above 6 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title -->
    <title>Circl - Responsive Admin Dashboard Template</title>

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,700,800&display=swap" rel="stylesheet">
    <script src="{{ asset('template') }}/plugins/jquery/jquery-3.4.1.min.js"></script>
    <link href="{{ asset('template') }}/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('template') }}/plugins/font-awesome/css/all.min.css" rel="stylesheet">
    {{-- <script src="{{ asset('template') }}/plugins/toastr/toastr.css"></script> --}}
    <link rel="stylesheet" href="{{ asset('template') }}/plugins/toastr/toastr.css"/>

    <link href="{{ asset('template') }}/plugins/perfectscroll/perfect-scrollbar.css" rel="stylesheet">


    <!-- Theme Styles -->
    <link href="{{ asset('template') }}/css/main.min.css" rel="stylesheet">
    <link href="{{ asset('template') }}/css/custom.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
</head>


<body class="login-page">
    <div class='loader'>
        <div class='spinner-grow text-primary' role='status'>
            <span class='sr-only'>Loading...</span>
        </div>
    </div>
   
    <div class="container">
       
        <div class="row justify-content-md-center">
            <div class="col-md-12 col-lg-4">
                <div class="card login-box-container">
                    <div class="card-body">
                        <div class="authent-logo">
                            <img src="{{ asset('template') }}/images/logo@2x.png" alt="">
                        </div>
                        <div class="authent-text">
                            <p>Selamat Datang</p>
                            <p>Masukkan Akun Anda</p>
                        </div>

                        <form method="POST" action="{{ route('login_store') }}">
                            @csrf
                            <div class="mb-3">
                                <div class="text-danger mt-2">
                                    @error('name')
                                        {{ $message }}
                                    @enderror
                                </div>
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="floatingInput" placeholder="Username"
                                        name="name">
                                    <label for="floatingInput">Username</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="text-danger mt-3">
                                    @error('password')
                                        {{ $message }}
                                    @enderror
                                </div>
                                <div class="form-floating">
                                    <input type="password" class="form-control" id="floatingPassword"
                                        placeholder="Password" name="password">
                                    <label for="floatingPassword">Password</label>
                                </div>
                            </div>
                            {{-- <div class="mb-3 form-check">
                                  <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                  <label class="form-check-label" for="exampleCheck1">Check me out</label>
                                </div> --}}
                            <div class="d-grid">
                                <button type="submit" class="btn btn-info m-b-xs">Masuk</button>
                                {{-- <button class="btn btn-primary">Facebook</button> --}}
                            </div>
                        </form>
                        <div class="authent-reg">
                            <p>Belum memiliki akun? <a href="register.html">Buat akun disini</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    


    <!-- Javascripts -->
    <script src="{{ asset('template') }}/plugins/jquery/jquery-3.4.1.min.js"></script>
    <script src="{{ asset('template') }}/plugins/toastr/toastr.min.js"></script>
    <script src="{{ asset('template') }}/plugins/popper/popper.min.js"></script>
    <script src="{{ asset('template') }}/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="{{ asset('template') }}/plugins/unpkg/feather-icons.min.js"></script>
    <script src="{{ asset('template') }}/plugins/perfectscroll/perfect-scrollbar.min.js"></script>
    <script src="{{ asset('template') }}/js/main.min.js"></script>


    @if (Session::has('failed'))
        <script>
            toastr.error("{!! session('failed') !!}", "Gagal");
        </script>
    @endif

    
</body>

</html>
