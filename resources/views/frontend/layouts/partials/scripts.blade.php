<script src="{{ asset('backend/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('backend/plugins/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('frontend/js/sweet-alert.min.js') }}"></script>
<script src="{{ asset('frontend') }}/js/axios.min.js"></script>

<script>
    // Toast config
    @if (Session::has('success'))
        toastr.success("{{ Session::get('success') }}", 'Success!')
    @elseif (Session::has('warning'))
        toastr.warning("{{ Session::get('warning') }}", 'Warning!')
    @elseif (Session::has('error'))
        toastr.error("{{ Session::get('error') }}", 'Error!')
    @endif
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "hideMethod": "fadeOut"
    }

    // Sweetalert config
    $('.login_required').click(function(event) {
        event.preventDefault();
        swal({
            title: '{{ __("do_you_want_to_login") }}',
            text: '{{ __("if_you_do_this_action_you_need_to_login_your_account_first") }}',
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#3daf29',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Login',
            closeOnConfirm: false,
            // closeOnCancel: false
        },
        function() {
            // window.location.href = "{{ route('users.login') }}";
            var url = "{{ route('users.login') }}";
            var returnUrl = encodeURIComponent(event.target.baseURI);
            window.location.href = url + "?returnUrl=" + returnUrl;
        });
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
