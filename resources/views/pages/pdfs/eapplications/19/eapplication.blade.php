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
      <style>
          .page-break{page-break-before: always;}
      </style>

  </head>
  <body>

      <h1 style="text-align: center; margin: 0px; padding: 0px;"> {{ $eventversion->event->name }}</h1>
      <h2 style="text-align: center; margin: 0px; padding: 0px;">{{ $eventversion->name }}</h2>
      <h3 style="text-align: center; margin: 0px; padding: 0px;">Student Audition eApplication</h3>

      <table>
          <tbody>
              <tr>
                  <td class="label">Email:</td>
                  <td class="data">{{ $registrant->student->person->emailPrimary }}</td>
              </tr>
              <tr>
                  <td class="label">Student name: </td>
                  <td class="data">{{ $registrant->auditiondetail->programname }}</td>
              </tr>
              <tr>
                  <td class="label">School:</td>
                  <td class="data">{{ $registrant->student->schools->first()->name }}</td>
              </tr>
              <tr>
                  <td class="label">Teacher:</td>
                  <td class="data">{{ $registrant->student->teachers->first()->person->fullName }}</td>
              </tr>
              <tr>
                  <td class="label">Voice Part:</td>
                  <td class="data">{{ $registrant->primaryAuditionVoicingDescription }}</td>
              </tr>

          </tbody>
      </table>

      <section>
          <h3>Elibility Requirements</h3>
          <div>
              Please read through the 2021 New Jersey All-Shore Chorus Eligibility Requirements by clicking here!
          </div>
          <style>
              table{width: 95%;}
              table tr td.chkbx{min-width: 5%; }
              table tr td.chkbx_label{min-width: 95%;}
              table.signature_table{border: 1px solid black; width:25%;}
          </style>
          <table>
              <tr>
                  <td class="chkbx"><input type="checkbox"  checked aria-checked="true"/></td>
                  <td class="chkbx_label">I have read them.</td>
              </tr>
          </table>

      </section>

      <section>
          <h3>Student Rules and Regulations</h3>
          <div>
              Please read through the 2021 New Jersey All-Shore Chorus Student Rules and Regulations by clicking here.
          </div>
          <table>
              <tr>
                  <td class="chkbx"><input type="checkbox"  checked aria-checked="true"/></td>
                  <td class="chkbx_label">I have read them carefully.</td>
              </tr>
          </table>
      </section>

      <section>
          <h3>Use of your image</h3>
          <div>
              I understand that my photograph may be taken during rehearsal or performance, and possibly posted on the 2021 New Jersey All-Shore Chorus social media account.
          </div>
          <table>
              <tr>
                  <td class="chkbx"><input type="checkbox"  checked aria-checked="true"/></td>
                  <td class="chkbx_label">I have read them carefully.</td>
              </tr>
          </table>
      </section>

      <section>
          <h3>Absences</h3>
          <div>
              <p>While reading these documents, I took note of the fact that all members are allowed two absences. If a student is absent a 3rd time, they are automatically dismissed from the chorus.</p>
              <p><i>There is one exception. If a student in 12th grade can provide documentation of a music college audition, a 3rd absence will be allowed upon review of the 2021 New Jersey All-Shore Chorus committee.</i></p>
          </div>
          <table>
              <tr>
                  <td class="chkbx"><input type="checkbox"  checked aria-checked="true"/></td>
                  <td class="chkbx_label">I understand and agree.</td>
              </tr>
          </table>
      </section>

      <section>
          <h3>Lates</h3>
          <div>
              <p>I took note of the fact that any 3 "lates" to a rehearsal will count as one absence.</p>
              <p><i>And yes, one minute late is considered late.</i></p>
          </div>
          <table>
              <tr>
                  <td class="chkbx"><input type="checkbox"  checked aria-checked="true"/></td>
                  <td class="chkbx_label">I understand and agree.</td>
              </tr>
          </table>
      </section>

      <div class="page-break" style="padding: 1rem;"></div>

      <section>
          <h3>Dress Rehearsal</h3>
          <div>
              <p>I am aware that attendance at the Friday Dress Rehearsal is mandatory. No exceptions. If I miss the dress rehearsal, I will be automatically dismissed from the chorus.</p>
          </div>
          <table>
              <tr>
                  <td class="chkbx"><input type="checkbox"  checked aria-checked="true"/></td>
                  <td class="chkbx_label">I understand and agree.</td>
              </tr>
          </table>
      </section>

      <section>
          <h3>Student Signature</h3>
          <div>
              <p>STUDENT: By typing my name below, I understand and agree that this form of electronic signature has the same legal force and affect as a manual signature.</p>
          </div>
          <table class="signature_table">
              <tr>
                  <td class="signature_box">Student Signature</td>
              </tr>
          </table>
      </section>

      <section>
          <h3>Parent Agreement</h3>
          <div>
              <p>Please go find your parent/guardian, and have them read through this form. Then, continue.</p>
          </div>
          <table>
              <tr>
                  <td class="chkbx"><input type="checkbox"  checked aria-checked="true"/></td>
                  <td class="chkbx_label">My parents have read this form.</td>
              </tr>
          </table>
      </section>

      <section>
          <h3>Parent Signature</h3>
          <div>
              <p>PARENT/GUARDIAN: By typing my name below, I understand and agree that this form of electronic signature has the same legal force and affect as a manual signature.</p>
          </div>
          <table class="signature_table">
              <tr>
                  <td class="signature_box">Parent Signature</td>
              </tr>
          </table>
      </section>

      <section>
          <h3>Courtesy and Respect</h3>
          <div>
              <p>Finally, I understand that all teachers involved are volunteers, dedicating their time and effort to provide you with this musical experience. I, and my family, will communicate in a courteous and respectful manner at all times.</p>
          </div>
          <table>
              <tr>
                  <td class="chkbx"><input type="checkbox"  checked aria-checked="true"/></td>
                  <td class="chkbx_label">I understand and agree to this and everything above.</td>
              </tr>
          </table>
      </section>

      <div class="page-break" style="padding: 1rem;">
          <h3>Eligibility Requirements</h3>
            @include('partials.19.61.eligibilityrequirements')
            <div>Please see: https://www.allshorechorusnj.com/copy-of-learning-materials</div>

          <h3>AuditionProcedures and Instructions</h3>
            <div>Please see: https://www.allshorechorusnj.com/auditions</div>
      </div>

      <div class="page-break" style="padding: 1rem;">
          <h3>Student Membership Rules and Regulations</h3>
            @include('partials.19.61.studentmembershiprulesandregulations')
            <div>Also found at: https://www.allshorechorusnj.com/copy-of-eligibility-requirements</div>

          <h3>Audition Materials</h3>
            <div>Please see: https://www.allshorechorusnj.com/auditions</div>

          <h3>Calendar</h3>
            <div>Please see: https://7bb73dec-57da-455f-9d14-878a7b3f8615.filesusr.com/ugd/c8c44d_e0b6e889705241558478e589bc0afdba.pdf</div>

          <h3>Scoring Rubric</h3>
            <div>Please see: https://docs.google.com/file/d/0B5AZkZ__M-wkWFRkUktWakFDY2M/edit</div>
      </div>

  </body>
</html>
