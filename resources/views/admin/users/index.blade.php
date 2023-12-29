@extends('layouts.main')
@section('content')
    <div class="container">
        <nav aria-label="breadcrumb" class="main-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('user.settings') }}">User</a></li>
                <li class="breadcrumb-item active" aria-current="page">Listing</li>
            </ol>
        </nav>
        <div class="main-body">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Users Table</h4>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>
                                            User Image
                                        </th>
                                        <th>
                                            Name
                                        </th>
                                        <th>
                                            Progress
                                        </th>
                                        <th>
                                            Email
                                        </th>
                                        <th>
                                            Phone
                                        </th>
                                        <th>
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td class="py-1">
                                                @if ($user->profile_image)
                                                    <img src="{{ asset('template/images/profile-images/' . $user->profile_image) }}"
                                                        class="rounded-circle" alt="User Profile Image" width="150"
                                                        height="150">
                                                @else
                                                    <img src="{{ asset('template/images/profile-images/avatar7.png') }}"
                                                        alt="Admin" class="rounded-circle" width="150">
                                                @endif
                                            </td>
                                            <td>
                                                {{ $user->name }}
                                            </td>
                                            <td>
                                                <div class="progress">
                                                    <div class="progress-bar bg-success" role="progressbar"
                                                        style="width: 25%" aria-valuenow="25" aria-valuemin="0"
                                                        aria-valuemax="100"></div>
                                                </div>
                                            </td>
                                            <td>
                                                {{ $user->email }}
                                            </td>
                                            <td>
                                                {{ $user->phone_number }}
                                            </td>
                                            <td>
                                                <button type="button"
                                                    class="btn btn-outline-secondary btn-rounded btn-icon">
                                                    <i class="typcn typcn-archive text-danger"></i>
                                                </button>

                                                <button type="button"
                                                    class="btn btn-outline-secondary btn-rounded btn-icon">
                                                    <i class="typcn typcn-edit  text-primary"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
