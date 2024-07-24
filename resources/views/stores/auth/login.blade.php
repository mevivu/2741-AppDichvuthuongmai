@extends('admin.layouts.guest.master')

@section('content')
    <div class="page page-center">
        <div class="container-tight py-4">
            <x-form :action="route('store.login.post')" class="card card-md" type="post" :validate="true">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <img src="{{ asset($logo) }}" width="200" alt="">
                    </div>
                    <h2 class="card-title text-center mb-4">@lang('login')</h2>
                    <div class="mb-3">
                        <label class="form-label">@lang('username'):</label>
                        <x-input name="username" :required="true" :placeholder="trans('username')" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">@lang('password'):</label>
                        <x-input-password name="password" :required="true" />
                    </div>
                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100">@lang('login')</button>
                    </div>
                    <p class="text-center mt-3">@lang('noAccount')?<br>
                        <x-link :href="route('store.register.index')">@lang('registerStore')</x-link>
                    </p>
                </div>
            </x-form>
        </div>
    </div>
@endsection
