@extends('layouts.main')
@section('content')
    <div class="row">
        <nav aria-label="breadcrumb" class="main-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('user.settings') }}">User Settings</a></li>
                <li class="breadcrumb-item active" aria-current="page">create</li>
            </ol>
        </nav>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center">
                    Create Your Settings
                </div>
                <div class="card-body">
                    <form class="pt-3" method="POST" action="{{ route('user.settings.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <label for=""><b>Twillio Phone</b></label>
                                <div class="form-group">
                                    <input type="text" name="twillio_phone" value=""
                                        class="form-control form-control-md" id="twillio_phone"
                                        placeholder="Enter your twillio phone">
                                </div>
                                <x-input-error :messages="$errors->get('twillio_phone')" />
                            </div>
                            <div class="col-md-4">
                                <label for=""><b>Twillio Auth Token</b></label>
                                <div class="form-group mt-md-0 mt-3">
                                    <input type="text" name="twillio_auth_token" value=""
                                        class="form-control form-control-md" id="twillio_auth_token"
                                        placeholder="Enter Twillio Auth Token">
                                </div>
                                <x-input-error :messages="$errors->get('twillio_auth_token')" />
                            </div>
                            <div class="col-md-4">
                                <label for=""><b>Twillio SID</b></label>
                                <div class="form-group mt-md-0 mt-3">
                                    <input type="text" name="twillio_sid" value=""
                                        class="form-control form-control-md" id="twillio_sid"
                                        placeholder="Enter Twillio SID">
                                </div>
                                <x-input-error :messages="$errors->get('twillio_sid')" />
                            </div>
                        </div>
                        {{-- <div class="row">
                        <div class="col-md-4">
                            <label for=""><b>two_fa_enable</b></label>
                            <div class="form-group">
                                <input type="text" name="two_fa_enable" value="" class="form-control form-control-md" id="two_fa_enable" placeholder="Enter your two_fa_enable">
                            </div>
                            <x-input-error :messages="$errors->get('two_fa_enable')" />
                        </div>
                        <div class="col-md-4">
                            <label for=""><b>two_fa_type</b></label>
                            <div class="form-group mt-md-0 mt-3">
                                <input type="text" name="two_fa_type" value="" class="form-control form-control-md" id="two_fa_type" placeholder="Enter two_fa_type">
                            </div>
                            <x-input-error :messages="$errors->get('two_fa_type')" />
                        </div>
                    </div> --}}
                        <div class="row">
                            {{-- <div class="col-md-4">
                            <label for=""><b>Payment Method Enable</b></label>
                            <div class="form-group">
                                <input type="text" name="payment_method_enable" value="" class="form-control form-control-md" id="payment_method_enable" placeholder="Enter your Payment Method Enable">
                            </div>
                            <x-input-error :messages="$errors->get('payment_method_enable')" />
                        </div> --}}
                            <div class="col-md-4">
                                <label for=""><b>Stripe Payment Secret</b></label>
                                <div class="form-group mt-md-0 mt-3">
                                    <input type="text" name="stripe_secret_key" value=""
                                        class="form-control form-control-md" id="stripe_secret_key"
                                        placeholder="Enter Stripe Payment Secret">
                                </div>
                                <x-input-error :messages="$errors->get('stripe_secret_key')" />
                            </div>
                            <div class="col-md-4">
                                <label for=""><b>Stripe Publishable Keys</b></label>
                                <div class="form-group mt-md-0 mt-3">
                                    <input type="text" name="stripe_publishable_key" value=""
                                        class="form-control form-control-md" id="stripe_publishable_key"
                                        placeholder="Enter Stripe Publishable Keys">
                                </div>
                                <x-input-error :messages="$errors->get('stripe_publishable_key')" />
                            </div>
                            <div class="col-md-4">
                                <label for=""><b>Select Two FA</b></label>
                                <div class="form-group mt-md-0 mt-3">
                                    <select name="two_fa_type" class="form-control form-control-lg">
                                        <option value="NULL">None</option>
                                        <option value="email">Email</option>
                                        <option value="qr_code">QR Code</option>
                                    </select>
                                </div>
                                <x-input-error :messages="$errors->get('stripe_publishable_key')" />
                            </div>
                        </div>
                        <button class="btn btn-primary btn-md font-weight-medium auth-form-btn">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
