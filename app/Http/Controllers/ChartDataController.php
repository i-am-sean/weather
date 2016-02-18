<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Temperature;

class ChartDataController extends Controller
{
    private $finalArray = array();
    private $builtArray = array();
    private $comparison = false;

    //Build the data required for charts
  public function getData(Request $request)
  {
      //Only respond to ajax requests
    if ($request->ajax()) {
        $startDateArray = explode('_', $request->startDate);
        $startDate = $startDateArray[0];
        $today = date('Y-m-d');

        if (isset($startDateArray[1])) {
            $this->comparison = true;
        }

        //Get the data
        if (!$this->comparison) {
            $temperatures = Temperature::where('created_at', '>=', $startDate)
            ->where('created_at', '<=', $today.' 23:59:59')
            ->get();
        } else {
            $temperatures = Temperature::where('created_at', '>=', $startDate)
          ->where('created_at', '<=', $startDate.' 23:59:59')
          ->orWhere('created_at', '>=', $startDateArray[1])
          ->where('created_at', '<=', $startDateArray[1].' 23:59:59')
          ->get();
        }

        $dataArray = array();

        if ($today == $startDate || $this->comparison) {
            //We need to split the data by time
            $format = 'Y-m-d H:i:s';
        } else {
            //We split the data by date
            $format = 'Y-m-d';
        }
        //Loop through results and build array with temps as array values and dates as keys
        foreach ($temperatures as $tempRecord) {
            if (!isset($dataArray[$tempRecord->created_at->format($format)])) {
                $dataArray[$tempRecord->created_at->format($format)] = array();
            }
            array_push($dataArray[$tempRecord->created_at->format($format)], $tempRecord->temperature);
        }

        //Create a unique array containing the averages of each date

        foreach ($dataArray as $date => $tempArray) {
            $count = 0;
            $total = 0;
            foreach ($tempArray as $temp) {
                $total += $temp;
                ++$count;
            }
            $this->finalArray[$date] = round(($total / $count));
        }

        //Format the data for the Chart
        $this->formatData();

        //return the data
        return  response()->json($this->builtArray);
    }
  }

    private function formatData()
    {
        $this->builtArray = array('labels' => array(), 'datasets' => array());
        //Lets get the first key and see if it contains an hour
        reset($this->finalArray);
        $dateSplitArray = explode(' ', key($this->finalArray));
        if (isset($dateSplitArray[1])) {
            //We know that this is for one day only so we need to show times
            $dateFormat = 'h A';
        } else {
            $dateFormat = 'D d-m';
        }
        $compareArray = array();
        foreach ($this->finalArray as $date => $average) {

            //build unique day array for compare
            $neatFormat = date('Y-m-d', strtotime($date));
            if (!array_key_exists($neatFormat, $compareArray)) {
                $compareArray[$neatFormat] = array();
            }
            $compareArray[$neatFormat][] = array('date' => $date, 'average' => $average);

            //Build the labels
            if (!in_array(date($dateFormat, strtotime($date)), $this->builtArray['labels'])) {
                array_push($this->builtArray['labels'], date($dateFormat, strtotime($date)));
            }
            $tempArray[] = $average;
        }

        $counter = 0;
        $colour = 220;
        foreach ($compareArray as $date => $detailArray) {
            foreach ($detailArray as $key => $value) {
                $this->builtArray['datasets'][$counter]['data'][] = $value['average'];
            }
            //Styling
            $this->builtArray['datasets'][$counter]['label'] = $date;
            $this->builtArray['datasets'][$counter]['fillColor'] = 'rgba('.$colour.','.$colour.','.$colour.',0.2)';
            $this->builtArray['datasets'][$counter]['strokeColor'] = 'rgba('.$colour.','.$colour.','.$colour.',1)';
            $this->builtArray['datasets'][$counter]['pointColor'] = 'rgba('.$colour.','.$colour.','.$colour.',1)';
            $this->builtArray['datasets'][$counter]['pointStrokeColor'] = '#fff';
            $this->builtArray['datasets'][$counter]['pointHighlightFill'] = '#fff';
            $this->builtArray['datasets'][$counter]['pointHighlightStroke'] = 'rgba('.$colour.','.$colour.','.$colour.',1)';

            //We only increase the counter if its a comparison
            if ($this->comparison) {
                //We alter the styling a bit
                $colour -= 100;
                $counter++;
            }
        }
    }
}
