<!-- resources/views/emails/confirmation.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Email Confirmation</title>
</head>
<body>
    <p>Hi {{ $user->first_name }},</p>
    <p>Thank you for registering! Please click the link below to verify your email:</p>
    <p><a href="{{ $confirmationLink }}">Verify Email</a></p>
    <p>If you didn’t register, please ignore this email.</p>
</body>
</html>