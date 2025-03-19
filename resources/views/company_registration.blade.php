@extends('layouts.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container">
    <h1>Company Registration</h1>
    <form id="registrationForm" enctype="multipart/form-data">
        @csrf
        <!-- Company Details -->
        <div class="form-group">
            <label for="companyName">Company Name</label>
            <input type="text" class="form-control" id="companyName" name="companyName" required>
            <span class="text-danger error" id="companyNameError"></span>
        </div>
        <div class="form-group">
            <label for="userEmail">Email</label>
            <input type="email" class="form-control" id="userEmail" name="userEmail" required>
            <span class="text-danger error" id="userEmailError"></span>
            <span id="emailStatus"></span>
        </div>
        <div class="form-group">
            <label for="userPassword">Password</label>
            <input type="password" class="form-control" id="userPassword" name="userPassword" required>
            <span class="text-danger error" id="userPasswordError"></span>
        </div>
        <!-- Add other fields as per the controller's validation rules -->
        <button type="submit" class="btn btn-primary">Register</button>
    </form>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Registration Successful</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Registration completed successfully! Please check your email at <strong id="successEmail"></strong> for verification.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Error Modal -->
<div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="errorModalLabel">Registration Failed</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="errorMessage">An error occurred during registration. Please try again.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Include jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    // Email availability check
    $('#userEmail').on('blur', function() {
        var email = $(this).val();
        if (email) {
            $.ajax({
                url: "{{ route('company.register.checkEmail') }}",
                type: "POST",
                data: { email: email, _token: $('meta[name="csrf-token"]').attr('content') },
                success: function(response) {
                    if (response.available) {
                        $('#emailStatus').text('Email is available').css('color', 'green');
                    } else {
                        $('#emailStatus').text('Email is already taken').css('color', 'red');
                    }
                },
                error: function() {
                    $('#emailStatus').text('Error checking email').css('color', 'red');
                }
            });
        }
    });

    // Form submission
    $('#registrationForm').on('submit', function(e) {
        e.preventDefault();
        $('.error').text(''); // Clear previous errors

        var formData = new FormData(this);

        $.ajax({
            url: "{{ route('company.register.store') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(response) {
                if (response.success) {
                    $('#successEmail').text($('#userEmail').val());
                    $('#successModal').modal('show');
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, messages) {
                        $('#' + key + 'Error').text(messages[0]);
                    });
                } else {
                    $('#errorMessage').text(xhr.responseJSON.error || 'An unexpected error occurred.');
                    $('#errorModal').modal('show');
                }
            }
        });
    });

    // Close modals with Escape key
    $(document).on('keydown', function(e) {
        if (e.key === 'Escape') {
            $('#successModal').modal('hide');
            $('#errorModal').modal('hide');
        }
    });
});
</script>
@endsection