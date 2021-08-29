<?php

namespace App\Http\Controllers;

use App\Person;
use App\Traits\BlindIndex;
use Illuminate\Http\Request;

class PersonsController extends Controller
{
    use BlindIndex;
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Person $person
     * @return \Illuminate\Http\Response
     */
    public function show(Person $person)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Person $person
     * @return \Illuminate\Http\Response
     */
    public function edit(Person $person)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\People  $person
     * @return \Illuminate\Http\Response
     */
    public function update(\App\Http\Requests\PersonStoreRequest $request, Person $person)
    {
        $person->first_name = request('first_name');
        $person->middle_name = request('middle_name');
        $person->last_name = request('last_name');
        $person->pronoun_id = request('pronoun_id');
        $person->save();

        //EMAILS
        $alt = (request('alternate_family')) ? true : false; //alternate_family checkbox
        $pri = (request('primary_family')) ? true : false;  //primary_family checkbox
        self::update_Emails($person, request('emails'), $alt, $pri);
     
        //PHONES
        self::update_Phones($person, request('phones'));
        
        return redirect('profile')->with('message-persons', 'Successful update!');
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Person $person
     * @return \Illuminate\Http\Response
     */
    public function destroy(Person $person)
    {
        //
    }
    
    private function update_Emails(Person $person, array $emails, 
            bool $alternate_family, bool $primary_family)
    {
        $types = ['primary', 'alternate'];
      
        for($i=0; $i<count($emails); $i++){
            $email = \App\Email::firstOrNew([
                        'user_id' => $person->user_id,
                        'type' => $types[$i],
                    ]);
            $email->email = $emails[$i];
            $email->blind_index = self::BlindIndex($emails[$i]);//self::update_Emails_Set_Blind_Index($emails[$i]);
            $email->save();
            
            self::update_Emails_Family($email, $types, $i, $alternate_family, 
                    $primary_family);

        }
    }
    
    private function update_Emails_Family(\App\Email $email, array $types, 
            int $ndx, bool $alternate_family, bool $primary_family)
    {
        $ef = \App\EmailFamily::firstOrNew([
                        'email_id' => $email->id,
                ]);

        if(
                (($types[$ndx] === 'primary') && $primary_family)
                ||
                (($types[$ndx] === 'alternate') && $alternate_family)
           
        ){
            //ensure checkbox is aligned with an email value
            if(strlen($email->email)){
                $ef->save();
            }
            
        }else{
             
            $ef->delete();
        }
    }
    
    private function update_Phones(Person $person, array $phones)
    {
        $types = ['mobile', 'home', 'work'];
        
        for($i=0; $i<count($phones); $i++){
            $phone = \App\Phone::firstOrNew([
                        'user_id' => $person->user_id,
                        'type' => $types[$i]
                    ]);
            $phone->phone = $phones[$i];
            $phone->save();
        }
    }
}
