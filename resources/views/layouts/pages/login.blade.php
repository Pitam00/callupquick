<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- remix icon link -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('admin_asset/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('admin_asset/css/responsive.css')}}">
</head>

<body>
    <div class="log_sec">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 col-sm-12 col-md-6 bg-img">
                    <div class="com_info">
                        <h1 class="typing">WELCOME TO <br> <span>ADMIN DASH</span></h1>
                        <p>We are the best Admin Dashboard Partner for you</p>
                        <ul class="log_list">
                            <li><span><i class="ri-check-double-line"></i></span> Easily Accessible.</li>
                            <li><span><i class="ri-check-double-line"></i></span> Safe & Secure Data.</li>
                            <li><span><i class="ri-check-double-line"></i></span> More Than 2K Downloads</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12 col-md-6 form-section">
                    <div class="log_inner">
                        <div class="logoimg"><img src="images/logo_img.png" alt=""></div>
                        <b class="lg-title">Sign Into Your Account</b>
                        <form action="{{route('logincheck')}}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="exampleFormControlInput1" class="form-label">Email address</label>
                                <input type="email" name="email" class="form-control" placeholder="rajib@example.com" value="admin@gmail.com">
                                <div class="log_icon"><i class="ri-mail-line"></i></div>
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlInput2" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control"placeholder="Enter Your Password" value="admin123">
                                <div class="log_icon"><i class="ri-git-repository-private-line"></i></div>
                            </div>

                            <div class="checkbar mb-4 d-flex justify-content-between align-items-center">
                                <div class="form-check d-flex gap-2">
                                    <input class="form-check-input" name="" type="checkbox" value=""
                                        id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Remember Me
                                    </label>
                                </div>
                                <a href="" class="linktag">Forgot Password</a>
                            </div>

                            <div class="form-group">
                                <button class="btn ripple btn_primary w-100" type="submit">Login Now</button>
                            </div>
                        </form>
                        <div class="or">
                            <span>or</span>
                        </div>
                        <p>Don't have an account? <a href="register.html" class="linktag"
                                style="font-size: 16px;">Register</a> </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"
        integrity="sha512-jGsMH83oKe9asCpkOVkBnUrDDTp8wl+adkB2D+//JtlxO4SrLoJdhbOysIFQJloQFD+C4Fl1rMsQZF76JjV0eQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

</body>

</html>


