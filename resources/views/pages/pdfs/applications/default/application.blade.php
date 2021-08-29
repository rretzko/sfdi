<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    Application: Default<br />
    Event: {{ $eventversion->name }}<br />
    Registrant: {{$registrant->auditiondetail->programname}}<br />
    Status Description: {{ $registrant->statusDescr }}
  </body>
</html>
