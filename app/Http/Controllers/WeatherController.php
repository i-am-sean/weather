<?php

namespace App\Http\Controllers;

use App\Services\DateCreatorService;

class WeatherController extends Controller
{
  //Display the index page and add start dates to buttons
  public function getIndex()
  {
      //Get Mondays date for the week filter
      $monday = DateCreatorService::getMonday();

      return \View::make('index', array(
        'today' => date('Y-m-d'),
        'monday' => $monday,
        'first' => date('Y-m-'.'01')
      ));
  }
}
