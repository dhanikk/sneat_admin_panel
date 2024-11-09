@extends('auth.layout.layout')
@section('body')
<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner">
        <!-- Register -->
        <div class="card">
          <div class="card-body">
            <!-- Logo -->
            <div class="app-brand justify-content-center">
              <a href="index.html" class="app-brand-link gap-2">
                <span class="app-brand-logo demo">

                </span>
                <span class="app-brand-text demo text-body fw-bolder">{{ Config::get('app.name')}}</span>
              </a>
            </div>
            <!-- /Logo -->
            <h4 class="mb-2" data-i18n="register.heading">{{ __('register.heading')}}</h4>
            <p class="mb-4" data-i18n="register.sub_description">{{ __('register.sub_description')}}</p>

            <form id="formRegistration" class="mb-3">
                <div class="mb-3">
                    <label for="first_name" class="form-label" data-i18n="register.labels.first_name">{{ __('register.labels.first_name')}}</label>
                    <input
                        type="text"
                        class="form-control"
                        id="first_name"
                        name="first_name"
                        placeholder="{{ __('register.labels.first_name_placeholder')}}"
                        autofocus
                        data-i18n="register.labels.first_name_placeholder"
                    />
                </div>
                <div class="mb-3">
                    <label for="last_name" class="form-label" data-i18n="register.labels.last_name_placeholder">{{ __('register.labels.last_name')}}</label>
                    <input
                        type="text"
                        class="form-control"
                        id="last_name"
                        name="last_name"
                        placeholder="{{ __('register.labels.last_name_placeholder')}}"
                        autofocus
                        data-i18n="register.labels.last_name_placeholder"
                    />
                </div>
              <div class="mb-3">
                <label for="email" class="form-label" data-i18n="register.labels.email">{{ __('register.labels.email')}}</label>
                <input
                  type="text"
                  class="form-control"
                  id="email"
                  name="email"
                  placeholder="{{ __('register.labels.email_placeholder')}}"
                  autofocus
                  data-i18n="register.labels.email_placeholder"
                />
              </div>
              <div class="mb-3 form-password-toggle">
                <label for="password" class="form-label" data-i18n="register.labels.password">{{ __('register.labels.password')}}</label>
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
                <button class="btn btn-primary d-grid w-100" type="button" onclick="submitregistrationform();" data-i18n="register.labels.sign_up">{{ __('register.labels.sign_up')}}</button>
              </div>
            </form>

            <p class="text-center">
              <span data-i18n="[html]register.labels.already_have_an_account">{!! __('register.labels.already_have_an_account')!!}</span>
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

