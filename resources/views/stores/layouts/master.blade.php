<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('stores.layouts.head')
</head>

<body>
    <div class="page">
        <x-store-sidebar-left />
        @include('stores.layouts.sidebar-top')
        <div class="page-wrapper">
            @section('breadcrums')
                @include('stores.layouts.partials.breadcrums')
            @show

            @yield('content')

            @include('stores.layouts.footer')

            @include('stores.layouts.modal.modal-logout')

            @include('stores.layouts.modal.modal-delete')

        </div>
    </div>
    @include('stores.layouts.scripts')
    @include('stores.notifications.scripts.firebase-script')
    <x-alert />
</body>

</html>
