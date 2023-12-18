<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Toaster Link -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <title>Techesthete</title>
</head>

<body>
    <div class="row mt-5">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    Verification Phone OTP
                </div>
                <div class="card-body">
                    <form class="pt-3" method="POST" action="{{ route('verify.phone.otp.two.fa') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <label for=""><b>Phone OTP</b></label>
                                <div class="form-group">
                                    <input type="number" name="phone_otp" :value="old('phone_otp')" class="form-control form-control-md" id="phone_otp" placeholder="Enter Phone OTP">
                                </div>
                                <x-input-error :messages="$errors->get('phone_otp')" />
                            </div>
                            {{-- <div class="col-md-6">
                                <label for=""><b>Phone OTP</b></label>
                                <div class="form-group mt-md-0 mt-3">
                                    <input type="number" name="phone_otp" class="form-control form-control-md" id="phone_otp" placeholder="Enter Phone OTP">
                                </div>
                                <x-input-error :messages="$errors->get('phone_otp')" />
                            </div> --}}
                        </div>
                        <div class="mt-3">
                            <button class="btn btn-block btn-primary btn-md font-weight-medium auth-form-btn">Verify</button>
                        </div>
                    </form>

                </div>
                <!-- <div class="card-footer text-muted">
                    2 days ago
                </div> -->
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script src="{{asset('template/vendors/js/vendor.bundle.base.js')}}"></script>
    <script src="{{asset('template/js/off-canvas.js')}}"></script>
    <script src="{{asset('template/js/hoverable-collapse.js')}}"></script>
    <script src="{{asset('template/js/template.js')}}"></script>
    <script src="{{asset('template/js/settings.js')}}"></script>
    <script src="{{asset('template/js/todolist.js')}}"></script>
    <script src="{{asset('template/vendors/progressbar.js/progressbar.min.js')}}"></script>
    <script src="{{asset('template/vendors/chart.js/Chart.min.js')}}"></script>
    <script src="{{asset('template/js/dashboard.js')}}"></script>
    <!-- Toaster script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    @if(Session::has('success'))
    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true
        }
        toastr.success("{{session('success')}}")
    </script>
    @endif
    @if(Session::has('error'))
    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true
        }
        toastr.error("{{session('error')}}")
    </script>
    @endif
</body>

</html>
