<?php

namespace App\Services;

use Goutte\Client,
    App\Models\Temperature;

/**
* A service which crawls accuweather
* and writes the temperature to the db
**/
class CrawlerService
{
    //Connect to a link and return the temp
    public function getTemperature()
    {
        $degress = NULL;
        $link = 'http://www.accuweather.com/en/za/cape-town/306633/weather-forecast/306633';

        //Create instance of Goutte client
        $client = new Client();
        // Go to the provided link
        $crawler = $client->request('GET', $link);
        // Get the temp from the main feed div

        $degress = $crawler->filter('#feed-main > .info > .temp')->each(function ($node) {
          //Strip out anything non-numeric
          return preg_replace('/[^0-9]/', '', $node->text());
          });

          //Make sure we have a value
          if(!is_null($degress) && isset($degress[0])){
            //Save to the DB
            $newTemperature = Temperature::create(['temperature' => $degress[0]]);
          }
    }
}
