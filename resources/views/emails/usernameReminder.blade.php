<!-- resources/views/emails/usernameReminder.blade.php -->
<html>
  <head>
    <title>Username Reminder Email</title>
  </head>
  <body>
    <p>Hi, {{$person->first_name}}!</p>
    <p>You are receiving this email because we received a username reminder 
        request for your account at <a href="{{url('')}}">StudentFolder.info</a>.</p>
    <p>Your username is: <b>{{ $username }}</b></p>
    <p>You will also receive this reminder if your email is shared with another  
        student who requested this reminder.</p>
    <p>Best -<br />Rick Retzko<br />Founder, StudentFolder.info</p>
  </body>
</html>