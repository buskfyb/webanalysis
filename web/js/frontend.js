

// object to hold info about a site
function site(siteid, libname) {
    this.siteid = siteid;
    this.libname = libname;
}

// helper function to read parameters from the query string PMB 14-06-2016
function GetQueryStringByParameter(name) {
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
        return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    }

// funtions to set the value of global variables and update the graph afterwards PMB 07-06-2016
function setPeriod_type(value) {
    period_type = value;
    getYearData();    
}

// funtions to set the value of global variables and update the graph afterwards PMB 07-06-2016
function setField(value) {
    field = value; // field is a global variable PMB 2017-06-04
    getYearData();
}

// funtions to set the value of global variables and update the graph afterwards PMB 07-06-2016
function setYear(value) {
    year = value;
    getYearData();
}

// function that submits the form-data to the backend
function loadData(selectType) {
  if (selectType == 'month') {
      period = jQuery('#month').val();
      period_type = 'month';
  }
  else if (selectType == 'week') {
      period = jQuery('#week').val();
      period_type = 'week';
  }
  else if (selectType == 'category') {
      category = jQuery('#category').val();
  }

  year = jQuery('#year').val();

  // do some checking to find values
  var currentPeriod = GetQueryStringByParameter('period');
//  alert(period);

  URL = "?period=" + period + "&year=" + year + "&period_type=" + period_type + "&category=" + category;
  document.location = URL;
}

function drawChart(title, data) {

    // colors to use for lines in graph
    var colors = ['#A5132B', '#612172', '#DCDC3E', '#DA8A1C', '#4151A3', '#703593', '#981B48'];

    // setting heading of graph
    var head = [data[0][0]];

    // setting type for each line in graph, used to get correct colors on points
    for (i=1;i<data[0].length;i++) {
        var d = data[0][i];
        head.push(d);
        head.push({'type': 'string', 'role': 'style', });         
    }

    data[0] = head;

    // looping all data, to set correct point settings. each point must be declared
    for (i=1; i < data.length; i++) {
        var tmp = [data[i][0]];
        count = 0; // used to pick correct color
        for (var k in data[i])  {
            if (k != 0) {
               tmp.push(data[i][k]);
               tmp.push('point {stroke-width: 2; stroke-color: ' + colors[count-1] + '; fill-color: #ffffff}');            
            }    
            count++;
        }
        data[i] = tmp;
    }

    var hAxisNumber = data.length / 2; // set number of gridlines on hAxis. PMB 11-07-2016

    var data = google.visualization.arrayToDataTable(data);


    var options = {
      title: title,
      'width': 1200,
      'height': 250,
      'chartArea': {'width':'90%', 'height':'70%'},
      legend: { position: 'bottom' },
      pointSize: 4,
      lineWidth: 3.5,
      colors: ['#A5132B', '#612172', '#DCDC3E',
             '#DA8A1C', '#4151A3', '#703593', '#981B48'],
      hAxis: {gridlines: {count: hAxisNumber}}
    };

    var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

    chart.draw(data, options);
}


      
// funcion called when checking and unchecking whether a library should be included in the graph
function checkLibrary(idofsite, nameofsite) {
    if (jQuery('#' + idofsite).is(':checked')) {
        // create an object for the site and push it into the object holder PMB 07-06-2016
        var newSite = new site(idofsite, nameofsite);
        sitesInGraph.push(newSite);
        getYearData();
    }
    else {
        // remove the site from the object holder, and rewrite the graph PMB 07-06-2016
        sitesInGraph = jQuery.grep(sitesInGraph,
                   function(o,i) { return o.libname === nameofsite; },
                   true);
        getYearData();
    }
}

// function that reloads the single lib page when year changes PMB 15-06-2016
function changeYearSingle(libid, libname) {
    year = jQuery('#year').val();
    URL = 'index.php?libid=' + libid + '&libname=' + libname + '&year=' + year;
    document.location = URL;
}




function printStatistics(whichlibs) {
    var siteids = '';
    var count = 0; // to keep track if this is the first site
    for(var i = 0; i < sitesInGraph.length; i++) {
        if (count != 0) {siteids += ',';}
        siteids += sitesInGraph[i].siteid;
        count++;
    }

    year = jQuery('#year').val();
    category = jQuery('#category').val();

    document.location = 'serveStatistics.php?whichlibs=' + whichlibs + '&siteids=' + siteids + '&year=' + year + '&category=' + category;
}


// returns all visits for a given site
function getYearData() {
    var URL = "serveData.php";
    var periodName = 'Uke';
    var fieldText = 'Besøk totalt per uke';
    var siteids = '';
    var count = 0; // to keep track if this is the first site

    for(var i = 0; i < sitesInGraph.length; i++) {
        if (count != 0) {siteids += ',';}
        siteids += sitesInGraph[i].siteid;
        count++;
    }
    // field is a global variable PMB 2017-06-04
    var params = "siteids=" + siteids + "&year=" + year + "&period_type=" + period_type + "&field=" + field;

    if (field == 'average') {fieldText = 'Besøk per 1000 per uke';}
    else if (field == 'bounce_rate') {fieldText = 'Fluktfrekvens per uke';}
    else if (field == 'pageviews') {fieldText = 'Sidevisninger per uke';}
    else if (field == 'visitors') {fieldText = 'Unike besøkende per uke';}
    else if (field == 'pageviews_per_visit') {fieldText = 'Sider per besøk per uke';}

    
    if (period_type == 'week') {periodName = 'Uke';}
    jQuery.ajax({
        url: URL,
        data: params,
        success: function(result) {
            var header = [periodName];
              for(var i = 0; i < sitesInGraph.length; i++) {
                  header.push(sitesInGraph[i].libname);
              }

            var inData = JSON.parse(result);
            if (inData.status == 'none') {
                // handle error
                jQuery('#curve_chart').html("<div style='margin-left: 50px;'><strong>Ingen data for valgt periode</strong></div>");
            }
            else {
                inData.unshift(header);
                drawChart(fieldText, inData);
            }
        }
    })
}

function initialise() {
    jQuery("#" + start_site_id).prop('checked', true);
    var thisSite = new site(start_site_id, start_site_name);
    sitesInGraph.push(thisSite);
    getYearData();
}


