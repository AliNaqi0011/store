@extends('layouts.main')
@section('content')

<div class="row">
        <!-- <div class="col-md-1"></div> -->
        <nav aria-label="breadcrumb" class="main-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('user.profile')}}">User</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center">
                    Edit Profile
                </div>
                <div class="card-body">
                    <form class="pt-3" method="POST" action="{{ route('user.profile.update', ['id' => $user->id]) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <label for=""><b>Name</b></label>
                                <div class="form-group">
                                    <input type="text" name="name" value="{{$user->name}}" class="form-control form-control-md" id="name" placeholder="Enter your name">
                                </div>
                                <x-input-error :messages="$errors->get('email_otp')" />
                            </div>
                            <div class="col-md-4">
                                <label for=""><b>Email</b></label>
                                <div class="form-group mt-md-0 mt-3">
                                    <input type="text" name="email" value="{{$user->email}}" class="form-control form-control-md" id="email" placeholder="Enter Email">
                                </div>
                                <x-input-error :messages="$errors->get('email')" />
                            </div>
                            <div class="col-md-4">
                                <label for=""><b>Phone Number</b></label>
                                <div class="form-group mt-md-0 mt-3">
                                    <input type="text" name="phone_number" value="{{$user->phone_number}}" class="form-control form-control-md" id="phone_number" placeholder="Enter Phone Number">
                                </div>
                                <x-input-error :messages="$errors->get('phone_number')" />
                            </div>
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
                                    <input type="text" name="address" value="{{$user->address}}" class="form-control form-control-md" id="address" placeholder="Enter your address">
                                </div>
                                <x-input-error :messages="$errors->get('address')" />
                            </div>
                            <div class="col-md-4">
                                <label for=""><b>Profile Title Name</b></label>
                                <div class="form-group mt-md-0 mt-3">
                                    <input type="text" name="profile_title_name" value="{{$user->profile_title_name}}" class="form-control form-control-md" id="profile_title_name" placeholder="Enter Profile Title Name">
                                </div>
                                <x-input-error :messages="$errors->get('profile_title_name')" />
                            </div>
                            <div class="col-md-4">
                                <label for=""><b>Password</b></label>
                                <div class="form-group mt-md-0 mt-3">
                                    <input type="password" name="password" class="form-control form-control-md" id="password" placeholder="Enter Password">
                                </div>
                                <x-input-error :messages="$errors->get('password')" />
                            </div>
                            <div class="col-md-4">
                                <label for=""><b>Profile Image</b></label>
                                <div class="form-group mt-md-0 mt-3">
                                    <input type="file" name="profile_image" value="{{$user->profile_image}}" class="form-control form-control-md" id="image" placeholder="Enter Phone OTP">
                                </div>
                                @if ($user->profile_image)
                                    <img src="{{ asset('template/images/profile-images/' . $user->profile_image) }}" alt="Current Image" style="width: 80px; height:80px;">
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

@endsection
