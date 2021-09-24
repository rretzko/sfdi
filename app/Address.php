<?php

namespace App;

use App\Traits\Encryptable;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use Encryptable;

    protected $primaryKey = 'user_id';
    protected $encryptable = ['address01', 'address02', 'city', 'postalcode'];
    protected $fillable = ['address01', 'address02', 'city', 'geostate_id', 'postalcode','user_id'];

    public function geoState(){

            return $this->hasOne(Geostate::class);
    }

    /**
     * @since 2020.08.11
     *
     * @return string = address in a single line of data
     */
    public function getAddressLineAttribute()
    {
        $parts = ['address_01', 'address_02', 'city', 'geoStateAbbr', 'postal_code'];
        $address = [];

        foreach($parts AS $part){

            $separator = in_array($part, ['city', 'geostatedescr'])
                    ? ', '
                    : ' ';

            if(strlen($this->$part)){

                $address[] = $this->$part.$separator;
            }
        }

        return implode('', $address);
    }

    public function getGeoStateAbbrAttribute()
    {
        $g = Geostate::find($this->geostate_id);

        return $g->abbr;
    }

    public function person()
    {
        return belongsTo(Person::class, 'user_id', 'user_id');
    }

    /**
     * Original implementation created null rows for newly registered users
     * Null values created encryption problem when decrypting null value
     * @param $user_id
     */
    public function resolveNullAddressFields($user_id)
    {
        $address = $this->where('user_id', $user_id)->first();

        if($user_id && is_null($address)){
            Address::create([
                'user_id' => $user_id,
                'address01' => '',
                'address02' => '',
                'city' => '',
                'geostate_id' => 37,
                'postalcode' => '',
            ]);
        }

    }

}
