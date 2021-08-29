<?php

namespace App\Http\Controllers\Videos;

use App\Http\Controllers\Controller;
use App\Registrant;
use App\User;
use App\Video;
use Videoserver;
use App\Videotype;
use Illuminate\Http\Request;


class VideoController extends Controller
{

   /**
     * API call from videoserver (e.g. SproutVideo)
     *
     * @param Request $request
     * @param Registrant $registrant
     * @param Videotype $videotype
     */
    public function apiconfirmation(Request $request, Registrant $registrant, Videotype $videotype, User $user)
    {
       $video = new Video();

        $folder_id = \App\Sv_folder::where('eventversion_id', $registrant->eventversion->id)
            ->where('instrumentation_id', $registrant->primaryAuditionVoicingId)
            ->where('videotype_id', $videotype->id)
            ->first()->id;

       if($request['successful'] === 'true'){

           $video::updateOrCreate([
               'auditionnumber' => $registrant->auditionnumber,
               'videotype_id' => $videotype->id,
               'server_id' => $request['video_id'],
               'folder_id' => $folder_id,
               'updated_by' => $user->id,
           ]);

       }

       return redirect(url('/registrant/profile/'.$registrant->eventversion->id));
    }

    public function upload(Request $request, Registrant $registrant, Videotype $videotype)
    {
        $server = new Videoserver;

        //set api key
        //SproutVideo::$api_key = config('app.sprout');
        dd($server->token);

    }
}
