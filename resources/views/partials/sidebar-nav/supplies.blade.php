<li>
    <a href="{{route('main.index')}}">
        <i class="fa fa-home" aria-hidden="true"></i>
        <span>Home</span>
    </a>
</li>
<li class="nav-parent">
    <a>
        <i class="fa fa-list-alt" aria-hidden="true"></i>
        <span>PPMP</span>
    </a>
    <ul class="nav nav-children">
        <li>
            <a href="{{route('view.ppmp_list',['type'=>'se'])}}">Supplies/Equipment</a>
        </li>
        <li>
            <a href="{{route('view.ppmp_list',['type'=>'su'])}}">Supplemental</a>
        </li>
    </ul>
</li>
<li class="nav-parent">
    <a>
        <i class="fa fa-file-text-o" aria-hidden="true"></i>
        <span>APP</span>
    </a>
    <ul class="nav nav-children">
        <li>
            <a href="{{route('app.list',['type'=>'se'])}}">Supplies/Equipment</a>
        </li>
        <li>
            <a href="{{route('app.list',['type'=>'su']) }}">Supplemental</a>
        </li>
    </ul>
</li>
<li>
    <a href="{{route('requests.list')}}">
        <span class="pull-right label label-primary"></span>
        <i class="far fa-flag" aria-hidden="true"></i>
        <span>Requests Tracker</span>
    </a>
</li>