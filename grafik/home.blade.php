@extends('layouts.admin')
@section('header','Dashboard')

@section('content')
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
              <div class="inner">
                  <h3> {{ $total_book }}</h3>  
                  <p>Total Buku</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
            <a href="{{ url('Book')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3> {{ $total_member }}</h3>
                <p>Total Anggota</p>
            </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
          <a href="{{ url('Member')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
              <h3>{{ \App\Models\Publisher::count() }}</h3>
              <p>Data Penerbit</p>
            </div>
          <div class="icon">
            <i class="ion ion-person-add"></i>
          </div>
          <a href="{{ url('Publisher')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
 
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
              <h3>{{ \App\Models\Transaction::count() }}</h3>
              <p>Data Peminjam</p>
            </div>
          <div class="icon">
            <i class="ion ion-pie-graph"></i>
          </div>
          <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card card-danger">
            <div class="card-header">
              <h3 class="card-title">Grafik Penerbit</h3>

              <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          <div class="card-body">
            <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 572px;" width="715" height="312" class="chartjs-render-monitor"></canvas>
          </div>
        </div>
    </div>

    <div class="col-lg-6"> 
        <div class="card card-success">
            <div class="card-header">
              <h3 class="card-title">Grafik Peminjaman</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
          <div class="card-body">
              <div class="chart">
                <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 572px;" width="715" height="312" class="chartjs-render-monitor"></canvas>
              </div>
          </div>
        </div>
    </div>

    <div class="card card-danger">
              <div class="card-header">
                <h3 class="card-title">Grafik Katalog</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 572px;" width="715" height="312" class="chartjs-render-monitor"></canvas>
              </div>
              <!-- /.card-body -->
            </div>
    
</div>
@endsection
<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/plugins/chart.js/Chart.min.js') }}"></script>
<script type="text/javascript">

var label_donut = '{!! json_encode($label_donut) !!}';
var data_donut = '{!! json_encode($data_donut) !!}';
var data_bar = '{!! json_encode($data_bar) !!}';
var label_pie = '{!! json_encode($label_pie) !!}';
var data_pie = '{!! json_encode($data_pie) !!}';


  $(function () {
    //-------------
    //- DONUT CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
    var donutData        = {
      labels: JSON.parse(label_donut),
      datasets: [
        {
          data: JSON.parse(data_donut),
          backgroundColor : [ '#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de',
                            '#ff0000', '#00ff00', '#0000ff', '#ffff00', '#ff00ff', '#00ffff',
                            '#800000', '#008000', '#000080', '#808000', '#800080', '#008080'],
        }
      ]
    }
    var donutOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(donutChartCanvas, {
      type: 'doughnut',
      data: donutData,
      options: donutOptions
    })

    //-------------
    //- BAR CHART -
    //-------------
    var areaChartData = {
      labels : ['january', 'february', 'february', 'march', 'april', 'may', 'june', 'july', 'agustus', 'september', 'oktober', 'november', 'desember'], 
      datasets: JSON.parse(data_bar)
    }
    var barChartCanvas = $('#barChart').get(0).getContext('2d')
    var barChartData = $.extend(true, {}, areaChartData)
    // var temp0 = areaChartData.datasets[0]
    // var temp1 = areaChartData.datasets[1]
    // barChartData.datasets[0] = temp1
    // barChartData.datasets[1] = temp0

    var barChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false
    }

    new Chart(barChartCanvas, {
      type: 'bar',
      data: barChartData,
      options: barChartOptions
    })

    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieData        = {
      labels: JSON.parse(label_pie),
      datasets: [
        {
          data: JSON.parse(data_pie),
          backgroundColor : [ '#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc'],
        }
      ]
    }

    var pieOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(pieChartCanvas, {
      type: 'pie',
      data: pieData,
      options: pieOptions
    })
  })
</script>