    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>@yield('title') | Investor Management</title>
        <!-- [Meta] -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=0, user-scalable=0, minimal-ui">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description"
            content="Light Able admin and dashboard template offer a variety of UI elements and pages, ensuring your admin panel is both fast and effective." />
        <meta name="author" content="phoenixcoded" />

        <!-- [Favicon] icon -->
        <link rel="shortcut icon" href="{{ URL::asset('build/images/favicon.ico') }}" type="image/x-icon">

        @yield('css')

        @include('layouts.head-css')

        <style>
            body {
                /* transform: scale(0.75); */
                /* transform-origin: top left; */
                /* width: 133.33%; */
                /* 100 / 0.75 = 133.33 */
            }
        </style>
    </head>

    <body data-pc-preset="preset-1" data-pc-sidebar-theme="dark" data-pc-sidebar-caption="true" data-pc-direction="ltr"
        data-pc-theme="light">
        @include('layouts.loader')
        @include('layouts.sidebar')
        @include('layouts.topbar')

        <!-- [ Main Content ] start -->
        <div class="pc-container">
            <div class="pc-content">
                @if (View::hasSection('breadcrumb-item'))
                    @include('layouts.breadcrumb')
                @endif
                <!-- [ Main Content ] start -->
                @yield('content')
                <!-- [ Main Content ] end -->
            </div>
        </div>
        <!-- [ Main Content ] end -->

        @include('layouts.footer')
        {{-- @include('layouts.customizer') --}}

        @include('layouts.footerjs')

        @yield('scripts')

    </body>
    <!-- [Body] end -->

    </html>
