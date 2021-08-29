<?php

namespace App\Http\Controllers;

use App\Traits\BlindIndex;
use Illuminate\Http\Request;

class DuplicateStudentRegistrationCheckController extends Controller
{
    use BlindIndex;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $a = [];
        $this->sendEmail($request);

        /**
         * @todo build additional functionality to test against first_name, last_name
         * This will require building a searchable hash table for all of the names in the database
         * to check against because names are currently encrypted
         * ex: user_id: ###, hash: firstnamelastname
         */

        $a['res'] = $this->findEmail($request['email']);

        echo json_encode($a);
    }

    private function findEmail($email)
    {
        $bi = $this->BlindIndex($email);

        return \App\Email::where('blind_index', '=', $bi)->first()->id ?? 0;
    }

    private function sendEmail(Request $request)
    {
        $to = 'rick@mfrholdings.com';
        $sb = __CLASS__;
        $bd = 'Checking: '.$request['first_name'].' '.$request['last_name'].' @ '.$request['email'];

        error_log('*** FJR: info: '.$bd.' ***');
        mail($to, $sb, $bd);
    }

}
