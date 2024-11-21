@extends('auth.layout.layout')
@section('body')
<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner">
        <!-- Register -->
        <div class="card">
          <div class="card-body">
            <!-- Logo -->
            <div class="app-brand justify-content-center mb-4">
              <a href="index.html" class="app-brand-link gap-2">
                <span class="app-brand-logo demo">
                </span>
                <span class="app-brand-text demo text-body fw-bolder">{{ Config::get('app.name')}}</span>
              </a>
            </div>
            <!-- /Logo -->
            <h4 class="mb-2 d-flex justify-content-center" data-i18n="login.welcome_to">{{ __('login.welcome_to')}}</h4>
            <p class="mb-4 d-flex justify-content-center" data-i18n="login.please_sign_in_to_your_account_text">{{ __('login.please_sign_in_to_your_account_text')}}</p>

            <form id="formAuthentication" class="mb-3">
              <div class="mb-3">
                <label for="email" class="form-label" data-i18n="login.labels.email">{{ __('login.labels.email')}}</label>
                <input
                  type="text"
                  class="form-control"
                  id="email"
                  name="email"
                  placeholder="{{ __('login.labels.email_placeholder')}}"
                  autofocus
                />
              </div>
              <div class="mb-3 form-password-toggle">
                <div class="d-flex justify-content-between">
                  <label class="form-label" for="password" data-i18n="login.labels.password">{{ __('login.labels.password')}}</label>
                  <a href="auth-forgot-password-basic.html">
                    <small  data-i18n="login.labels.forgot_password">{{ __('login.labels.forgot_password')}}</small>
                  </a>
                </div>
                <div class="input-group input-group-merge">
                  <input
                    type="password"
                    id="password"
                    class="form-control"
                    name="password"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                    aria-describedby="password"
                  />
                  <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                </div>
              </div>
              <div class="mb-3">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="remember-me" />
                  <label class="form-check-label" for="remember-me"  data-i18n="login.labels.remember_me">{{ __('login.labels.remember_me')}}</label>
                </div>
              </div>
              <div class="mb-3">
                <button class="btn btn-primary d-grid w-100" type="button" onclick="submitloginform();" data-i18n="login.labels.sign_in">{{ __('login.labels.sign_in')}}</button>
              </div>
            </form>

            <p class="text-center">
              <span data-i18n="login.labels.new_on_our_platform">{{ __('login.labels.new_on_our_platform')}}</span>
              <a href="{{route('register')}}">
                <span data-i18n="login.labels.register">{{ __('login.labels.register')}}</span>
              </a>
            </p>
            <div class="btn-group float-end">
                  <button
                  class="btn btn-light btn-xs dropdown-toggle selected_language"
                  type="button"
                  data-bs-toggle="dropdown"
                  aria-expanded="false"
                  >
                  English
                  </button>
                  <ul class="dropdown-menu">
                  <li><a class="dropdown-item lang-select" data-lang="en">English</a></li>
                  <li><a class="dropdown-item lang-select" data-lang="ar">Arabic</a></li>
                  <li><a class="dropdown-item lang-select" data-lang="sp">Spenish</a></li>
                  </ul>
              </div>
          </div>
        </div>
        <!-- /Register -->
      </div>
    </div>
  </div>
  @endsection
  <!-- Core JS -->
  @section('script')
  <script>

    $(document).ready(function() {

        initializei18next('en', '{{ Route::currentRouteName() }}', "English");
        $('.lang-select').click(function() {
            var lang = $(this).data('lang'); // Assuming data-lang attribute exists
            var langtext = $(this).text(); // Assuming data-lang attribute exists

            initializei18next(lang, '{{ Route::currentRouteName() }}', langtext);
            if(lang == 'ar'){
            $('html').attr('dir', 'rtl');
            $('html').css('text-align', 'right');
            } else {
            $('html').attr('dir', 'ltr');
            $('html').css('text-align', 'left');
            }
            $('html').attr('lang', lang);
        });



    });



  </script>
  @endsection

