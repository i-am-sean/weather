
<nav class="teal lighten-2" role="navigation">
    <div class="nav-wrapper container"><a id="logo-container" href="#" class="brand-logo">Weather Crawler</a>
      <ul class="right hide-on-med-and-down">
        <li><a class="waves-effect waves-light btn-large filter-btn red" data-range="{!! $today !!}" id="day-btn">Day</a></li>
        <li><a class="waves-effect waves-light btn-large filter-btn" data-range="{!! $monday !!}">Week</a></li>
        <li><a class="waves-effect waves-light btn-large filter-btn" data-range="{!! $first !!}">Month</a></li>
      </ul>

      <ul id="nav-mobile" class="side-nav">
        <li><a class="waves-effect waves-light btn-small filter-btn red" data-range="{!! $today !!}">Day</a></li>
        <li><a class="waves-effect waves-light btn-small filter-btn" data-range="{!! $monday !!}">Week</a></li>
        <li><a class="waves-effect waves-light btn-small filter-btn" data-range="{!! $first !!}">Month</a></li>
      </ul>
      <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
    </div>
  </nav>
