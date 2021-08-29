<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = [
        'auditionnumber',
        'videotype_id',
        'server_id',
        'folder_id',
        'updated_by',
    ];

    protected $guarded = [];

    public function getVideotypeDescrAttribute()
    {
        $vt = Videotype::find($this->videotype_id);

        return $vt->descr;
    }

    public function registrant()
    {
        return $this->belongsTo(Registrant::class, 'auditionnumber', 'auditionnumber');
    }

    /**
     * Retain database record but append '-' to server_id and '99' to videotype_id
     * in case these need to be reversed.
     *
     * NOT using 'Soft Delete' until testing can prove that unique-key constraints
     * on auditionnumber+videotype_id are not impacted
     *
     * @todo Uncomment the section below to actually process the rejection
     */
    public function reject()
    {
        $st = new Statustype;
        $st_id = $st->get_Id_From_Descr('rejected');

        $this->update([
            'server_id' => '-'.$this->server_id,
            'videotype_id' => '99'.$this->videotype_id,
            'statustype_id' => $st_id,
            'approved' => NULL,
            'updated_by' => auth()->user()->id,
        ]);
    }

    /**
     * Retain database record but
     *  - prefix '-' to server_id and
     *  - prefix '99' to videotype_id
     *  - update statustype to studentremoval
     * in case these need to be reversed.
     *
     * NOT using 'Soft Delete' until testing can prove that unique-key constraints
     * on auditionnumber+videotype_id are not impacted
     */
    public function studentRemoval()
    {
        $st = new Statustype;
        $st_id = $st->get_Id_From_Descr('studentremoval');

        return $this->update([
            'server_id' => '-'.$this->server_id,
            'videotype_id' => '98'.$this->videotype_id,
            'statustype_id' => $st_id,
            'approved' => NULL,
            'updated_by' => auth()->user()->id,
        ]);

    }

    /**
     * Determine if the status value being returned from videoserver evaluates to a
     * successful upload
     *
     * @param mixed $statusvalue string or boolean
     * @return bool
     */
    public function successful_Upload($statusvalue) : bool
    {
        $successes = ['successful', 'true'];

        return (in_array($statusvalue, $successes));
    }
}
