<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>SFVN - Admin Dashboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- App css -->

        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/jquery.toast.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />


    </head>

    <body class="authentication-bg authentication-bg-pattern d-flex align-items-center">
        <div class="account-pages w-100 mt-5 mb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card">
                            <div class="card-body p-4">
                                <div class="text-center mb-4">
                                    <a href="index.html">
                                        <span><img src="https://straitsvietnam.com/wp-content/uploads/2023/11/logo-sfvn-new.jpg" alt="" height="28"></span>
                                    </a>
                                </div>
                                <form id="loginForm" action="{{route('login.submit')}}" method="post"  class="pt-2">
                                    <div class="form-group mb-3">
                                        <label for="email">Email address</label>
                                        <input class="form-control" type="email" name="email" id="email"  placeholder="Enter your email">
                                        <span class="text-danger validate-require validate-text emailError" id="emailError"></span>
                                    </div>
                                    <div class="form-group mb-3">
                                        <a href="auth-recoverpassword.html" class="text-muted float-right"></a>
                                        <label for="password">Password</label>
                                        <input class="form-control" type="password" name="password"  id="password" placeholder="Enter your password">
                                        <span class="text-danger validate-require validate-text passwordError" id="passwordError"></span>
                                    </div>
                                    <div class="custom-control custom-checkbox mb-3">
                                        <input type="checkbox" class="custom-control-input" id="checkbox-signin" checked>
                                        <label class="custom-control-label" for="checkbox-signin">Remember me</label>
                                    </div>
                                    <div class="form-group mb-0 text-center">
                                        <button class="btn btn-success btn-block" type="submit"> Log In </button>
                                    </div>
                                </form>
                                <!-- end row -->

                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->

                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end page -->

        <!-- Vendor js -->
        <script src="assets/js/vendor.min.js"></script>

        <!-- App js -->
        <script src="assets/js/app.min.js"></script>
        <script src="assets/js/jquery.toast.min.js"></script>
        <script>

            $("#loginForm").on('submit', function(e){
               e.preventDefault();
               let submitBtn = $(this).find('[type="submit"]');
               const params = new URLSearchParams(window.location.search);
               let urlRequest = params.get('urlRequest')
               if(!urlRequest) {
                   urlRequest = "/"
               }

               // Show spinner
               submitBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...');
               $.ajax({
                   url:$(this).attr('action'),
                   method:$(this).attr('method'),
                   data:new FormData(this),
                   processData:false,
                   headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')},
                   contentType:false,
                   success:function(response){
                       clearErrors();
                       $("#loginForm")[0].reset();
                       submitBtn.html('Đăng nhập');
                       window.location.href = urlRequest;
                   },
                   error: function(xhr) {
                       if (xhr.status === 422) {
                           const errors = xhr.responseJSON.errors;
                           printErrorMsg(errors)
                       } else {
                           $('#msgError').text(xhr.responseJSON.message);
                           showToast();
                       }
                       submitBtn.html('Đăng nhập');
                   }
               });
           });

           function printErrorMsg (errors) {
               clearErrors();
               $.each( errors, function( key, value ) {
                   $( '#'+key ).addClass( "is-invalid" );
                   $('.'+key+'Error').text(value);
                   $('.'+key+'Error').addClass( "is-invalid" );
                   $('label[for=' + key + ']').addClass('is-invalid');
               });
           }

           // Close the modal when needed
           function clearErrors() {
               document.querySelectorAll('.form-body .validate-require').forEach(input => {
                   input.classList.remove('is-invalid');
               });
               document.querySelectorAll('.form-body .validate-text').forEach(element => {
                   element.innerText = ''
               });
           }



           function showToast() {
            $.toast({
                heading: 'Waring',
                text: 'Password or email invalidate',
                icon: 'info', // success, warning, error, info
                showHideTransition: 'fade', // slide, fade
                allowToastClose: true,
                hideAfter: 5000, // Thời gian tự động ẩn, tính bằng milliseconds (ms)
                stack: 5, // Số lượng thông báo hiển thị cùng một lúc
                position: 'top-right', // top-left, top-center, top-right, bottom-left, bottom-center, bottom-right
                bgColor: '#dc3545', // Màu nền
                textColor: '#ffffff', // Màu chữ
                textAlign: 'left', // left, right, center
            });
           }
       </script>
    </body>
</html>
