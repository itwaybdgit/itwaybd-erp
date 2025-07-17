<div class="col-md-4">
    <div class="card  gr_4_color">
        <a class="text-white" href="{{route("supportticket.total")}}">
        <div class="card-header">
            <div>
                <p class="card-text">Total Ticket</p>
                <h3 class="font-weight-bolder mb-0 h3_title">{{ticket_count()}}</h3>
            </div>
            <div class="avatar bg-light-primary p-50 m-0" style="color:#fff !important">
                <div class="avatar-content">
                    <i data-feather="bell" class="font-medium-5"></i>
                </div>
            </div>
        </div>
    </a>
    </div>
</div>
@foreach ($supportstatus as $value)
<div class="col-md-4">
    <div class="card {{$value->id == 1 ? "tick_1_color": ($value->id == 2 ? "tick_2_color" : "tick_3_color") }}">
        <a href="{{route("my_supportticket.index",$value->id)}}">
        <div class="card-header">
            <div>
                <p class="card-text">{{$value->name}}</p>
                <h3 class="font-weight-bolder mb-0 h3_title">{{ticket_count($value->id,auth()->id())}}</h3>
            </div>
            <div class="avatar bg-light-primary p-50 m-0" style="color:#fff !important">
                <div class="avatar-content">
                    <i class="fa fa-bell" aria-hidden="true"></i>
                </div>
            </div>
        </div>
       </a>
    </div>
</div>
@endforeach

<div class="col-md-6">
    <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">Employee</th>
            <th scope="col">Open Ticket</th>
            <th scope="col">Solved</th>
            <th scope="col">Closed</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($employees as $employee)
            <tr>
                <th scope="row">{{$employee->name}}</th>
                <td>{{ticket_count_by_column(['created_by'=>$employee->user_id])}}</td>
                <td>{{ticket_count_by_column(['status'=>5,"assign_to"=>$employee->user_id])}}</td>
                <td>{{ticket_count_by_column(['status'=>4,"assign_to"=>$employee->user_id])}}</td>
            </tr>
            @endforeach
        </tbody>
     </table>
</div>



<div class="col-md-6">
        <div class="card">
            <div class="card-header flex-column align-items-start">
            </div>
            <div class="card-body">
                <div id="donut-chart"></div>
            </div>
        </div>
</div>
<div class="col-md-12">
        <div class="card">
            <div class="card-header flex-column align-items-start">
            </div>
            <div class="card-body">
                <div>
                    <canvas id="barChart"></canvas>
                  </div>
            </div>
        </div>
</div>



<script>
    $(function () {
  'use strict';
  let jsonarray = <?php echo json_encode($sporch); ?>;
  let ticketcount = <?php echo json_encode($arraydara); ?>;
  var chartColors = {
      column: {
        series1: '#826af9',
        series2: '#d2b0ff',
        bg: '#f8d3ff'
      },
      success: {
        shade_100: '#7eefc7',
        shade_200: '#06774f'
      },
      donut: {
        series1: '#fca608',
        series2: '#00ad1a',
        series3: '#2b9bf4',
        series4: '#FFA1A1',
        series5: '#00e776'
      },
      area: {
        series3: '#a4f8cd',
        series2: '#60f2ca',
        series1: '#2bdac7'
      }
    };
    var donutChartEl = document.querySelector('#donut-chart'),
    donutChartConfig = {
      chart: {
        height: 350,
        type: 'donut'
      },
      legend: {
        show: true,
        position: 'bottom'
      },
      labels: jsonarray,
      series: ticketcount,
      colors: [
        chartColors.donut.series1,
        chartColors.donut.series5,
        chartColors.donut.series3,
        chartColors.donut.series4,
        chartColors.donut.series2
      ],
      dataLabels: {
        enabled: true,
        formatter: function (val, opt) {
          return parseInt(val) + '%';
        }
      },
      plotOptions: {
        pie: {
          donut: {
            labels: {
              show: true,
              name: {
                fontSize: '2rem',
                fontFamily: 'Montserrat'
              },
              value: {
                fontSize: '1rem',
                fontFamily: 'Montserrat',
                formatter: function (val) {
                  return parseInt(val) ;
                }
              },
              total: {
                show: true,
                fontSize: '1.5rem',
                label: 'Total Ticket',
                formatter: function (w) {
                  return '{{count($supportTicket)}}';
                }
              }
            }
          }
        }
      },
      responsive: [
        {
          breakpoint: 992,
          options: {
            chart: {
              height: 380
            }
          }
        },
        {
          breakpoint: 576,
          options: {
            chart: {
              height: 320
            },
            plotOptions: {
              pie: {
                donut: {
                  labels: {
                    show: true,
                    name: {
                      fontSize: '1.5rem'
                    },
                    value: {
                      fontSize: '1rem'
                    },
                    total: {
                      fontSize: '1.5rem'
                    }
                  }
                }
              }
            }
          }
        }
      ]
    };

  if(typeof donutChartEl !== undefined && donutChartEl !== null) {
    var donutChart = new ApexCharts(donutChartEl, donutChartConfig);
    donutChart.render();
  }

});
let supportcategory = <?php echo json_encode($supportcategory); ?>;
let categoryarray = <?php echo json_encode($categoryarray); ?>;

var ctx = document.getElementById("barChart").getContext('2d');
var barChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: supportcategory,
    datasets: [{
      label: 'Complain Type',
      data: categoryarray,
      backgroundColor: "rgba(0,0,255,1)"
    }]
  }
});

</script>
