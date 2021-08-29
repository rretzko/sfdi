<!DOCTYPE html>
<html>
  <head>
    <title>Email Verification</title>
  </head>
  <body>
    <h2>Hi, {{$person->fullName}}!</h2>
    <p><b>Please LOG OUT of StudentFolder.info prior to clicking the link below.</b></p>
    <p>Please <a href="{{url('verifyEmailApi', [$user->verifyUser->lastToken])}}">click this link</a> to verify your {{$type}} email.</p>

    <p>If the link above does not work, please enter: https://studentfolder.info/verifyEmailApi/{{ $user->verifyUser->lastToken }} in your browser.</p>

    @if($type === "primary")<p>Note: No further emails can be sent until this email is verified!</p>@endif

    <p>Thank you for registering with StudentFolder.info!</p>
    <p>Best - <br />
        Rick Retzko<br />
        <i>Founder, StudentFolder.info</i>
    </p>
  </body>
</html>
