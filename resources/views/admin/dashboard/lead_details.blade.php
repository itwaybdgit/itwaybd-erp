<div class="row">
    <div class="col-md-6">
        <div class="card" style="width: 100%;">
            <table class="table">
                <thead>
                  <tr>
                    <th scope="col">Employee</th>
                    <th scope="col">Today Lead</th>
                    <th scope="col">Total Lead</th>
                  </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{App\Models\Company::first()->company_name ?? ""}}</td>
                        <td><a href="{{route("lead.index",teamcount(auth()->id(),date("Y-m-d")))}}">{{count(teamcount(auth()->id(),date("Y-m-d")))}}</a> </td>
                        <td><a href="{{route("lead.index",teamcount(auth()->id()))}}">{{count(teamcount(auth()->id()))}}</a></td>
                    </tr>
                    @foreach ($salesperson as $item)
                    <tr>
                        <td>{{$item->name}}</td>
                        <td><a href="{{route("lead.index",teamcount($item->user_id,date("Y-m-d")))}}">{{count(teamcount($item->user_id,date("Y-m-d")))}}</a> </td>
                        <td><a href="{{route("lead.index",teamcount($item->user_id))}}">{{count(teamcount($item->user_id))}}</a></td>
                        </tr>
                    @endforeach
                </tbody>
              </table>
         </div>
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
</div>

<script>
$(function () {
  'use strict';
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
      labels: ["Total Lead", "Confirm Lead"],
      series: [{{$leadpending}},{{$leadconfirm}}],
      colors: [
        chartColors.donut.series1,
        chartColors.donut.series2,
        chartColors.donut.series3,
        chartColors.donut.series4,
        chartColors.donut.series5
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
                label: 'Total Lead',
                formatter: function (w) {
                  return "{{$leadpending}}";
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
</script>
