@extends('admin.layouts.app')

@section('page_title', 'Dashboard')
@push('styles')
<style>
    .form-group label {
        text-transform: capitalize;
    }
</style>
@endpush

@section('content')
<div class="page-heading">
    <h1 class="page-title">Dashboard</h1>
</div>
<div class="page-content fade-in-up">
    {{-- Cards --}}
    <div class="row">
        {{-- Category --}}
        <div class="col-lg-3 col-md-6">
            <a href="{{route('category.index')}}" class="text-white">
                <div class="ibox bg-success color-white widget-stat">
                    <div class="ibox-body">
                        <h2 class="m-b-5 font-strong"> {{$dashboard_allCategories->count()}}</h2>
                        <div class="m-b-5 text-uppercase">total categories</div>
                        <i class="fa fa-gift widget-stat-icon"></i>
                        <div>
                            <small>View More</small><i class="fa fa-arrow-circle-o-right m-l-5"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        {{-- Exhibitor --}}
        <div class="col-lg-3 col-md-6">
            <a href="{{route('exhibitor.index')}}" class="text-white">
                <div class="ibox bg-danger color-white widget-stat">
                    <div class="ibox-body">
                        <h2 class="m-b-5 font-strong"> {{$dashboard_exhibitors->count()}}</h2>
                        <div class="m-b-5 text-uppercase">total exhibitors</div>
                        <i class="fa fa-table widget-stat-icon"></i>
                        <div>
                            <small>View More</small><i class="fa fa-arrow-circle-o-right m-l-5"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        {{-- Scholarship --}}
        <div class="col-lg-3 col-md-6">
            <a href="{{route('scholarship.index')}}" class="text-white">
                <div class="ibox bg-orange color-white widget-stat">
                    <div class="ibox-body">
                        <h2 class="m-b-5 font-strong"> {{$dashboard_allScholarships->count()}}</h2>
                        <div class="m-b-5 text-uppercase">total scholarships</div>
                        <i class="fa fa-graduation-cap widget-stat-icon"></i>
                        <div>
                            <small>View More</small><i class="fa fa-arrow-circle-o-right m-l-5"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        {{-- Institution --}}
        <div class="col-lg-3 col-md-6">
            <a href="{{route('scholarship.index')}}" class="text-white">
                <div class="ibox bg-blue color-white widget-stat">
                    <div class="ibox-body">
                        <h2 class="m-b-5 font-strong"> {{$dashboard_allInstitutions->count()}}</h2>
                        <div class="m-b-5 text-uppercase">total institutions</div>
                        <i class="fa fa-university widget-stat-icon"></i>
                        <div>
                            <small>View More</small><i class="fa fa-arrow-circle-o-right m-l-5"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        {{-- Admin User --}}
        <div class="col-lg-3 col-md-6">
            <a href="{{route('user.index')}}" class="text-white">
                <div class="ibox bg-red color-white widget-stat">
                    <div class="ibox-body">
                        <h2 class="m-b-5 font-strong"> {{$dashboard_allAdminUsers->count()}}</h2>
                        <div class="m-b-5 text-uppercase">total admin users</div>
                        <i class="fa fa-users widget-stat-icon"></i>
                        <div>
                            <small>View More</small><i class="fa fa-arrow-circle-o-right m-l-5"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        {{-- Students --}}
        <div class="col-lg-3 col-md-6">
            <a href="{{route('admin.allCustomers')}}" class="text-white">
                <div class="ibox bg-primary color-white widget-stat">
                    <div class="ibox-body">
                        <h2 class="m-b-5 font-strong"> {{$dashboard_allCustomers->count()}}</h2>
                        <div class="m-b-5 text-uppercase">total Students</div>
                        <i class="fa fa-users widget-stat-icon"></i>
                        <div>
                            <small>View More</small><i class="fa fa-arrow-circle-o-right m-l-5"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        {{-- Interested Countries --}}
        <div class="col-lg-3 col-md-6">
            <a href="{{route('country.index')}}" class="text-white">
                <div class="ibox bg-success color-white widget-stat">
                    <div class="ibox-body">
                        <h2 class="m-b-5 font-strong"> {{$dashboard_allCountries->count()}}</h2>
                        <div class="m-b-5 text-uppercase">Interested Countries</div>
                        <i class="fa fa-globe widget-stat-icon"></i>
                        <div>
                            <small>View More</small><i class="fa fa-arrow-circle-o-right m-l-5"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-5">
            <div class="ibox">
                <div class="ibox-head">
                    <div class="ibox-title">Categories</div>
                </div>
                <div class="ibox-body">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>S.N</th>
                                <th>Category Name</th>
                                <th>Exhibitors</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dashboard_allCategories->take(4) as $key => $category)
                            <tr>
                                <td>{{++$key}}</td>
                                <td>{{$category->title}}</td>
                                <td>{{$category->exhibitors->count()}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="ibox">
                <div class="ibox-head">
                    <div class="ibox-title">New Students</div>
                </div>
                <div class="ibox-body">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>S.N</th>
                                <th>Student Email</th>
                                <th>Student Name</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dashboard_allCustomers->take(3) as $key => $customer)
                            <tr>
                                <td>{{++$key}}</td>
                                <td>{{$customer->email}}</td>
                                <td>{{$customer->name}}</td>
                                <td>{{\Carbon\Carbon::parse($customer->created_at)->format('M d, Y')}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">Weekly Report</div>
        </div>
        <div class="ibox-body">
            <canvas id="myChart"></canvas>
        </div>
    </div>
</div>

@endsection

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script>
    var week_days = <?php echo json_encode($weekly_detail['week_days']); ?>;
   var weekly_clients_total = <?php echo json_encode($weekly_detail['weekly_clients_total']); ?>;
   //console.log(monthlySales['months']);
   var ctx = document.getElementById('myChart').getContext('2d');
   var chart = new Chart(ctx, {
       // The type of chart we want to create
       type: 'bar',

       // The data for our dataset
       data: {
           labels: week_days['day'],
           datasets: [{
               label: 'Clients',
               data: weekly_clients_total,
               backgroundColor: 'rgba(255, 99, 132, 0.7)',
           }]
       },

       // Configuration options go here
       options: {
            scales:{
                yAxes:[{
                    ticks: {
                        beginAtZero: !0
                    }
                }] ,
                xAxes:[{
                    stacked: false,
                    beginAtZero: true,
                    barPercentage: 0.4,
                    scaleLabel: {
                        labelString: 'Week'
                    },
                    ticks: {
                        stepSize: 1,
                        min: 0,
                        autoSkip: false
                    }
               }]
            },
       }
   });

</script>
@endpush