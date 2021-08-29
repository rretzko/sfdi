<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <style media="screen" type="text/css" >
        body{font-size: .9rem;}
        table{margin-bottom: .5rem;}
        .label{text-align: right; margin-right: .5rem;}
        .data{font-weight: bold; width: 500px;}
        .divider{background-color: rgba(0,0,0,.1);font-size: 1.15rem;font-weight: bold;padding-left: 1rem;}
        
    </style>
        
  </head>
  <body>

      <h1 style="text-align: center; margin: 0px; padding: 0px;"> {{ $eventversion->event->name }}</h1>
      <h2 style="text-align: center; margin: 0px; padding: 0px;">{{ $eventversion->name }}</h2>
      <h3 style="text-align: center; margin: 0px; padding: 0px;">Student Audition Application</h3>
      <header id="information">
          <ul style="list-style-type: none; text-align: center;">
            <li>All students must present this form at the registration desk the day of auditions.</li>
            <li>Without this form and the proper signatures, you will not be allowed to audition.</li>
            <li>We will retain this form for students who are accepted to the Chorus.</li>
            <li>All information regarding eligibility, audition procedures, audition 
            materials, rehearsal dates, concert dates, rules and regulations, etc. 
            are available on the <a href="https://www.sites.google.com/site/allshorechorus/" target="_BLANK">All-Shore Chorus web site</a> (https://www.sites.google.com/site/allshorechorus/).</li>
          </ul>
      </header>
      
      <table>
          <tbody>
              <tr>
                  <td class="label">Student name: </td>
                  <td class="data">{{ $registrant->auditiondetail->programname }}</td>
              </tr>
              <tr>
                  <td class="label">Address:</td>
                  <td class="data">{{ $registrant->student->person->address->addressLine }}</td>
              </tr>
              <tr>
                  <td class="label">Height (in shoes):</td>
                  <td class="data">{{ $registrant->student->heightFootInches.' ('.$registrant->student->height.')' }}</td>
              </tr>
              <tr>
                  <td class="label">Home Phone:</td>
                  <td class="data">{{ $registrant->student->person->phoneHome }}</td>
              </tr>
              <tr>
                  <td class="label">Cell Phone:</td>
                  <td class="data">{{ $registrant->student->person->phoneMobile }}</td>
              </tr>
              <tr>
                  <td class="label">Email:</td>
                  <td class="data">{{ $registrant->student->person->emailPrimary }}</td>
              </tr>
          </tbody>
      </table>
      
      <section class="divider">
          Emergency Contact Information
      </section>
      
      <table>
          <tbody>
            @foreach($registrant->student->parentguardians AS $pg)
                <tr>
                    <td class="label">Parent Name:</td>
                    <td class="data">{{ $pg->person->fullName }}</td>
                </tr>
                <tr>
                    <td class="label">Parent Phone:</td>
                    <td class="data">{{ $pg->person->phoneString }}</td>
                </tr>
                <tr>
                    <td class="label">Parent Email:</td>
                    <td class="data">{{ $pg->person->emailPrimary }}</td>
                </tr>
            @endforeach
          </tbody>
      </table>
          
      <section class="divider">
          Choral Director Information
      </section>
      
      <table>
          <tbody>
              @foreach($registrant->student->teachers AS $teacher)
                <tr>
                    <td class="label">Choral Director:</td>
                    <td class="data">{{ $teacher->person->fullName }}</td>
                </tr>
                <tr>
                    <td class="label">Teacher Phones:</td>
                    <td class="data">{{ $teacher->person->phoneString }}</td>
                </tr>
                <tr>
                    <td class="label">Teacher Emails:</td>
                    <td class="data">{{ $teacher->person->emailString }}</td>
                </tr>
            @endforeach
          </tbody>
      </table>
      
      <section class="divider">
          Audition Information
      </section>
      
      <table>
          <tbody>
            <tr>
                <td class="label">Grade:</td>
                <td class="data">{{ $registrant->student->gradeClassOf }}</td>
            </tr>
            <tr>
                <td class="label">Gender:</td>
                <td class="data">{{ $registrant->student->person->genderDescr }}</td>
            </tr>
            <tr>
                <td class="label">Voice Part:</td>
                <td class="data">{{ $registrant->auditiondetail->auditionVoicingDescrString }}</td>
            </tr>
          </tbody>
      </table>
      
      <footer style="margin: 0px; padding: 0px;">
          <p style="margin: 0px; padding: 0px;">I have reviewed the following documents made available on the 
              All-Shore Chorus web site.  
              I accepted the membership regulations of the All-Shore Chorus.
          </p>
          <ul style="margin: 0px; padding: 0px; margin-left: 20px;">
              <li>Eligibility Requirements</li>
              <li>Audition Procedures and Instructions</li>
              <li>Student Membership Rules and Regulations</li>
              <li>Audition Materials</li>
              <li>Calendar</li>
              <li>Scoring Rubric</li>
          </ul>
      </footer>
      
      <table style="width: 100%; margin-top: 2rem;">
          <tr>
              <td style="width: 40%; border-bottom: 1px solid black;"></td>
              <td style="width: 20%; border-bottom: 1px solid white;"></td>
              <td style="width: 40%; border-bottom: 1px solid black;"></td>
          </tr>
          <tr>
              <td style="text-align: center;">{{ $registrant->student->person->fullName }}</td>
              <td ></td>
              <td style="text-align: center;" >Parent/Guardian Signature</td>
          </tr>
          <tr>
              <td colspan="3">&nbsp;<br />&nbsp;</td>
          </tr>
          <tr >
              <td style="width: 40%; border-bottom: 1px solid black; "></td>
              <td style="width: 20%; border-bottom: 1px solid white;"></td>
              <td style="width: 40%; border-bottom: 1px solid black;"></td>
          </tr>
          <tr >
              <td style="text-align: center;">{{ $registrant->teacherString }}</td>
              <td ></td>
              <td style="text-align: center;" >Principal Signature</td>
          </tr>
      </table>
      
  </body>
</html>
