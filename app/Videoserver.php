<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use SproutVideo;
/**
 * Generic but original design is for SproutVideo
 */
class Videoserver extends Model
{
    public $registrant;
    public $videotype;

    public function __construct(){
        
        parent::__construct();
        
        SproutVideo::$api_key = config('app.sprout');       
        $this->registrant = new Registrant;
        $this->videotype = new Videotype;
        
    }
    
    public function api_Key()
    {
        return config('app.sprout');
    }
    
    public function assets($video_id)
    {
        $assets = SproutVideo\Video::get_video($video_id);
        
        return $assets;
    }
    
    public function set_Registrant(\App\Registrant $registrant)
    {
        $this->registrant = $registrant;
    }
    
    public function set_Videotype(\App\Videotype $videotype)
    {
        $this->videotype = $videotype;
    }
    
    /**
     * create video token or log error message
     * 
     * @return string
     */
    public function token(Videotype $videotype) : string
    {
        $token = \SproutVideo\UploadToken::create_upload_token([
            'return_url' => 'https://studentfolder.info/videoserver/confirmation/'
            . $this->registrant->auditionnumber.'/'.$videotype->id.'/'.auth()->user()->id
            ]);
        
        if(array_key_exists('token', $token)){
        
                return $token['token'];
    
        }else{
            
            error_log('FJR:'.date('Y-m-d G:i:s').': SproutVideo token error: '.serialize($token));
            
            return '***00000***';
        }
        
    }
    
/** END OF PUBLIC FUNCTIONS ***************************************************/

    
}
