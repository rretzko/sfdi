<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    Event: {{ $eventversion->name }}<br />
    Registrant: {{$registrant->auditiondetail->programname}}<br />
    Status Description: {{ $registrant->statusDescr }}
  </body>
</html>
