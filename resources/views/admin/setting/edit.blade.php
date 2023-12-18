@extends('layouts.main')
@section('content')
    <div class="row">
        <nav aria-label="breadcrumb" class="main-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('user.settings') }}">User Settings</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center">
                    Edit Your Settings
                </div>
                <div class="card-body">
                    <form class="pt-3" method="POST"
                        action="{{ route('user.settings.update', ['id' => $userSetting->id]) }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <label for=""><b>Twillio Phone</b></label>
                                <div class="form-group">
                                    <input type="text" name="twillio_phone" value="{{ $userSetting->twillio_phone }}"
                                        class="form-control form-control-md" id="twillio_phone"
                                        placeholder="Enter your twillio phone">
                                </div>
                                <x-input-error :messages="$errors->get('twillio_phone')" />
                            </div>
                            <div class="col-md-4">
                                <label for=""><b>Twillio Auth Token</b></label>
                                <div class="form-group mt-md-0 mt-3">
                                    <input type="text" name="twillio_auth_token"
                                        value="{{ $userSetting->twillio_auth_token }}" class="form-control form-control-md"
                                        id="twillio_auth_token" placeholder="Enter Twillio Auth Token">
                                </div>
                                <x-input-error :messages="$errors->get('twillio_auth_token')" />
                            </div>
                            <div class="col-md-4">
                                <label for=""><b>Twillio SID</b></label>
                                <div class="form-group mt-md-0 mt-3">
                                    <input type="text" name="twillio_sid" value="{{ $userSetting->twillio_sid }}"
                                        class="form-control form-control-md" id="twillio_sid"
                                        placeholder="Enter Twillio SID">
                                </div>
                                <x-input-error :messages="$errors->get('twillio_sid')" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label for=""><b>Stripe Payment Secret</b></label>
                                <div class="form-group mt-md-0 mt-3">
                                    <input type="text" name="stripe_secret_key"
                                        value="{{ $userSetting->stripe_secret_key }}" class="form-control form-control-md"
                                        id="stripe_secret_key" placeholder="Enter Stripe Payment Secret">
                                </div>
                                <x-input-error :messages="$errors->get('stripe_secret_key')" />
                            </div>
                            <div class="col-md-4">
                                <label for=""><b>Stripe Publishable Keys</b></label>
                                <div class="form-group mt-md-0 mt-3">
                                    <input type="text" name="stripe_publishable_key"
                                        value="{{ $userSetting->stripe_publishable_key }}"
                                        class="form-control form-control-md" id="stripe_publishable_key"
                                        placeholder="Enter Stripe Publishable Keys">
                                </div>
                                <x-input-error :messages="$errors->get('stripe_publishable_key')" />
                            </div>
                            <div class="col-md-4">
                                <label for=""><b>Select Two FA</b></label>
                                <div class="form-group mt-md-0 mt-3">
                                    <select name="two_fa_type" class="form-control form-control-lg">
                                        <option value="NULL" <?php echo $userSetting->two_fa_type === 'NULL' ? 'selected' : ''; ?>>None</option>
                                        <option value="email" <?php echo $userSetting->two_fa_type === 'email' ? 'selected' : ''; ?>>Email</option>
                                        <option value="phone" <?php echo $userSetting->two_fa_type === 'phone' ? 'selected' : ''; ?>>Phone</option>
                                        <option value="qr_code" <?php echo $userSetting->two_fa_type === 'qr_code' ? 'selected' : ''; ?>>QR Code</option>
                                    </select>
                                </div>
                                <x-input-error :messages="$errors->get('stripe_publishable_key')" />
                            </div>
                        </div>
                        <button class="btn btn-primary btn-md font-weight-medium auth-form-btn">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
