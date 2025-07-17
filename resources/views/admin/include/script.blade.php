<!-- BEGIN: Vendor JS-->
<script src="{{ asset('admin_assets/vendors/js/vendors.min.js') }}"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
<script src="{{ asset('admin_assets/vendors/js/charts/apexcharts.min.js') }}"></script>
<script src="{{ asset('admin_assets/vendors/js/extensions/toastr.min.js') }}"></script>
<script src="../../../app-assets/vendors/js/extensions/sweetalert2.all.min.js"></script>
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="{{ asset('admin_assets/js/core/app-menu.js') }}"></script>
<script src="{{ asset('admin_assets/js/core/app.js') }}"></script>
<!-- END: Theme JS-->

<!-- BEGIN: Page Vendor JS-->
<script src="{{ asset('admin_assets/vendors/js/tables/datatable/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin_assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('admin_assets/vendors/js/tables/datatable/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('admin_assets/vendors/js/tables/datatable/responsive.bootstrap4.js') }}"></script>
<script src="{{ asset('admin_assets/vendors/js/pickers/flatpickr/flatpickr.min.js') }}"></script>
<script src="{{ asset('admin_assets/vendors/js/forms/select/select2.full.min.js') }}"></script>

<!-- END: Page Vendor JS-->
<script src="{{ asset('admin_assets/vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('admin_assets/js/scripts/components/components-alerts.js') }}"></script>

<!-- BEGIN: Page JS-->
<script src="{{ asset('admin_assets/js/scripts/tables/table-datatables-advanced.js') }}"></script>

<script src="{{ asset('admin_assets/js/scripts/ui/ui-feather.js') }}"></script>
<!-- END: Page JS-->

<script src="{{ asset('admin_assets/js/scripts/extensions/ext-component-toastr.js') }}"></script>
<script src="{{ asset('admin_assets/js/scripts/extensions/ext-component-sweet-alerts.js') }}"></script>

<script src="{{ asset('admin_assets/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('admin_assets/sweetalert2/sweetalert2.all.min.js') }}"></script>

<script src="{{ asset('admin_assets/js/scripts/forms/form-select2.js') }}"></script>
<script>
    $(window).on('load', function() {
        if (feather) {
            feather.replace({
                width: 14,
                height: 14
            });
        }
    })
</script>
@yield('chartscripts')
<script src="{{ asset('admin_assets/js/datatableButton/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('admin_assets/js/datatableButton/jszip.min.js') }}"></script>
<script src="{{ asset('admin_assets/js/datatableButton/buttons.html5.min.js') }}"></script>
<script src="{{ asset('admin_assets/js/datatableButton/buttons.print.min.js') }}"></script>
<script src="{{ asset('admin_assets/js/scripts/charts/chart-chartjs.js') }}"></script>

<script src="{{ asset('admin_assets/js/scripts/forms/pickers/form-pickers.min.js')}}"></script>

@yield('datatablescripts')
@include('admin.include.alertmessage')
@stack('scripts')
@yield('scripts')

<script>
    $('form').submit(function() {
        $(this).find(':submit').attr('disabled', 'disabled');
        //the rest of your code
    });
</script>

<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

<script>
  // Enable pusher logging - don't include this in production
  Pusher.logToConsole = false;

  var pusher = new Pusher('c4edadbb9b7e7ce33c04', {
    cluster: 'ap1'
  });

function unescapeHtml(html) {
  return html.replace(/\\(.)/g, function (_, char) {
    return char;
  });
}

  var channel = pusher.subscribe('notification-channel');
  channel.bind('request-notification', function(data) {

      $(document).ready(function(){
        $.ajax({
         url: "{{ route('notification.status') }}",
         data: {
           _token: '{{ csrf_token() }}'
         },
        success: function( data ) {
            $(".noticcountLevel").text(data.count + " New");
            $(".noticeCount").text(data.count);
            $(".noticeBoard").html(data.data);
        }
        });
      })

  });
</script>
