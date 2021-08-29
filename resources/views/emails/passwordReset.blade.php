<!-- resources/views/emails/passwordReset.blade.php -->
<html>
  <head>
    <title>Password Reset Email</title>
  </head>
  <body>
    <p>Hi, {{$person->first_name}}!</p>
    <p>You are receiving this email because we received a password reset request for your account at <a href="{{url('')}}">StudentFolder.info</a>.</p>
    <div>
        <button type="button" class="btn btn-info">
            <a href="{{route('resetPassword', [$token])}}" style="text-decoration: none; font-weight: bold;">Reset Password</a>
        </button>
    </div>
    <p>This password reset link will expire in 60 minutes.</p>

    <p>If the link above does not work, please enter: https://studentfolder.info/resetPassword/{{ $token }} in your browser.</p>

    <p>If you did not request a password reset, no further action is required.</p>
    <p>Best -<br />Rick Retzko<br />Founder, StudentFolder.info</p>
  </body>
</html>
