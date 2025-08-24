<!-- BEGIN: Vendor CSS-->
<link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/fonts/font-awesome/css/font-awesome.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/vendors/css/vendors.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/vendors/css/charts/apexcharts.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/vendors/css/extensions/toastr.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/vendors/css/forms/select/select2.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/vendors/css/extensions/sweetalert2.min.css') }}">
<!-- END: Vendor CSS-->

<link rel="stylesheet" type="text/css"
    href="{{ asset('admin_assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css"
    href="{{ asset('admin_assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css') }}">

<!-- BEGIN: Theme CSS-->
<link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/css/bootstrap.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/css/bootstrap-extended.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/css/colors.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/css/components.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/css/themes/dark-layout.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/css/themes/bordered-layout.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/css/themes/semi-dark-layout.css') }}">
<link rel="stylesheet" type="text/css"
    href="{{ asset('admin_assets/css/plugins/extensions/ext-component-sweet-alerts.css') }}">
<!-- BEGIN: Page CSS-->
<link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/css/core/menu/menu-types/vertical-menu.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/css/pages/dashboard-ecommerce.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/css/plugins/charts/chart-apex.css') }}">
<link rel="stylesheet" type="text/css"
    href="{{ asset('admin_assets/css/plugins/extensions/ext-component-toastr.css') }}">
<!-- END: Page CSS-->

<link rel="stylesheet" type="text/css"
    href="{{ asset('admin_assets/css/plugins/forms/pickers/form-pickadate.min.css') }}">
<link rel="stylesheet" type="text/css"
    href="{{ asset('admin_assets/vendors/css/pickers/pickadate/pickadate.min.css') }}">
<link rel="stylesheet" type="text/css"
    href="{{ asset('admin_assets/vendors/css/pickers/flatpickr/flatpickr.min.css') }} ">

<link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/css/pages/ui-feather.css') }}">
<link rel="stylesheet" type="text/css"
    href="{{ asset('admin_assets/css/plugins/extensions/ext-component-toastr.css') }}">
<link rel="stylesheet" href="{{ asset('admin_assets/sweetalert2/sweetalert2.min.css') }}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.min.js"></script>

<!-- BEGIN: Custom CSS-->
<link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/assets/css/style.css') }}">
<!-- END: Custom CSS-->
@stack('style')
@yield('style')
<style>
    body {
        background-color: #f8f9fa;
        font-family: "Inter", sans-serif;
    }

    .task-form-container {
        /* max-width: 800px; */
        background-color: #ffffff;
        border-radius: 12px;
        /* box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); */
    }

    .form-label {
        font-weight: 500;
        color: #333;
    }

    .form-control,
    .form-select {
        border-radius: 8px;
        padding: 0.75rem;
        font-size: 1rem;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }

    .btn-primary {
        background-color: #0d6efd;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 500;
    }

    .btn-primary:hover {
        background-color: #0b5ed7;
    }

    .btn-outline-secondary {
        border-radius: 8px;
        padding: 0.5rem 1rem;
    }

    .messages-section {
        margin-top: 1.5rem;
        padding: 1rem;
        background-color: #f1f3f5;
        border-radius: 8px;
    }

    .message-item {
        background-color: #ffffff;
        padding: 0.75rem;
        margin-bottom: 0.5rem;
        border-radius: 6px;
        border: 1px solid #dee2e6;
    }

    .file-preview-section {
        margin-top: 1rem;
    }

    .file-preview {
        max-width: 100px;
        max-height: 100px;
        object-fit: cover;
        border-radius: 4px;
        margin-right: 0.5rem;
    }

    /* Subtask Styles */
    .subtasks-container {
        border: 2px dashed #e9ecef;
        border-radius: 8px;
        padding: 1rem;
        min-height: 60px;
        background-color: #f8f9fa;
    }

    .subtask-item {
        background-color: #ffffff;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1rem;
        position: relative;
        transition: all 0.3s ease;
    }

    .subtask-item:hover {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .subtask-header {
        display: flex;
        justify-content-between;
        align-items: center;
        margin-bottom: 0.75rem;
    }

    .subtask-number {
        background-color: #0d6efd;
        color: white;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        font-weight: 500;
    }

    .remove-subtask-btn {
        background: none;
        border: none;
        color: #dc3545;
        font-size: 1.2rem;
        cursor: pointer;
        padding: 0.25rem;
        border-radius: 4px;
        transition: background-color 0.3s ease;
    }

    .remove-subtask-btn:hover {
        background-color: #f8d7da;
    }

    .empty-subtasks {
        text-align: center;
        color: #6c757d;
        font-style: italic;
        padding: 2rem;
    }

    .subtask-row {
        margin-bottom: 0.75rem;
    }

    .subtask-row:last-child {
        margin-bottom: 0;
    }

    .loading-spinner {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 3px solid #f3f3f3;
        border-top: 3px solid #3498db;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    @media (max-width: 768px) {
        .subtask-item .row {
            margin: 0;
        }

        .subtask-item .col-md-8,
        .subtask-item .col-md-4 {
            padding: 0.25rem;
        }
    }

    @media (max-width: 576px) {
        .task-form-container {
            margin: 1rem;
            padding: 1.5rem;
        }

        .form-control,
        .form-select {
            font-size: 0.9rem;
        }

        .btn-primary,
        .btn-outline-secondary {
            width: 100%;
        }

        .subtask-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }
    }
</style>
