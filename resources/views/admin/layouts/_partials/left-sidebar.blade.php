@php
$user = Auth::user();
$role = $user->role;
$user_access = explode(',', $user->access_level);
@endphp
<nav class="page-sidebar" id="sidebar">
    <div id="sidebar-collapse">
        <div class="admin-block d-flex align-items-center">
            <div>
                <img src="{{asset('/images/main/'.$dashboard_composer->logo)}}" class="rounded" width="45px" />
            </div>
            <div class="admin-info">
                <div class="font-strong">{{ Auth::user()->name }}</div>
            </div>
        </div>
        <ul class="side-menu metismenu">

            <li class="heading">Menu</li>
            {{-- Dashboard --}}
            <li>
                <a href="{{route('dashboard')}}"><i class="sidebar-item-icon fa fa-globe"></i>
                    <span class="nav-label">Dashboard</span></a>
            </li>
            {{-- Dashboard --}}

            <li>
                <a href="{{route('setting')}}"><i class="sidebar-item-icon fa fa-globe"></i>
                    <span class="nav-label">Site Setting</span></a>
            </li>

            @if($role == 'super-admin' || ($role == 'admin' && in_array('subscriber', $user_access)) )
            {{-- Subscriber --}}
            <li>
                <a href="{{route('subscriber.index')}}"><i class="sidebar-item-icon fa fa-globe"></i>
                    <span class="nav-label">Subscriber</span></a>
            </li>
            {{-- Subscriber --}}
            @endif

            {{-- Students --}}
            <li>
                <a href="{{route('admin.allCustomers')}}"><i class="sidebar-item-icon fa fa-globe"></i>
                    <span class="nav-label">Students</span></a>
            </li>
            {{-- Students --}}

            {{-- Report --}}
            <li>
                <a href="{{route('admin.daily_report')}}"><i class="sidebar-item-icon fa fa-globe"></i>
                    <span class="nav-label">Report</span></a>
            </li>
            {{-- Report --}}

            {{-- Bookings --}}
            <li>
                <a href="{{route('admin.allBookings')}}"><i class="sidebar-item-icon fa fa-globe"></i>
                    <span class="nav-label">Bookings</span></a>
            </li>
            {{-- Bookings --}}

            {{-- Visitors --}}
            <li>
                <a href="{{route('visitor.index')}}"><i class="sidebar-item-icon fa fa-globe"></i>
                    <span class="nav-label">Visitors</span></a>
            </li>
            {{-- Visitors --}}

            {{-- Refer --}}
            <li>
                <a href="{{route('refer.index')}}"><i class="sidebar-item-icon fa fa-globe"></i>
                    <span class="nav-label">Refer</span></a>
            </li>
            {{-- Refer --}}

            @if($role == 'super-admin' || ($role == 'admin' && in_array('user', $user_access)) )
            {{-- User --}}
            <li>
                <a href="javascript:;">
                    <i class="sidebar-item-icon fa fa-sitemap"></i>
                    <span class="nav-label">Admin User</span>
                    <i class="fa fa-angle-left arrow"></i>
                </a>
                <ul class="nav-2-level collapse">
                    <li>
                        <a href="{{route('user.index')}}">
                            <span class="fa fa-circle-o"></span>
                            All lists
                        </a>
                    </li>
                    <li>
                        <a href="{{route('user.create')}}">
                            <span class="fa fa-plus"></span>
                            Add new
                        </a>
                    </li>

                </ul>
            </li>
            {{-- User --}}
            @endif

            @if($role == 'super-admin' || ($role == 'admin' && in_array('category', $user_access)) )
            {{-- Category --}}
            <li>
                <a href="javascript:;">
                    <i class="sidebar-item-icon fa fa-sitemap"></i>
                    <span class="nav-label">Category</span>
                    <i class="fa fa-angle-left arrow"></i>
                </a>
                <ul class="nav-2-level collapse">
                    <li>
                        <a href="{{route('category.index')}}">
                            <span class="fa fa-circle-o"></span>
                            All lists
                        </a>
                    </li>

                </ul>
            </li>
            {{-- Category --}}
            @endif

            @if($role == 'super-admin' || ($role == 'admin' && in_array('exhibitor', $user_access)) )
            {{-- Exhibitor --}}
            <li>
                <a href="javascript:;">
                    <i class="sidebar-item-icon fa fa-sitemap"></i>
                    <span class="nav-label">Exhibitor</span>
                    <i class="fa fa-angle-left arrow"></i>
                </a>
                <ul class="nav-2-level collapse">
                    <li>
                        <a href="{{route('exhibitor.index')}}">
                            <span class="fa fa-circle-o"></span>
                            All lists
                        </a>
                    </li>
                    <li>
                        <a href="{{route('exhibitor.create')}}">
                            <span class="fa fa-plus"></span>
                            Add new
                        </a>
                    </li>

                </ul>
            </li>
            {{-- Exhibitor --}}
            @endif


            @if($role == 'super-admin' || ($role == 'admin' && in_array('branch', $user_access)) )
            {{-- Branch --}}
            <li>
                <a href="javascript:;">
                    <i class="sidebar-item-icon fa fa-sitemap"></i>
                    <span class="nav-label">Branch</span>
                    <i class="fa fa-angle-left arrow"></i>
                </a>
                <ul class="nav-2-level collapse">
                    <li>
                        <a href="{{route('branch.index')}}">
                            <span class="fa fa-circle-o"></span>
                            All lists
                        </a>
                    </li>
                    <li>
                        <a href="{{route('branch.create')}}">
                            <span class="fa fa-plus"></span>
                            Add new
                        </a>
                    </li>

                </ul>
            </li>
            {{-- Subscriber --}}
            @endif

            @if($role == 'super-admin' || ($role == 'admin' && in_array('country', $user_access)) )
            {{-- Country --}}
            <li>
                <a href="javascript:;">
                    <i class="sidebar-item-icon fa fa-sitemap"></i>
                    <span class="nav-label">Interested Country</span>
                    <i class="fa fa-angle-left arrow"></i>
                </a>
                <ul class="nav-2-level collapse">
                    <li>
                        <a href="{{route('country.index')}}">
                            <span class="fa fa-circle-o"></span>
                            All lists
                        </a>
                    </li>
                    <li>
                        <a href="{{route('country.create')}}">
                            <span class="fa fa-plus"></span>
                            Add new
                        </a>
                    </li>

                </ul>
            </li>
            {{-- Country --}}
            @endif

            @if($role == 'super-admin' || ($role == 'admin' && in_array('proficiency', $user_access)) )
            {{-- Proficiency --}}
            <li>
                <a href="javascript:;">
                    <i class="sidebar-item-icon fa fa-sitemap"></i>
                    <span class="nav-label">Proficiency Test</span>
                    <i class="fa fa-angle-left arrow"></i>
                </a>
                <ul class="nav-2-level collapse">
                    <li>
                        <a href="{{route('proficiency.index')}}">
                            <span class="fa fa-circle-o"></span>
                            All lists
                        </a>
                    </li>
                    <li>
                        <a href="{{route('proficiency.create')}}">
                            <span class="fa fa-plus"></span>
                            Add new
                        </a>
                    </li>

                </ul>
            </li>
            {{-- Proficiency --}}
            @endif

            @if($role == 'super-admin' || ($role == 'admin' && in_array('academic', $user_access)) )
            {{-- Academic --}}
            <li>
                <a href="javascript:;">
                    <i class="sidebar-item-icon fa fa-sitemap"></i>
                    <span class="nav-label">Academic Qualification</span>
                    <i class="fa fa-angle-left arrow"></i>
                </a>
                <ul class="nav-2-level collapse">
                    <li>
                        <a href="{{route('academic.index')}}">
                            <span class="fa fa-circle-o"></span>
                            All lists
                        </a>
                    </li>
                    <li>
                        <a href="{{route('academic.create')}}">
                            <span class="fa fa-plus"></span>
                            Add new
                        </a>
                    </li>

                </ul>
            </li>
            {{-- Academic --}}
            @endif

        </ul>
    </div>
