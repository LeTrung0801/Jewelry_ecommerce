{{-- <div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('admin-home')}}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">DataTable</li>
                </ol>
            </nav>
        </div>
    </div>
</div> --}}
<div class="div class=pd-ltr-20 xs-pd-20-10">

<nav aria-label="breadcrumb" class="float-left">
	<ol class="breadcrumb bg-transparent mb-0 p-0">
		<li class="breadcrumb-item"><a href="{{route('admin-home')}}">Dashboard</a></li>
		@if(!empty($breadcrumbs))
			@foreach($breadcrumbs as $index => $breadcrumb)
				@if($index == count($breadcrumbs) - 1)
					<li class="breadcrumb-item active" aria-current="page">
						{{$breadcrumb['title']}}
					</li>
				@else
					<li class="breadcrumb-item" aria-current="page">
						<a href="{{$breadcrumb['route']}}">{{$breadcrumb['title']}}</a>
					</li>
				@endif

			@endforeach
		@endif
	</ol>
</nav>
</div>
