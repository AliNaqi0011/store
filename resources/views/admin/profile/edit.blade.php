@extends('layouts.main')
@section('content')
    <div class="row">
        <!-- <div class="col-md-1"></div> -->
        <nav aria-label="breadcrumb" class="main-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('user.profile') }}">User</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center">
                    Edit Profile
                </div>
                <div class="card-body">
                    <form class="pt-3" method="POST" action="{{ route('user.profile.update', ['id' => $user->id]) }}"
                        enctype="multipart/form-data" id="profileForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <label for=""><b>Name</b></label>
                                <div class="form-group">
                                    <input type="text" name="name" value="{{ $user->name }}"
                                        class="form-control form-control-md" id="name" placeholder="Enter your name">
                                </div>
                                <x-input-error :messages="$errors->get('email_otp')" />
                            </div>
                            <div class="col-md-4">
                                <label for=""><b>Email</b></label>
                                <div class="form-group mt-md-0 mt-3">
                                    <input type="text" name="email" value="{{ $user->email }}"
                                        class="form-control form-control-md" id="email" placeholder="Enter Email">
                                </div>
                                <x-input-error :messages="$errors->get('email')" />
                            </div>
                            <div class="col-md-4">
                                <label for=""><b>Phone Number</b></label>
                                <div class="form-group mt-md-0 mt-3">
                                    <input type="text" name="phone_number" value="{{ $user->phone_number }}"
                                        class="form-control form-control-md" id="phone_number"
                                        placeholder="Enter Phone Number">
                                        @if(Auth::user()->phone_verified == 1) <p style="color: green">Verified</p> @endif
                                    @if (Auth::user()->phone_verified == 0)
                                        <button type="button" id="getPhoneNumberBtn" class="btn btn-primary">Get
                                            Code</button>
                                    @endif
                                </div>
                                <x-input-error :messages="$errors->get('phone_number')" />
                            </div>
                            <!-- Your other form fields here -->

                            {{-- <button class="btn btn-primary btn-md font-weight-medium auth-form-btn" type="submit">Submit</button> --}}
                            <!-- <div class="col-md-2">
                                                <div>
                                                    <button class="btn btn-block btn-primary btn-md font-weight-medium auth-form-btn">Verify</button>
                                                </div>
                                            </div> -->
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label for=""><b>Address</b></label>
                                <div class="form-group">
                                    <input type="text" name="address" value="{{ $user->address }}"
                                        class="form-control form-control-md" id="address"
                                        placeholder="Enter your address">
                                </div>
                                <x-input-error :messages="$errors->get('address')" />
                            </div>
                            <div class="col-md-4">
                                <label for=""><b>Profile Title Name</b></label>
                                <div class="form-group mt-md-0 mt-3">
                                    <input type="text" name="profile_title_name" value="{{ $user->profile_title_name }}"
                                        class="form-control form-control-md" id="profile_title_name"
                                        placeholder="Enter Profile Title Name">
                                </div>
                                <x-input-error :messages="$errors->get('profile_title_name')" />
                            </div>
                            <div class="col-md-4">
                                <label for=""><b>Password</b></label>
                                <div class="form-group mt-md-0 mt-3">
                                    <input type="password" name="password" class="form-control form-control-md"
                                        id="password" placeholder="Enter Password">
                                </div>
                                <x-input-error :messages="$errors->get('password')" />
                            </div>
                            <div class="col-md-4">
                                <label for=""><b>Profile Image</b></label>
                                <div class="form-group mt-md-0 mt-3">
                                    <input type="file" name="profile_image" value="{{ $user->profile_image }}"
                                        class="form-control form-control-md" id="image" placeholder="Enter Phone OTP">
                                </div>
                                @if ($user->profile_image)
                                    <img src="{{ asset('template/images/profile-images/' . $user->profile_image) }}"
                                        alt="Current Image" style="width: 80px; height:80px;">
                                @endif
                                <x-input-error :messages="$errors->get('profile_image')" />
                            </div>
                        </div>
                        <!-- <div class="col-md-2 mt-3">
                                            <button class="btn btn-block btn-primary btn-md font-weight-medium auth-form-btn">Verify</button>
                                        </div> -->
                        <button class="btn btn-primary btn-md font-weight-medium auth-form-btn">Submit</button>
                    </form>

                </div>
                <!-- <div class="card-footer text-muted">
                                    2 days ago
                                </div> -->
            </div>
        </div>
        <!-- <div class="col-md-1"></div> -->
    </div>




    <div class="modal" id="myModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Your Modal Title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('check.phone.otp') }}" id="myForm">
                        <div class="form-group">
                            <label for="inputValue">Phone OTP</label>
                            <input type="text" class="form-control" id="inputValue" name="inputValue">
                        </div>
                        <input type="hidden" id="phoneNumberHidden" name="phoneNumberHidden">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submitFormBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>





    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        // Add a click event listener to the "Get Code" button
        $('#getPhoneNumberBtn').on('click', function(e) {
            // Prevent the default form submission
            e.preventDefault();

            // Get the value of the phone number input
            var phoneNumber = $('#phone_number').val();
            console.log('Phone Number:', phoneNumber);

            // Check if CSRF token is present
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            if (!csrfToken) {
                console.error('CSRF token is missing. Make sure the meta tag is present in the HTML head.');
                return;
            }
            console.log('CSRF Token:', csrfToken);

            // Perform your AJAX request here
            $.ajax({
                type: 'POST',
                url: "{{ route('phone.verifications') }}",
                data: {
                    phone_number: phoneNumber,
                    _token: csrfToken,
                },
                success: function(response) {
                    // console.log(response.PhoneNumber);

                    if (response.status == true) {
                        $('#myModal').modal('show');
                        // $('#phoneNumberHidden').val(response.PhoneNumber);
                        var PhoneNumber = response.PhoneNumber
                        console.log(PhoneNumber);
                        // return;
                        // Optionally, pre-fill the input with some data from the response
                        $('#inputValue').val(response.data);

                        // Handle form submission
                        $('#submitFormBtn').on('click', function() {
                            var phone_otp = $('#inputValue').val();
                            console.log('Input Value:', inputValue);
                            $.ajax({
                                type: 'POST',
                                url: "{{ route('check.phone.otp') }}",
                                data: {
                                    PhoneNumber: PhoneNumber,
                                    phone_otp: phone_otp,
                                    _token: csrfToken,
                                },
                                success: function(response) {
                                    if (response.status == true) {
                                        window.location.reload();
                                        $('#myModal').modal('hide');
                                        toastr.success('Your phone number is verified.');
                                    } else {
                                        $('#myModal').modal('show');
                                        toastr.error('Otp is in correct.');
                                    }
                                    // Handle success
                                },
                                error: function(xhr) {
                                    console.error('AJAX Error:', xhr);
                                    // Handle error
                                },
                            });
                            // $('#myModal').modal('hide');
                        });
                    }
                    // Handle success
                },
                error: function(xhr) {
                    console.error('AJAX Error:', xhr);
                    // Handle error
                },
            });
        });

        // Add a submit event listener to the form
        $('#profileForm').on('submit', function(e) {
            // You can add additional validation or processing logic here if needed
            // If everything is valid, the form will submit as usual
        });
    </script>
@endsection
