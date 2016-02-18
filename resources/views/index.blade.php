@extends('layouts.master')
@section('customCSSScripts')
@parent
<!--Include custom CSS here-->
@stop
@section('mainContentSection')

  <div class="card">
    <div class="card-content white-text">
      <div class="m12 l12 s12">
        <canvas id="chart-canvas" class="chart"></canvas>
      </div>
    </div>
  </div>

<div class="col m12 l12 s12">
  <div class="row">
    <ul class="collapsible" data-collapsible="accordion">
        <li>
          <div class="collapsible-header"><i class="material-icons">call_split</i>Compare</div>
          <div class="collapsible-body">
            <p>
              <div class="col l12 s12">
                  <div class="input-field col s12 l6">
                    <label for="first-date">First Date</label>
                    <input id="first-date" class="datepicker picker__input" type="text">
                  </div>

                  <div class="input-field col s12 l6">
                    <label for="second-date">Second Date</label>
                    <input id="second-date" class="datepicker picker__input" type="text">
                  </div>
              </div>
              </p>
              <p>
                  <button class="waves-effect waves-light btn-large" id="compare">Compare</button>
              </p>
          </div>
        </li>
      </ul>
  </div>
</div>

@stop
@section('customJSScripts')
@parent
<!--Include custom JS here-->
@stop
