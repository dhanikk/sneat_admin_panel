/**
 *  Pages Authentication
 */

'use strict';
const formAuthentication = document.querySelector('#formAuthentication');
const formRegistration = document.querySelector('#formRegistration');

let fv;
let rv;
document.addEventListener('DOMContentLoaded', function (e) {
  (function () {
    // Form validation for Add new record
    if (formAuthentication) {
      const fv = FormValidation.formValidation(formAuthentication, {
        fields: {
          username: {
            validators: {
              notEmpty: {
                message: 'Please enter username'
              },
              stringLength: {
                min: 6,
                message: 'Username must be more than 6 characters'
              }
            }
          },
          email: {
            validators: {
              notEmpty: {
                message: 'Please enter your email'
              },
              emailAddress: {
                message: 'Please enter valid email address'
              }
            }
          },
          'email-username': {
            validators: {
              notEmpty: {
                message: 'Please enter email / username'
              },
              stringLength: {
                min: 6,
                message: 'Username must be more than 6 characters'
              }
            }
          },
          password: {
            validators: {
              notEmpty: {
                message: 'Please enter your password'
              },
              stringLength: {
                min: 6,
                message: 'Password must be more than 6 characters'
              }
            }
          },
          'confirm-password': {
            validators: {
              notEmpty: {
                message: 'Please confirm password'
              },
              identical: {
                compare: function () {
                  return formAuthentication.querySelector('[name="password"]').value;
                },
                message: 'The password and its confirm are not the same'
              },
              stringLength: {
                min: 6,
                message: 'Password must be more than 6 characters'
              }
            }
          },
          terms: {
            validators: {
              notEmpty: {
                message: 'Please agree terms & conditions'
              }
            }
          }
        },
        plugins: {
          trigger: new FormValidation.plugins.Trigger(),
          bootstrap5: new FormValidation.plugins.Bootstrap5({
            eleValidClass: '',
            rowSelector: '.mb-3'
          }),
          submitButton: new FormValidation.plugins.SubmitButton(),

          defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
          autoFocus: new FormValidation.plugins.AutoFocus()
        },
        init: instance => {
          instance.on('plugins.message.placed', function (e) {
            if (e.element.parentElement.classList.contains('input-group')) {
              e.element.parentElement.insertAdjacentElement('afterend', e.messageElement);
            }
          });
        }
      });
    }


    if (formRegistration) {
        const rv = FormValidation.formValidation(formRegistration, {
          fields: {
            "first_name": {
                validators: {
                    notEmpty: {
                        message: 'Please enter first name'
                    },
                    stringLength: {
                        min: 6,
                        message: 'first name must be more than 6 characters'
                    }
                }
            },
            "last_name": {
                validators: {
                    notEmpty: {
                        message: 'Please enter last name'
                    },
                    stringLength: {
                        min: 6,
                        message: 'last name must be more than 6 characters'
                    }
                }
            },
            username: {
              validators: {
                notEmpty: {
                  message: 'Please enter username'
                },
                stringLength: {
                  min: 6,
                  message: 'Username must be more than 6 characters'
                }
              }
            },
            email: {
              validators: {
                notEmpty: {
                  message: 'Please enter your email'
                },
                emailAddress: {
                  message: 'Please enter valid email address'
                }
              }
            },
            'email-username': {
              validators: {
                notEmpty: {
                  message: 'Please enter email / username'
                },
                stringLength: {
                  min: 6,
                  message: 'Username must be more than 6 characters'
                }
              }
            },
            password: {
              validators: {
                notEmpty: {
                  message: 'Please enter your password'
                },
                stringLength: {
                  min: 6,
                  message: 'Password must be more than 6 characters'
                }
              }
            },
            'confirm-password': {
              validators: {
                notEmpty: {
                  message: 'Please confirm password'
                },
                identical: {
                  compare: function () {
                    return formAuthentication.querySelector('[name="password"]').value;
                  },
                  message: 'The password and its confirm are not the same'
                },
                stringLength: {
                  min: 6,
                  message: 'Password must be more than 6 characters'
                }
              }
            },
            terms: {
              validators: {
                notEmpty: {
                  message: 'Please agree terms & conditions'
                }
              }
            }
          },
          plugins: {
            trigger: new FormValidation.plugins.Trigger(),
            bootstrap5: new FormValidation.plugins.Bootstrap5({
              eleValidClass: '',
              rowSelector: '.mb-3'
            }),
            submitButton: new FormValidation.plugins.SubmitButton(),

            defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
            autoFocus: new FormValidation.plugins.AutoFocus()
          },
          init: instance => {
            instance.on('plugins.message.placed', function (e) {
              if (e.element.parentElement.classList.contains('input-group')) {
                e.element.parentElement.insertAdjacentElement('afterend', e.messageElement);
              }
            });
          }
        });
      }



    //  Two Steps Verification
    const numeralMask = document.querySelectorAll('.numeral-mask');

    // Verification masking
    if (numeralMask.length) {
      numeralMask.forEach(e => {
        new Cleave(e, {
          numeral: true
        });
      });
    }
  })();
});


