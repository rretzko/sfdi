<?php

namespace App\Http\Controllers;

use App\Eventversion;
use App\Eventversionteacherconfig;
use App\Registrant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Student;
use App\Person;
use App\Table_Events;

class EventsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        self::nav_Links();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $student = Student::find(auth()->user()->id);

        /**
         * workaround to produce $teacher_allows_paypal_participation_fee_payments
         * for MAHC eventversion 73
         */
        $teacher_allows_paypal_participation_fee_payments = $this->teacherAllowsPaypalParticipationFeePayments($student);

        return view('pages.events.roster', [
            'eventversions' => $student->eventversionsOpen(),
            'teacher_allows_paypal_participation_fee_payments' => $teacher_allows_paypal_participation_fee_payments,
        ]);
    }

/** END OF PUBLIC METHODS *****************************************************/

    /**
     * Build arguments list for view
     *
     * @return array
     */
    private function arguments() : array
    {
        $user = Auth::user();
        $user_id = $user->id;

        $student = (Student::find($user_id))
                ? Student::find($user_id)
                : Student::create(['user_id' => $user_id, 'class_of' => (date('Y') + 3)]);

        $table_events = new Table_Events($student);

        return [
                'user' => $user,
                'student' => $student,
                'table_events' => $table_events->table(),
                'person' => Person::firstOrCreate(['user_id' => $user_id]),
                'nav_links' => $this->nav_links,
                ];

    }

    /**
     * Initialize $this->nav_links array
     */
    private function nav_Links()
    {
        $this->nav_links = [
            'credentials' => '',
            'event' => 'active',
            'parent' => '',
            'profile' => '',
            'school' => '',
            'student' => '',
        ];
    }

    /**
     * Workaround to provide coverage for MAHC 2022 participation fee functionality
     * @param Student $student
     * @return bool
     */
    private function teacherAllowsPaypalParticipationFeePayments(Student $student): bool
    {
        $eventversion_id = 73; //MAHC event
        $found = false;
        $registrant = Registrant::where('user_id', $student->user_id)
            ->where('eventversion_id', $eventversion_id)
            ->first();

        //early exit
        if(! $registrant){ return false;}

        $teacher_configs = Eventversionteacherconfig::where('user_id', $registrant->teacher_user_id)
            ->where('eventversion_id', $registrant->eventversion_id)
            ->where('school_id', $registrant->school_id)
            ->first();

        return $teacher_configs ? $teacher_configs->paypal_participation_fee : 0;
    }

}
