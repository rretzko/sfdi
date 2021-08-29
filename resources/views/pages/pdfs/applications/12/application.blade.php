<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <style>
        table{width: 96%;}
        thead{background-color: lightgrey;  }
        .section_Header{text-align: left; padding-left: 1rem; text-transform: uppercase;}
        .label{width: 20%; padding: 0 .5rem; text-align: right;}
        .data{width:75%; padding: 0 .5rem; text-align: left; font-weight: bold;}
    </style>
    <title></title>
  </head>
  <body style="border: 1px solid black; padding: 1rem; ">
      <h1 style="font-size: 1.5rem; text-align: center;">
          SOUTH JERSEY JR. & SR. HIGH CHORUS APPLICATION
      </h1>
      <h2 style="text-align: center;">{{ $eventversion->name }}</h2>
      <p style="font-size: .8rem; text-align: center;">All signatures must be written clearly in ink and every category must 
      be filled or the student will not be permitted to audition.</p>
      
      <!-- BIOGRAPHY -->
      <section id="bio" style="display: flex; flex-direction: row;">
          
          <table>
              <thead>
                  <tr>
                      <th colspan="2" class="section_Header">Biography</th>
                  </tr>
              </thead>
              <tbody>
                  <tr>
                      <td class="label">Student Name:</td>
                      <td class="data">{{ $registrant->auditiondetail->programname }}</td>
                  </tr>
                  <tr>
                      <td class="label">Address:</td>
                      <td class="data">{{ $registrant->student->person->address->addressLine }}</td>
                  </tr>
                  <tr>
                      <td class="label">Height (in shoes):</td>
                      <td class="data">{{ $registrant->student->height }} ({{ $registrant->student->heightFootInches }})</td>
                  </tr>
                  <tr><!-- spacer -->
                      <td colspan="2"></td>
                  </tr>
                  <tr>
                      <td class="label">Phones:</td>
                      <td class="data">{{ $registrant->student->person->phoneString }}</td>
                  </tr>
                  
                  <tr><!-- spacer -->
                      <td colspan="2"></td>
                  </tr>
                  <tr>
                      <td class="label">Emails:</td>
                      <td class="data">{{ $registrant->student->person->emailString }}</td>
                  </tr>
                  
              </tbody>
          </table>
      </section>
      
      <!-- EMERGENCY CONTACT INFORMATION -->
      <section id="ice" style="display: flex; flex-direction: row;">
          
          <table>
              <thead>
                  <tr>
                      <th colspan="2" class="section_Header">Emergency Contact Information</th>
                  </tr>
              </thead>
              <tbody>
                  @foreach($registrant->student->parentguardians AS $pg)
                    <tr>
                        <td class="label">Parent Name:</td>
                        <td class="data">{{ $pg->person->fullName }}</td>
                    </tr>
                    <tr>
                        <td class="label">Parent Phones:</td>
                        <td class="data">{{ $pg->person->phoneString }}</td>
                    </tr>
                    <tr>
                        <td class="label">Parent Emails:</td>
                        <td class="data">{{ $pg->person->emailString }}</td>
                    </tr>
                    
                @endforeach
              </tbody>
          </table>
      </section>
      
      <!-- CHORAL DIRECTOR INFORMATION -->
      <section id="ice" style="display: flex; flex-direction: row;">
          
          <table>
              <thead>
                  <tr>
                      <th colspan="2" class="section_Header">Choral Director Information</th>
                  </tr>
              </thead>
              <tbody>
                <tr>
                    <td class="label">Choral Director:</td>
                    <td class="data">{{ $teacher->person->fullName }}</td>
                </tr>
                <tr>
                    <td class="label">School Phone:</td>
                    <td class="data">{{ $teacher->person->phoneWork }} (w)</td>
                </tr>
                <tr>
                    <td class="label">Director Email:</td>
                    <td class="data">{{ $teacher->person->emailPrimary }}</td>
                </tr>
                
              </tbody>
          </table>
      </section>
      
      <!-- AUDITION INFORMATION -->
      <section id="ice" style="display: flex; flex-direction: row; margin-bottom: .5rem;">
          
          <table>
              <thead>
                  <tr>
                      <th colspan="2" class="section_Header">Audition Information</th>
                  </tr>
              </thead>
              <tbody>
                <tr>
                    <td class="label">Grade:</td>
                    <td class="data">{{ $registrant->student->gradeClassOf }}</td>
                </tr>
                <tr>
                    <td class="label">Pronoun:</td>
                    <td class="data">{{ $registrant->student->person->pronounDescr }}</td>
                </tr>
                <tr>
                    <td class="label">Voice Part:</td>
                    <td class="data">{{ $registrant->auditiondetail->auditionVoicingDescrString }}</td>
                </tr>
                
              </tbody>
          </table>
      </section>
      
      <section id="contract" style="border-top: 1px solid darkgrey;margin-bottom: .5rem; border-bottom: 1px solid darkgrey; font-size: .75rem;">
          We, the undersigned, recommend <b>{{ $registrant->auditiondetail->programname }}</b> 
          to audition for the <b>{{ $eventversion->name }}</b>.  <b>{{ $registrant->student->person->first_name }}</b> 
          is currently a faithful member of our school vocal music performing 
          organization. <b>{{ $registrant->student->person->first_name }}</b> is 
          aware of the fact that {{ $registrant->student->person->pronoun->personal }} 
          must remain an active member in good standing of the school performing 
          group throughout {{ $registrant->student->person->pronoun->possessive }}
          South Jersey experience.  {{ ucwords($registrant->student->person->pronoun->personal) }} 
          is a qualified student, and is now enrolled in Grade {{ $registrant->student->gradeClassOf }} 
          at <b>{{ $school ?? ''->name }}</b>.  In the event that <b>{{ $registrant->student->person->first_name }}</b> 
          is accepted for membership in this chorus, we will use our influence 
          to see that {{ $registrant->student->person->pronoun->personal }} is 
          property prepared, and that all whose signatures appear on this 
          application will adhere to the Rules and Regulations of the South 
          Jersey Chorus.  We agree to the stated attendance policy and all 
          relevant policies stated in the SJCDA Choral auditions packet.  
          Students will be removed from the chorus at any time if a jury of 
          choral directors selected by the Festival Coordinator determines the 
          student cannot capably perform their music, or if the student fails to 
          meet the requirements outlined in this packet.
      </section>
      
      <section id="advisory" style="text-transform: uppercase; text-align: center;">
          <div style="">All signatures must be original</div>
          <div>No signature stamps or photocopied signatures are allowed</div>
      </section>
      
      <style>
          #signatures
          {
              padding: 0 1%;
              text-align: center;
          }
          #signatures table tbody tr td.gutter
          {
              width: 8%;
          }
          #signatures table tbody tr td.signator
          {
              text-align: center;
              width: 40%;
          }
          #signatures table tbody tr td.signature_line
          {
              border-bottom: 1px solid black;
              height: 2.5rem;
          }
      </style>
      <section id="signatures">
          <table >
              <tbody>
                  <tr>
                      <td class="signature_line"></td>
                      <td class="gutter"></td>
                      <td class="signature_line"></td>
                  </tr>
                  <tr>
                      <td class="signator">Principal Signature</td>
                      <td class="gutter"></td>
                      <td class="signator">{{ $teacher->person->fullName }} Signature</td>
                  </tr>
                  <tr>
                      <td class="signature_line"></td>
                      <td class="gutter"></td>
                      <td class="signature_line"></td>
                  </tr>
                  <tr>
                      <td class="signator">{{ $registrant->student->parentguardians[0]->person->fullName }} Signature</td>
                      <td class="gutter"></td>
                      <td class="signator">{{ $registrant->student->person->fullName }} Signature</td>
                  </tr>
                  
                  <tr>
                      <td colspan="2" style="text-align: left; height: 4rem;">{{ $school ?? ''->name }}</td>
                      <td style="text-align: right;">Audition #: _________________</td>
                  </tr>
              </tbody>
          </table>
          </div>
              
          </div>
      </section>
  </body>
</html>

