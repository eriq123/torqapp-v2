<!-- start: sidebar -->
<aside id="sidebar-left" class="sidebar-left">

    <div class="sidebar-header" style="background-color: #171717;">
        <div class="sidebar-title">
            <p style = "color:white!important;">Navigation</p>
        </div>
        <div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
            <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
        </div>
    </div>
    <!-- sidebar navigation -->
    <div class="nano">
        <div class="nano-content">
            <nav id="menu" class="nav-main" role="navigation" style="background-color:  #800000!important;">
                <ul class="nav nav-main">

                    <!-- include sidebar nav -->
                    @role('Admin')
                        @include('partials.sidebar-nav.admin')
                    @elserole('Section Head')
                        @include('partials.sidebar-nav.section')
                    @elserole('Budget Officer')
                        @include('partials.sidebar-nav.budget')
                    @elserole('ADAA')
                        @include('partials.sidebar-nav.adaa')
                    @elserole('Campus Director')
                        @include('partials.sidebar-nav.director')
                    @elserole('BAC Secretary')
                        @include('partials.sidebar-nav.bac_sec')
                    @elserole('BAC Chairperson')
                        @include('partials.sidebar-nav.bac_chairperson')
                    @elserole('Department Head')
                        @include('partials.sidebar-nav.department_head')
                    @elserole('Procurement')
                        @include('partials.sidebar-nav.procurement')
                    @elserole('Supplies')
                        @include('partials.sidebar-nav.supplies')
                    @else

                    @endrole

                    <!-- end include -->
                    
                </ul>
            </nav>
        </div>
    </div>
    <!-- end sidebar navigation -->


</aside>
<!-- end: sidebar -->



