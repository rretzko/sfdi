<!-- resources/views/emails/newstudent.blade.php -->
<html>
  <head>
    <title>Parent Welcome Email</title>
  </head>
  <body>
    <p>Welcome to StudentFolder.info, {{$parent->fullName}}!</p>
    <p>You are receiving this email because your child, {{$student->person->fullName}} has registered with <a href="{{url('')}}">StudentFolder.info</a>.</p>
    <p>StudentFolder.info is a site utilized by students of teachers who are active in group musical events such as All-State and Region Band, Chorus and Orchestras.</p>
    <p>In accordance with <a href="https://www.ftc.gov/enforcement/statutes/childrens-online-privacy-protection-act">COPPA</a> regulations, we want to make you aware of your child's registration on our site.</p>
    <p>Your child's personally identifiable information is stored in encrypted format for their privacy and protection.  Further, that information is ONLY shared with the child's teacher(s) and the administrators for any events in which they register.  Typically, administrators will use this information to monitor attendance, maintain discipline and ensure proper spelling in published programs.</p>
    <p>You may access this site yourself by using your child's user name (<b>{{$user->name}}</b>) and their self-set password.  We do not have access to your child's password.</p>
    <p>If you would wish to limit the use your child's information, please contact their teacher(s).  Teacher names can be found on the site by logging in and then clicking the "Schools" link.</p>
    <p>Best -<br />Rick Retzko<br />Founder, StudentFolder.info</p>
  </body>
</html>