</nav>
{{-- <li>
                <a href="javascript:;">
                    <i class="sidebar-item-icon fa fa-sitemap"></i>
                    <span class="nav-label">User Enquiry</span>
                    <i class="fa fa-angle-left arrow"></i>
                </a>
                <ul class="nav-2-level collapse">
                    <li>
                        <a href="">
                            <span class="fa fa-circle-o"></span>
                            Enquiry List
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <span class="fa fa-circle-o"></span>
                            Subscriber List
                        </a>
                    </li>

                </ul>
            </li> --}}

{{-- @if($role == 'super-admin' || ($role == 'admin' && in_array('datetime', $user_access)) )
<li>
    <a href="javascript:;">
        <i class="sidebar-item-icon fa fa-sitemap"></i>
        <span class="nav-label">Date Time</span>
        <i class="fa fa-angle-left arrow"></i>
    </a>
    <ul class="nav-2-level collapse">
        <li>
            <a href="{{route('datetime.index')}}">
<span class="fa fa-circle-o"></span>
All lists
</a>
</li>
<li>
    <a href="{{route('datetime.create')}}">
        <span class="fa fa-plus"></span>
        Add new
    </a>
</li>

</ul>
</li>
@endif

@if($role == 'super-admin' || ($role == 'admin' && in_array('scholarship', $user_access)) )
<li>
    <a href="javascript:;">
        <i class="sidebar-item-icon fa fa-sitemap"></i>
        <span class="nav-label">Scholarship/Institution</span>
        <i class="fa fa-angle-left arrow"></i>
    </a>
    <ul class="nav-2-level collapse">
        <li>
            <a href="{{route('scholarship.index')}}">
                <span class="fa fa-circle-o"></span>
                All lists
            </a>
        </li>
        <li>
            <a href="{{route('scholarship.create')}}">
                <span class="fa fa-plus"></span>
                Add new
            </a>
        </li>

    </ul>
</li>
@endif --}}

{{-- @if($role == 'super-admin' || ($role == 'admin' && in_array('year', $user_access)) )
<li>
    <a href="javascript:;">
        <i class="sidebar-item-icon fa fa-sitemap"></i>
        <span class="nav-label">Passed Year</span>
        <i class="fa fa-angle-left arrow"></i>
    </a>
    <ul class="nav-2-level collapse">
        <li>
            <a href="{{route('year.index')}}">
<span class="fa fa-circle-o"></span>
All lists
</a>
</li>
<li>
    <a href="{{route('year.create')}}">
        <span class="fa fa-plus"></span>
        Add new
    </a>
</li>

</ul>
</li>
@endif --}}