$('#formAuthentication').on('submit', function(event) {
    event.preventDefault();

    // AJAX request
    $.ajax({
        url: "/login",  // URL for AJAX login route
        method: "POST",
        data: $(this).serialize(),
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // Add CSRF token
        },
        success: function(response) {
            console.log(response);
            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    text: response.message,
                    footer: '<a href>Why do I have this issue?</a>',
                    customClass: {
                        confirmButton: 'btn btn-primary waves-effect waves-light'
                    },
                    buttonsStyling: false
                });
                window.location.href = response.redirect_url;  // Redirect on success
            } else {
                Swal.fire({
                    icon: 'error',
                    text: response.message,
                    footer: '<a href>Why do I have this issue?</a>',
                    customClass: {
                        confirmButton: 'btn btn-primary waves-effect waves-light'
                    },
                    buttonsStyling: false
                });
            }
        },
        error: function(response) {
            if (!response.responseJSON.success) {
                Swal.fire({
                    icon: 'error',
                    text: response.responseJSON.message,
                    footer: '<a href>Why do I have this issue?</a>',
                    customClass: {
                        confirmButton: 'btn btn-primary waves-effect waves-light'
                    },
                    buttonsStyling: false
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: "Something went wrong",
                    footer: '<a href>Why do I have this issue?</a>',
                    customClass: {
                        confirmButton: 'btn btn-primary waves-effect waves-light'
                    },
                    buttonsStyling: false
                });
                console.log(response);
            }
        }
    });
});


$('#formRegistration').on('submit', function(event) {
    event.preventDefault();

    // AJAX request
    $.ajax({
        url: "/register",  // URL for AJAX login route
        method: "POST",
        data: $(this).serialize(),
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // Add CSRF token
        },
        success: function(response) {
            console.log(response);
            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    text: response.message,
                    footer: '<a href>Why do I have this issue?</a>',
                    customClass: {
                        confirmButton: 'btn btn-primary waves-effect waves-light'
                    },
                    buttonsStyling: false
                });
                window.location.href = response.redirect_url;  // Redirect on success
            } else {
                Swal.fire({
                    icon: 'error',
                    text: response.message,
                    footer: '<a href>Why do I have this issue?</a>',
                    customClass: {
                        confirmButton: 'btn btn-primary waves-effect waves-light'
                    },
                    buttonsStyling: false
                });
            }
        },
        error: function(response) {
            if (!response.responseJSON.success) {
                Swal.fire({
                    icon: 'error',
                    text: response.responseJSON.message,
                    footer: '<a href>Why do I have this issue?</a>',
                    customClass: {
                        confirmButton: 'btn btn-primary waves-effect waves-light'
                    },
                    buttonsStyling: false
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: "Something went wrong",
                    footer: '<a href>Why do I have this issue?</a>',
                    customClass: {
                        confirmButton: 'btn btn-primary waves-effect waves-light'
                    },
                    buttonsStyling: false
                });
                console.log(response);
            }
        }
    });
});


function submitloginform(){
    $('#formAuthentication').submit();
}

function submitregistrationform(){
    $('#formRegistration').submit();
}
