<!-- resources/views/emails/registrantpayments.blade.php -->
<p>Hi {{$teacher->person->first_name}}</p>
<p>A new registrant payment has been logged into StudentFolder.info.  
    Please see the table below for your list of students who are in the system 
    as having completed some portion of their payments due.</p>
<p>
<style>
    table{border-collapse: collapse;}
    th,td{border: 1px solid black; padding: 0 8px; text-align: center;}
</style>
<table style="border: 1px solid black;">
    <thead>
        <tr>
            <th>Student</th>
            <th>Payment</th>
            <th>Type</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($registrant->eventversion->registrantPayments($school) AS $payment)
            <tr>
                <td class="text-left">
                    {{ $payment->person->fullName }}
                </td>
                <td>{{ number_format($payment->amount,2) }}</td>
                <td>{{ $payment->paymenttype_Descr() }}</td>
                <td>{{ $payment->updated_at }}</td>
            </tr>
        @endforeach 
    </tbody>
</table>
</p>
<p>Best -<br />Rick Retzko<br />Founder, TheDirectorsRoom.com</p>