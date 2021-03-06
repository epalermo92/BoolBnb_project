<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
  protected $fillable =['title', 'description','rooms','beds','bathrooms','square_meters','address','lat','lon','user_id'];

  function services(){

    return $this->belongsToMany(Service::class)->withTimestamps();
  }

  function user(){

    return $this->belongsTo(User::class);
  }

  public function sponsors(){

    return $this->belongsToMany(Sponsor::class)->withTimestamps()->withPivot('end_date');
  }


  function messages(){

    return $this->hasMany(Message::class);
  }

  public function views(){
    return $this->hasMany(RentalViews::class);
  }

  //Controlla se il servizio in ingresso fa parte dei servizi del rental

  public function isService($serviceId){


    foreach ($this->services as $service) {

      if($service->id == $serviceId){

        return true;
      }

    }

    return false;
  }

  // scope per i rental sponsorizzati al momento
  // confronta a end_date con la data attuale

  public function scopeSponsored($query)
  {

    $pivot = $this->sponsors()->getTable();
    $currentDate = date('Y-m-d H:i');
    return $query->whereHas('sponsors', function ($query) use($pivot,$currentDate){
      $query->where("{$pivot}.end_date", '>', $currentDate);

    });

  }

  // scope per i rental non sponsorizzati

  public function scopeNotSponsored($query)
  {

    $pivot = $this->sponsors()->getTable();
    $currentDate = date('Y-m-d H:i');
    return $query->whereDoesntHave('sponsors')
                 ->orwhereDoesntHave('sponsors', function ($query) use($pivot,$currentDate){
       $query->where("{$pivot}.end_date", '>', $currentDate);

     });

  }

  // Ritorna true se il rental è attualmente sponsorizzato

  function isSponsored(){

    if(count($this->sponsors) == 0){

      return false;
    }
    else{

      $sponsor = $this->sponsors->last();

      $endDate = $sponsor->pivot->end_date;
      $currentDate = date('Y-m-d H:i:s');

      if(strtotime($endDate) > strtotime($currentDate)){

        return true;
      }
      else{
        return false;
      }

    }
  }

  //Scope dei rental che si trovano nel radius  del punto rappresentato da latitude e longitude

  public function ScopeDistance($query,$latitude,$longitude,$radius)
  {

    return $query->select('rentals.*')
        ->selectRaw('( 6371 * acos( cos( radians(?) ) *
                           cos( radians( lat ) )
                           * cos( radians( lon ) - radians(?)
                           ) + sin( radians(?) ) *
                           sin( radians( lat ) ) )
                         ) AS distance', [$latitude, $longitude, $latitude])
        ->orderBy( 'distance', 'ASC' )
        ->havingRaw("distance < ?", [$radius]);
  }
}
