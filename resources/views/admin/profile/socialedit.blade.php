@extends('layouts.main')
@section('content')

<div class="row mt-5">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header text-center">
                Edit Social Profile
            </div>
            <div class="card-body">
            <form class="pt-3" method="POST" 
      action="{{ $userSocial ? route('user.profile.social.update', ['id' => $userSocial->id]) : route('user.profile.social.store') }}" 
      enctype="multipart/form-data">
      @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <label for=""><b>Facebook</b></label>
                            <div class="form-group">
                                <input type="text" name="facebook" value="{{ $userSocial->facebook ?? '' }}" class="form-control form-control-md" id="facebook" placeholder="Enter your facebook">
                            </div>
                            <x-input-error :messages="$errors->get('facebook')" />
                        </div>
                        <div class="col-md-4">
                            <label for=""><b>Instagram</b></label>
                            <div class="form-group mt-md-0 mt-3">
                                <input type="text" name="instagram" value="{{ $userSocial->instagram ?? '' }}" class="form-control form-control-md" id="instagram" placeholder="Enter Phone OTP">
                            </div>
                            <x-input-error :messages="$errors->get('instagram')" />
                        </div>
                        <div class="col-md-4">
                            <label for=""><b>Twitter</b></label>
                            <div class="form-group mt-md-0 mt-3">
                                <input type="text" name="twitter" value="{{ $userSocial->twitter ?? '' }}" class="form-control form-control-md" id="twitter" placeholder="Enter Phone OTP">
                            </div>
                            <x-input-error :messages="$errors->get('twitter')" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label for=""><b>Github</b></label>
                            <div class="form-group">
                                <input type="text" name="github" value="{{ $userSocial->github ?? '' }}" class="form-control form-control-md" id="github" placeholder="Enter your github">
                            </div>
                            <x-input-error :messages="$errors->get('github')" />
                        </div>
                        <div class="col-md-4">
                            <label for=""><b>Website</b></label>
                            <div class="form-group mt-md-0 mt-3">
                                <input type="text" name="website" value="{{ $userSocial->website ?? '' }}" class="form-control form-control-md" id="website" placeholder="Enter Phone OTP">
                            </div>
                            <x-input-error :messages="$errors->get('website')" />
                        </div>
                    </div>
                    <button class="btn btn-primary btn-md font-weight-medium auth-form-btn">Verify</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection