<!DOCTYPE html>
<html>
  <head>
    <title>Student Welcome Email</title>
  </head>
  <body>
      <h1>
        Welcome to StudentFolder.info, {{$student->person->fullName}}!
    </h1>

    <p>If you have not done so already, we recommend that you start by entering all 
        relevant information on the Profile page!  Please note: For your safety and 
        confidentiality, we ensure that your personally identifiable data  
        (names, home address, emails, password) are stored in an encrypted format.</p>

    <p>Further, your information is only shared with the teachers and parent/guardians 
    you identify, and with the event administrators for those events in which you 
    choose to participate.</p>

    <p>If you are currently logged into StudentFolder.info, please <b>log out</b>. 
        Once logged out, 
        <a href="{{url('user/verify', [$token])}}">click this link</a> 
        to verify your primary email: {{$student->person->emailPrimary}}.</p>
    
    <p>You can then re-log in using your <b>{{$user->name}}</b> user name and Password.</p>

    <p><u>Note: No further emails can be sent until this email is verified!</u></p>

    <p>Thank you for registering with 
        <a href="{{url('index.php')}}">StudentFolder.info</a>!</p>

    <p>Best -<br />Rick Retzko<br />Founder, StudentFolder.info</p>
  </body>
</html>