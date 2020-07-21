@extends('layout')


@section('css')
<link rel="stylesheet" type="text/css" href="/bower_components/chartist/css/chartist.css">
@endsection

@section('content')
<div class="page-body">
  	<div class="row">
   <!-- counter-card-1 start-->
	   @foreach($_category as $category)
		   	<div class="col-md-4">
			    <div class="card counter-card-1">
				    <div class="card-block-big">
					    <div class="row">
					       	<div class="col-6 counter-card-icon">
					        	<img src="{{$category->alt_icon}}" class="img-dash-icon">
					      	</div>
					      	<div class="col-6  text-right">
						        <div class="counter-card-text">
						         	<h3>{{number_format($category->total_item)}}</h3>
						         	<p>{{$category->category_name}}</p>
						       	</div>
					     	</div>
					   	</div>
					</div>
				</div>
			</div>
		@endforeach
		<!-- <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>For the month of {{date('F')}}</h5>
                    <span>Lorem ipsum dolor sit amet, consectetur adipisicing elit</span>
                    
                </div>
                <div class="card-block">
                    <div class="ct-chart-horizontal ct-perfect-fourth"></div>
                </div>
            </div>
        </div> -->
	</div>
</div>
@endsection

@section('js')
<script type="text/javascript" src="/bower_components/chartist/js/chartist.js"></script>
<script type="text/javascript">
	// new Chartist.Bar('.ct-chart-horizontal', {
 //        labels: ['Branch 1', 'Branch 2', 'Branch 3', 'Branch 4', 'Branch 5', 'Branch 7', 'Branch 8'],
 //        series: [
 //            [5, 4, 3, 7, 5, 10, 3]
 //        ]
 //    }, {
 //        seriesBarDistance: 10,
 //        reverseData: true,
 //        horizontalBars: true,
 //        axisY: {
 //            offset: 70
 //        }
 //    });
</script>
@endsection