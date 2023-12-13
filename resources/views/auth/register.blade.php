<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Techesthete</title>
    <!-- base:css -->
    <link rel="stylesheet" href="{{ asset('template/vendors/typicons.font/font/typicons.css') }}">
    <link rel="stylesheet" href="{{ asset('template/vendors/css/vendor.bundle.base.css') }}">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('template/css/vertical-layout-light/style.css') }}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('template/images/favicon.png') }}" />
    <style>
        .brand-logo {
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="row w-100 mx-0">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                            <div class="brand-logo">
                                <img src="{{ asset('template/images/techesthete-logo.png') }}" alt="logo">
                            </div>
                            <div style="text-align: center">
                                <h4>New here?</h4>
                                <h6 class="font-weight-light">Signing up is easy. It only takes a few steps</h6>
                            </div>
                            <form class="pt-3"method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="form-group">
                                    <input type="text"name="name" :value="old('name')"
                                        class="form-control form-control-lg" id="name" placeholder="Name">
                                </div>
                                <x-input-error :messages="$errors->get('name')" class="mt-2" style="color: red;" />

                                <div class="form-group">
                                    <input type="email" name="email" :value="old('email')"
                                        class="form-control form-control-lg" id="exampleInputEmail1"
                                        placeholder="Email">
                                </div>
                                <x-input-error :messages="$errors->get('email')" class="mt-2" style="color: red;" />

                                <div class="form-group">
                                    <input type="number" name="phone_number" :value="old('phone_number')"
                                        class="form-control form-control-lg" id="phone_number"
                                        placeholder="Phone Number">
                                </div>
                                <x-input-error :messages="$errors->get('phone_number')" class="mt-2" style="color: red;" />

                                <!-- <div class="form-group">
                  <select class="form-control form-control-lg" id="exampleFormControlSelect2">
                    <option>Country</option>
                    <option>United States of America</option>
                    <option>United Kingdom</option>
                    <option>India</option>
                    <option>Germany</option>
                    <option>Argentina</option>
                  </select>
                </div> -->

                                <div class="form-group">
                                    <input type="password" name="password" class="form-control form-control-lg"
                                        id="password" placeholder="Password">
                                </div>
                                <x-input-error :messages="$errors->get('password')" class="mt-2" style="color: red;" />

                                <div class="form-group">
                                    <input type="password" name="password_confirmation"
                                        class="form-control form-control-lg" id="password_confirmation"
                                        placeholder="Confirm Password">
                                </div>
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" style="color: red;" />

                                <div class="mb-4">
                                    <div class="form-check">
                                        <label class="form-check-label text-muted">
                                            <input type="checkbox" class="form-check-input">
                                            I agree to all Terms & Conditions
                                        </label>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button
                                        class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">SIGN
                                        UP</button>
                                </div>
                                <div class="text-center mt-4 font-weight-light">
                                    Already have an account? <a href="{{ route('login') }}"
                                        class="text-primary">Login</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- base:js -->
    <script src="{{ asset('template/vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- inject:js -->
    <script src="{{ asset('template/js/off-canvas.js') }}"></script>
    <script src="{{ asset('template/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('template/js/js/template.js') }}"></script>
    <script src="{{ asset('template/js/settings.js') }}"></script>
    <script src="{{ asset('template/js/todolist.js') }}"></script>
</body>

</html>
