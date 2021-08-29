<!DOCTYPE html>
<html>
  <head>
    <title>Student Welcome Email</title>
  </head>
  <body>
    <h2>Welcome to StudentFolder.info, {{$person->fullName}}!</h2>
    <br/>
    <p>Listed below, you'll find the information we have stored in the system.</p>
    <p>Please note that <u>all</u> personally identifiable information is 
    stored in encrypted format for your safety and protection.  This includes 
    your names, emails, phones, home address, and password.</p>
    <p>You may update your personal information at any time by logging into 
        <a href="https://StudentFolder.info">StudentFolder.info</a> 
        and clicking the 'Profile' link.</p>
    <p>You're current information is:
    <ul>
        <li>Username: {{$user->name}}</li>
        <li>Primary Email: {{$person->emailPrimary}}</li>
        <li>Password: Passwords have one-way encryption and cannot be shared.</li>
    </ul>
    <p>Thank you for registering with StudentFolder.info!</p>
    <p>Best - <br />
        Rick Retzko<br />
        <i>Founder, StudentFolder.info</i>
    </p>
  </body>
</html>
