<!DOCTYPE html>
<html
  lang="en"
  class="light-style customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="{{ asset('sneat/assets/')}}"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login Basic - Pages | Sneat - Bootstrap 5 HTML Admin Template - Pro</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('sneat/assets/img/favicon/favicon.ico')}}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />
    <!-- load lanugage libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-i18next/0.0.14/i18next-jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/i18next/2.0.22/i18next.min.js"></script>

    @if (Config::get('app.admin_theme') === "sneat")
        <!-- Icons. Uncomment required icon fonts -->
        <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/fonts/boxicons.css')}}" />
        <!-- Core CSS -->
        <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/css/core.css')}}" class="template-customizer-core-css" />
        <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/css/theme-default.css')}}" class="template-customizer-theme-css" />
        <link rel="stylesheet" href="{{ asset('sneat/assets/css/demo.css')}}" />
        <!-- Vendors CSS -->
        <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />
        <!-- Page CSS -->
        <!-- Page -->
        <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/css/pages/page-auth.css')}}" />
        <!-- Helpers -->
        <script src="{{ asset('sneat/assets/vendor/js/helpers.js')}}"></script>
        <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
        <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
        <script src="{{ asset('sneat/assets/js/config.js')}}"></script>
    @elseif (Config::get('app.admin_theme') === "materialize")
        <!-- Icons -->
        <link rel="stylesheet" href="{{ asset('materialize/assets/vendor/fonts/materialdesignicons.css')}}" />
        <link rel="stylesheet" href="{{ asset('materialize/assets/vendor/fonts/fontawesome.css')}}" />

        <!-- Core CSS -->
        <link rel="stylesheet" href="{{ asset('materialize/assets/vendor/css/rtl/core.css')}}" class="template-customizer-core-css" />
        <link rel="stylesheet" href="{{ asset('materialize/assets/vendor/css/rtl/theme-default.css')}}" class="template-customizer-theme-css" />
        <link rel="stylesheet" href="{{ asset('materialize/assets/css/demo.css')}}" />

        <!-- Vendors CSS -->
        <link rel="stylesheet" href="{{ asset('materialize/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />
        <link rel="stylesheet" href="{{ asset('materialize/assets/vendor/libs/node-waves/node-waves.css')}}" />
        <link rel="stylesheet" href="{{ asset('materialize/assets/vendor/libs/typeahead-js/typeahead.css')}}" />
        <!-- Vendor -->
        <link rel="stylesheet" href="{{ asset('materialize/assets/vendor/libs/formvalidation/dist/css/formValidation.min.css')}}" />

        <link rel="stylesheet" href="{{ asset('materialize/assets/vendor/libs/animate-css/animate.css')}}" />
        <link rel="stylesheet" href="{{ asset('materialize/assets/vendor/libs/sweetalert2/sweetalert2.css')}}" />
        <!-- Page CSS -->
        <!-- Page -->
        <link rel="stylesheet" href="{{ asset('materialize/assets/vendor/css/pages/page-auth.css')}}" />
    @endif
  </head>

  <body>
    <!-- Content -->

    @yield('body')

    @if (Config::get('app.admin_theme') === "sneat")
    <!-- build:js assets/vendor/js/core.js -->
        <script src="{{ asset('sneat/assets/vendor/libs/jquery/jquery.js')}}"></script>
        <script src="{{ asset('sneat/assets/vendor/libs/popper/popper.js')}}"></script>
        <script src="{{ asset('sneat/assets/vendor/js/bootstrap.js')}}"></script>
        <script src="{{ asset('sneat/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
        <script src="{{ asset('sneat/assets/vendor/js/menu.js')}}"></script>
        <!-- endbuild -->
        <!-- Vendors JS -->
        <!-- Main JS -->
    <script src="{{ asset('sneat/assets/js/main.js')}}"></script>

    @elseif (Config::get('app.admin_theme') === "materialize")
        <!-- Helpers -->
        <script src="{{ asset('materialize/assets/vendor/js/helpers.js')}}"></script>
        <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
        <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
        {{-- <script src="{{ asset('materialize/assets/vendor/js/template-customizer.js')}}"></script> --}}
        <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
        <script src="{{ asset('materialize/assets/js/config.js')}}"></script>
        <!-- build:js assets/vendor/js/core.js -->
        <script src="{{ asset('materialize/assets/vendor/libs/jquery/jquery.js')}}"></script>
        <script src="{{ asset('materialize/assets/vendor/libs/popper/popper.js')}}"></script>
        <script src="{{ asset('materialize/assets/vendor/js/bootstrap.js')}}"></script>
        <script src="{{ asset('materialize/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
        <script src="{{ asset('materialize/assets/vendor/libs/node-waves/node-waves.js')}}"></script>

        <script src="{{ asset('materialize/assets/vendor/libs/hammer/hammer.js')}}"></script>
        <script src="{{ asset('materialize/assets/vendor/libs/i18n/i18n.js')}}"></script>
        <script src="{{ asset('materialize/assets/vendor/libs/typeahead-js/typeahead.js')}}"></script>

        <script src="{{ asset('materialize/assets/vendor/js/menu.js')}}"></script>
        <!-- endbuild -->

        <!-- Vendors JS -->
        <script src="{{ asset('materialize/assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js')}}"></script>
        <script src="{{ asset('materialize/assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js')}}"></script>
        <script src="{{ asset('materialize/assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js')}}"></script>

        <script src="{{ asset('materialize/assets/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>
        <!-- Main JS -->
        {{-- <script src="{{ asset('materialize/assets/js/main.js')}}"></script> --}}
        <!-- Page JS -->
        <script src="{{ asset('materialize/assets/js/pages-auth.js')}}"></script>
    @endif
    @yield('script')
    <script>
        function fetchLanguageFile(language, filename) {
            return new Promise(function(resolve, reject) {
            $.ajax({
                url: `/languages/${language}/${filename}`,
                dataType: 'json',
                success: function(data) {
                    resolve(data);
                },
                error: function(xhr, status, error) {
                    reject(error);
                }
                });
            });
        }
        function initializei18next(language, filename, languagename) {
            fetchLanguageFile(language, filename)
                .then(function(translationData) {
                i18next.init({
                    lng: language,
                    resources: {
                    [language]: {
                        translation: translationData
                    }
                    }
                }, function(err, t) {
                    if (err) {
                        console.error('Error initializing i18next:', err);
                    } else {
                    // Optional: Initialize any i18next plugins (e.g., i18nextJquery)
                        i18nextJquery.init(i18next, $);
                        // Localize the entire body
                        $('body').localize();
                        $(".selected_language").text(languagename);
                    }
                });
                })
                .catch(function(error) {
                console.error('Error fetching language file:', error);
                });
        }
    </script>
  </body>
</html>
