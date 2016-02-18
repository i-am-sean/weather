(function($) {
  $(document).ready(function() {
    var myNewChart;

    //datepicker init
    $('.datepicker').pickadate({
      selectMonths: true, // Creates a dropdown to control month
      selectYears: 1, // Creates a dropdown of 15 years to control year
      format: 'yyyy-mm-dd'
    });

    //modal init
    $('.modal-trigger').leanModal();

    //menu for mobile
    $('.button-collapse').sideNav();

    //When user clicks a button
    //Build chart
    $("body").on("click", ".filter-btn", function() {
      buildChart($(this).data("range"));
      setColour($(this));

      //Hide sidenav on mobile after click
      $('.button-collapse').sideNav('hide');
    });

    //When user clicks compare button
    //Build charts
    $("body").on("click", "#compare", function() {
      buildChart($("#first-date").val() + "_" + $("#second-date").val());
      //remove all red
      removeAllRed(".filter-btn");
    });

    //We trigger the click to load the chart on page load
    $("#day-btn").trigger("click");

  }); // end of document ready

  /**
   * Create new chart
   **/
  function buildChart(startDate) {

    //We need to extend the chart so that we can use a custom legend
    Chart.types.Line.extend({
      name: "LineAlt",
      draw: function() {
        Chart.types.Line.prototype.draw.apply(this, arguments);

        var ctx = this.chart.ctx;
        ctx.save();
        // text alignment and color
        ctx.textAlign = "center";
        ctx.textBaseline = "bottom";
        ctx.fillStyle = this.options.scaleFontColor;
        // position
        var x = this.scale.xScalePaddingLeft * 0.4;
        var y = this.chart.height / 2;
        // change origin
        ctx.translate(x, y)
          // rotate text
        ctx.rotate(-90 * Math.PI / 180);
        ctx.fillText('Temperature', 0, 0);
        ctx.restore();
      }
    });

    // Get the context of the canvas element we want to select
    var ctx = document.getElementById("chart-canvas").getContext("2d");

    //Get the data
    var data = fetchData(startDate);

    //Lets remove any previous data
    if (window.myNewChart !== undefined) {
      myNewChart.destroy();
    }


    //Chart options
    var options = {
        bezierCurve: true,
        responsive: true,
        multiTooltipTemplate: "<%= datasetLabel %> - <%= value %>",
        // make enough space on the right side of the graph
        scaleLabel: "          <%=value%>"
      }
      //Display chart
    if (data.datasets.length > 0) {
      myNewChart = new Chart(ctx).LineAlt(data, options);
    }
    else{
      $('#error-modal').openModal();      
    }
  }

  /**Get data from the controller via ajax
   * and return a json object
   **/
  function fetchData(startDate) {

    var chartData;

    //Send through the token to avoid CSRF blocking
    $.ajaxSetup({
      headers: {
        'X-CSRF-Token': $('meta[name=_token]').attr('content')
      }
    });

    $.ajax({
      type: 'GET',
      url: "/chart-data/data",
      dataType: 'json',
      data: {
        startDate: startDate
      },
      async: false
    }).done(function(response) {
      chartData = response;
    });

    return chartData;
  }

  function setColour(btn) {
    //First remove selected classes
    removeAllRed(".filter-btn");

    //Then add the class to the selected button
    btn.addClass('red');
  }

  //Remove red classes from all elements
  function removeAllRed(sel) {
    $(sel).each(function(elem) {
      $(this).removeClass('red');
    });
  }

})(jQuery); // end of jQuery name space
