@extends('layouts.index')
@section('content')
<section role="main" class="content-body">
	@include('partials.role-header')
	@if ($errors->any())
	<div class="alert alert-danger">
		<ul>
			@foreach ($errors->all() as $error)
			<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
	@endif

	@if(session('success'))
	<div class="alert alert-success">
		{{session('success')}}
	</div>
	@endif
</section>
@endsection
@section('css')

@endsection
@section('js')

@endsection

