<li>
	<a href="{{route('main.index')}}">
		<i class="fa fa-home" aria-hidden="true"></i>
		<span>Home</span>
	</a>
</li>
<li>
	<a href="{{ route('admin.department') }}">
		<span class="pull-right label label-primary"></span>
		<i class="fa  fa-institution" aria-hidden="true"></i>
		<span>Departments</span>
	</a>
</li>
<li>
	<a href="{{ route('admin.course') }}">
		<span class="pull-right label label-primary"></span>
		<i class="fa fa-graduation-cap" aria-hidden="true"></i>
		<span>Courses</span>
	</a>
</li>
<li>
	<a href="{{ route('admin.account') }}">
		<span class="pull-right label label-primary"></span>
		<i class="fa fa-user" aria-hidden="true"></i>
		<span>Manage Account</span>
	</a>
</li>
<li>
	<a href="{{ route('admin.list',['type'=> 'PPMP']) }}">
		<span class="pull-right label label-primary"></span>
		<i class="fa fa-list-alt" aria-hidden="true"></i>
		<span>PPMP</span>
	</a>
</li>
<li>
	<a href="{{ route('admin.list',['type'=> 'APP']) }}">
		<span class="pull-right label label-primary"></span>
		<i class="fa fa-file-text-o" aria-hidden="true"></i>
		<span>APP</span>
	</a>
</li>
<li>
	<a href="{{ route('admin.list',['type'=> 'Requests']) }}">
		<span class="pull-right label label-primary"></span>
		<i class="fa fa-edit" aria-hidden="true"></i>
		<span>Request Letter</span>
	</a>
</li>