<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Options_Teachers;
use App\School;

class AjaxController extends Controller
{
    public function logStudentPayment(Request $request)
    {
        /** @since 2021.01.14 */
            error_log('*** FJR: '.__CLASS__.': '.__FUNCTION__.': '.__LINE__.': '.$request['auditionnumber']);
            mail('rick@mfrholdings.com','SJCDA PayPal Payment', 'aud nbr: '.$request['auditionnumber']);

        $registrant = \App\Registrant::find($request['auditionnumber']);

        $payment = \App\Payment::create([
            'eventversion_id' => $registrant->eventversion->id,
            'paymenttype_id' => \App\Paymenttype::getId('paypal'),
            'school_id' => $registrant->school_id,
            'user_id' => auth()->id(),
            'vendor_id' => $request['vendor_id'],
            'amount' => $request['amount'],
            'updated_by' => auth()->id(),
            'created_at' => now(),
        ]);
        $payment->save();

        //Build Invoice structure
        $invoice = '<h4>Payments</h4>';
        $invoice .= '<table class="text-right" style="background-color: rgba(0,255,0,.1);">';
        $invoice .= '<tbody>
                        <tr>
                            <td>Amount Due</td>
                            <th class="pl-3">$'.number_format($registrant->eventversion->eventversionconfig->registrationfee, 2).'</th>'
                        .'</tr>
                        <tr>
                            <td>Amount Paid</td>
                            <th class="pl-3">$'.number_format($registrant->paid(), 2).'</th>'
                        .'</tr>
                        <tr>
                            <td>Amount Due</td>
                            <th class="pl-3">';
        $invoice .= (strstr($registrant->due(), '-')) ? 'Overpayment ' : '';
        $invoice .= '$'.number_format($registrant->due(), 2).'</th>'
                        .'</tr>
                    </tbody>';
        $invoice .= '</table>';

        event(new \App\Events\RegistrantPaymentEvent($registrant));

        return response()->json(['invoice' => $invoice], 200);
    }

    public function updateOptionsTeachers(Request $request)
    {
        $a = [];
        $data = $request->all();

        if(array_key_exists('school_id', $data) &&
                ctype_digit($data['school_id'])){

            $options = new Options_Teachers(['school' =>
                School::where('id', $data['school_id'])->first()]);

            $a['test'] = $options->options();
        }

        echo json_encode($a);
    }

    /**
     * Video removal by a student allowing a new video needs to be uploaded.
     *
     * @param Request $request
     * @return type
     */
    public function videoRemoval(Request $request)
    {
        $video = \App\Video::where('server_id', $request['server_id'])
                ->first();

        if(! is_null($video->approved)){ //teacher has approved the video

            $st_id = 0;
            $res = 'denied';
        }else{

            $st_id = $video->studentRemoval();
            $res = 'removed';
        }

        return response()->json(['server_id' => $request['server_id'],
            'video_id' => $video->id,
            'res' => $res,
            'st_id' => $st_id], 200);
    }
}
