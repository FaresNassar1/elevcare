@extends('frontend::layouts.app')
@section('content')
<div class="main-content bg-circle inner">
    <div class="container sm-100">
        <div class="page-thumbnail" style="background-image:url({{ upload_url(get_config('banner')) }})"></div>

        <h2 class="title primary">{{ __('contact us') }}</h2>
    </div>
    <div class="container">
        @if ($message = Session::get('success'))
        <div class="alert">
            {{ $message }}
        </div>
        @endif
        <form id="contactFrom" action="{{ route('contact-us.store') }}" class="contact-form submit" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="">{{ __('first name') }}</label>
                <div><input type="text" name="first_name" value="{{ old('first_name') }}">
                    @error('first_name')
                    <small class="help-block">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label for="">{{ __('last name') }}</label>
                <div><input type="text" name="last_name" value="{{ old('last_name') }}">
                    @error('last_name')
                    <small class="help-block">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label for="">{{ __('email') }}</label>
                <div><input type="email" name="email" value="{{ old('email') }}">
                    @error('email')
                    <small class="help-block">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label for="">{{ __('phone number') }}</label>
                <div> <input type="text" name="phone" value="{{ old('phone') }}">
                    @error('phone')
                    <small class="help-block">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label for="">{{ __('your message') }}</label>
                <div>
                    <textarea name="message" id="">{{ old('message') }}</textarea>
                    @error('message')
                    <small class="help-block">{{ $message }}</small>
                    @enderror
                    @if (get_config('captcha'))
                    <div id="recaptcha-render"></div>
                    @error('g-recaptcha-response')
                    <small class="help-block">{{ $message }}</small>
                    @enderror
                    @endif
                </div>
            </div>
            <button data-sitekey='{{ get_config('google_captcha.site_key') }}' data-callback='onSubmit' data-action='Submit' type="submit" class="g-recaptcha btn">
                {{ __('submit') }}</button>
        </form>
        @push('scripts')
        <script nonce="{{ csp_nonce() }}">
            function onSubmit(token) {
                document.getElementById("contactFrom").submit();
            }

        </script>
        @endpush
    </div>
</div>
</div>
@endsection
