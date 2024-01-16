@extends('layouts.main')
<style>
    .radio-option {
        display: inline-block;
        /* Display the radio options inline */
        margin-right: 20px;
        /* Add spacing between radio options */
    }
</style>
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


                    <div class="card text-center">
                        <div class="card-header">
                            <b>2FA</b>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div>
                                    <h4>Select 2FA type to Enable</h4>
                                    <form class="radio-options">
                                        <div class="radio-option">
                                            <label>
                                                <input type="radio" id="switch-none" name="selected_value" value="NULL">
                                                None
                                            </label>
                                        </div>
                                        <div class="radio-option" style="margin-right: 100px; margin-left: 100px;">
                                            <label>
                                                <input type="radio" id="switch-email" name="selected_value"
                                                    value="email_enable"> Email 2FA
                                            </label>
                                        </div>
                                        <div class="radio-option" style="margin-right: 100px; margin-left: 100px;">
                                            <label>
                                                <input type="radio" id="switch-email" name="selected_value"
                                                    value="phone_enable"> Phone 2FA
                                            </label>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>


                </div>
            </div>
        </div>
    </div>
@endsection



<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
        console.log('here')
        // Fetch initial 2FA setting
        $.ajax({
            type: 'GET',
            url: '{{ route('get.user.profile.2fa.store') }}',
            success: function(response) {
                console.log(response);
                if (response.twoFaValue == 'email_enable') {
                    $('#switch-email').prop('checked', true);
                    $('#switch-none').prop('checked', false);
                } else {
                    $('#switch-none').prop('checked', true);
                    $('#switch-email').prop('checked', false);
                }
            },
            error: function(xhr) {
                console.error('Error fetching initial value');
            },
        });

        // Handle radio button change
        $('input[type="radio"]').on('change', function() {
            var selectedValue = $(this).val();
            console.log(selectedValue);
            // return;
            $.ajax({
                type: 'POST',
                url: '{{ route('user.profile.2fa.store') }}',
                data: {
                    selected_value: selectedValue,
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(data) {
                    console.log(data.selectedValue);
                    if (selectedValue == 'email_enable') {
                        $('#switch-email').prop('checked', true);
                        $('#switch-none').prop('checked', false);
                        toastr.success("The 2FA setting is enabled");
                    } else {
                        $('#switch-email').prop('checked', false);
                        $('#switch-none').prop('checked', true);
                        toastr.success("The 2FA setting is disabled");
                    }
                },
                error: function(xhr) {
                    console.error('Error storing value');
                },
            });
        });
    });
</script>
