<script type="text/javascript">
     
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);
       
    function drawChart() { 
      var jsonData = $.ajax({ 
          url: "<?php echo site_url('chart/getdata'); ?>", 
          dataType: "json", 
          async: false 
          }).responseText; 
           
      // Create our data table out of JSON data loaded from server. 
      var data = new google.visualization.DataTable(jsonData); 
      var options = {
          title: 'Statistik Data Mahasiswa Berdasarkan Angkatan'
        };
      // Instantiate and draw our chart, passing in some options. 
      var chart = new google.visualization.PieChart(document.getElementById('lineChart')); 
      chart.draw(data, options); 
    } 
       
    // Set a callback to run when the Google Visualization API is loaded. 
   google.charts.load('current', {'packages': ['corechart', 'bar']});
   google.charts.setOnLoadCallback(drawAxisTickColors);

    function drawAxisTickColors() { 
      var jsonData = $.ajax({ 
          url: "<?php echo site_url('chart/getdata'); ?>", 
          dataType: "json", 
          async: false 
          }).responseText; 
           
      // Create our data table out of JSON data loaded from server. 
      var data = new google.visualization.DataTable(jsonData); 
       var options = {
        title: 'Chart Mahasiswa Berdasarkan Angkatan',
        focusTarget: 'category',
        hAxis: {
          title: 'Angkatan',
          format: 'h:mm a',
          viewWindow: {
            min: [15, 30, 0],
            max: [25, 30, 0]
          },
          textStyle: {
            fontSize: 14,
            color: '#053061',
            bold: true,
            italic: false
          },
          titleTextStyle: {
            fontSize: 14,
            color: '#053061',
            bold: false,
            italic: false
          }
        },
        vAxis: {
          title: 'Rating',
          textStyle: {
            fontSize: 18,
            color: '#67001f',
            bold: false,
            italic: false
          },
          titleTextStyle: {
            fontSize: 16,
            color: '#67001f',
            bold: true,
            italic: false
          }
        }
      };

      var chart = new google.visualization.ColumnChart(document.getElementById('mybarChart1'));
      chart.draw(data, options);
    } 
 
            
</script>

  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          
          ['SERVICE NAME', 'Hours per Day'],
           <?php 
              foreach ($char_data   as $service) {
                 echo "['".$service['name_angkatan']."', ".$service['offers']."],";
              }
              ?>

        ]);

        var options = {
          title: 'Chart Mahasiswa Berdasarkan Angkatan'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }

google.charts.load('current', {packages: ['corechart', 'bar']});
google.charts.setOnLoadCallback(drawAxisTickColors);

function drawAxisTickColors() {
      var data = google.visualization.arrayToDataTable([

            ['SERVICE NAME', 'Jumlah Mahasiswa'],
           <?php 
              foreach ($char_data   as $service) {
                 echo "['".$service['name_angkatan']."', ".$service['offers']."],";
              }
              ?>

        ]);
     

      var options = {
        title: 'Chart Mahasiswa Berdasarkan Angkatan',
        focusTarget: 'category',
        hAxis: {
          title: 'Angkatan',
          format: 'h:mm a',
          viewWindow: {
            min: [15, 30, 0],
            max: [25, 30, 0]
          },
          textStyle: {
            fontSize: 14,
            color: '#053061',
            bold: true,
            italic: false
          },
          titleTextStyle: {
            fontSize: 18,
            color: '#053061',
            bold: true,
            italic: false
          }
        },
        vAxis: {
          title: 'Rating',
          textStyle: {
            fontSize: 18,
            color: '#67001f',
            bold: false,
            italic: false
          },
          titleTextStyle: {
            fontSize: 18,
            color: '#67001f',
            bold: true,
            italic: false
          }
        }
      };

      var chart = new google.visualization.ColumnChart(document.getElementById('mybarChart'));
      chart.draw(data, options);
    }



    google.charts.load('current', {'packages':['gauge']});
    google.charts.setOnLoadCallback(drawGauge);

    var gaugeOptions = {min: 0, max: 280, yellowFrom: 200, yellowTo: 250,
      redFrom: 250, redTo: 280, minorTicks: 5};
    var gauge;

    function drawGauge() {
      gaugeData = new google.visualization.DataTable();
      gaugeData.addColumn('number', 'Engine');
      gaugeData.addColumn('number', 'Torpedo');
      gaugeData.addRows(2);
      gaugeData.setCell(0, 0, 120);
      gaugeData.setCell(0, 1, 80);

      gauge = new google.visualization.Gauge(document.getElementById('gauge_div'));
      gauge.draw(gaugeData, gaugeOptions);
    }

    function changeTemp(dir) {
      gaugeData.setValue(0, 0, gaugeData.getValue(0, 0) + dir * 25);
      gaugeData.setValue(0, 1, gaugeData.getValue(0, 1) + dir * 20);
      gauge.draw(gaugeData, gaugeOptions);
    }

    </script>