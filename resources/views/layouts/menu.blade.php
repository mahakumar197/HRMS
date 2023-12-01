<ul class="sidebar-links" id="simple-bar">
    <li class="back-btn"><a href="{{url('/dashboard')}}"><img class="img-fluid" src="{{ asset('assets/css/images/logo-icon.png') }}" alt=""></a>
        <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"> </i></div>
    </li>
    <li class="sidebar-list"><a class="sidebar-link link-nav sidebar-title" href="{{url('/dashboard')}}">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g>
                    <g>
                        <path d="M9.07861 16.1355H14.8936" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M2.3999 13.713C2.3999 8.082 3.0139 8.475 6.3189 5.41C7.7649 4.246 10.0149 2 11.9579 2C13.8999 2 16.1949 4.235 17.6539 5.41C20.9589 8.475 21.5719 8.082 21.5719 13.713C21.5719 22 19.6129 22 11.9859 22C4.3589 22 2.3999 22 2.3999 13.713Z" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    </g>
                </g>
            </svg><span>Dashboard</span></a>
    </li>
    @if(Auth::user()->role == 'super_admin')
    <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g>
                    <g>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.9724 20.3683C8.73343 20.3683 5.96643 19.8783 5.96643 17.9163C5.96643 15.9543 8.71543 14.2463 11.9724 14.2463C15.2114 14.2463 17.9784 15.9383 17.9784 17.8993C17.9784 19.8603 15.2294 20.3683 11.9724 20.3683Z" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.9725 11.4488C14.0985 11.4488 15.8225 9.72576 15.8225 7.59976C15.8225 5.47376 14.0985 3.74976 11.9725 3.74976C9.84645 3.74976 8.12245 5.47376 8.12245 7.59976C8.11645 9.71776 9.82645 11.4418 11.9455 11.4488H11.9725Z" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M18.3622 10.3915C19.5992 10.0605 20.5112 8.93254 20.5112 7.58954C20.5112 6.18854 19.5182 5.01854 18.1962 4.74854" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M18.9431 13.5444C20.6971 13.5444 22.1951 14.7334 22.1951 15.7954C22.1951 16.4204 21.6781 17.1014 20.8941 17.2854" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M5.58372 10.3915C4.34572 10.0605 3.43372 8.93254 3.43372 7.58954C3.43372 6.18854 4.42772 5.01854 5.74872 4.74854" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M5.00176 13.5444C3.24776 13.5444 1.74976 14.7334 1.74976 15.7954C1.74976 16.4204 2.26676 17.1014 3.05176 17.2854" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    </g>
                </g>
            </svg><span>Employee</span></a>
        <ul class="sidebar-submenu">
            <li><a href="{{route('designation.index')}}">Designation</a></li>
            <li><a href="{{route('employee.create')}}">Add Employee</a></li>
            <li><a href="{{route('employee.index')}}">Employee Master</a></li>
        </ul>
    </li>
    <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g>
                    <g>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M2.75 12C2.75 5.063 5.063 2.75 12 2.75C18.937 2.75 21.25 5.063 21.25 12C21.25 18.937 18.937 21.25 12 21.25C5.063 21.25 2.75 18.937 2.75 12Z" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M15.9935 12H16.0025" stroke="#130F26" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M11.9945 12H12.0035" stroke="#130F26" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M7.9955 12H8.0045" stroke="#130F26" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </g>
                </g>
            </svg><span>Entitlement</span></a>
        <ul class="sidebar-submenu">
            <li><a href="{{route('casualleave.index')}}">Casual Leave</a></li>
            <li><a href="{{route('privilegeleave.index')}}">Privilege Leave</a></li>
            <li><a href="{{route('sickleave.index')}}">Sick Leave</a></li>
        </ul>
    </li>
    <li class="sidebar-list">
        <a class="sidebar-link sidebar-title" href="#">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g>
                    <g>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M2.75024 12C2.75024 5.063 5.06324 2.75 12.0002 2.75C18.9372 2.75 21.2502 5.063 21.2502 12C21.2502 18.937 18.9372 21.25 12.0002 21.25C5.06324 21.25 2.75024 18.937 2.75024 12Z" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M15.2045 13.8999H15.2135" stroke="#130F26" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M12.2045 9.8999H12.2135" stroke="#130F26" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M9.19557 13.8999H9.20457" stroke="#130F26" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </g>
                </g>
            </svg><span>Team Allocation</span></a>
        <ul class="sidebar-submenu">
            <li><a href="{{route('teamallocation.index')}}">Team Allocation Summary</a></li>
            <li><a href="{{route('teamallocation.create')}}">Create Team Allocation</a></li>
        </ul>
    </li>
    <li class="sidebar-list">
        <a class="sidebar-link link-nav sidebar-title" href="{{ route('announcement.index') }}">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g>
                    <g>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.9961 2.51416C7.56185 2.51416 5.63519 6.5294 5.63519 9.18368C5.63519 11.1675 5.92281 10.5837 4.82471 13.0037C3.48376 16.4523 8.87614 17.8618 11.9961 17.8618C15.1152 17.8618 20.5076 16.4523 19.1676 13.0037C18.0695 10.5837 18.3571 11.1675 18.3571 9.18368C18.3571 6.5294 16.4295 2.51416 11.9961 2.51416Z" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M14.306 20.5122C13.0117 21.9579 10.9927 21.9751 9.68604 20.5122" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    </g>
                </g>
            </svg><span>Announcement</span></a>
    </li>
    @endif
    @if(Auth::user()->role =='super_admin' || Auth::user()->sub_role == 'hr')
    <li class="sidebar-list">
        <a class="sidebar-link sidebar-title" href="#">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g>
                    <g>
                        <path d="M14.3053 15.45H8.90527" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M12.2604 11.4387H8.90442" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M20.1598 8.3L14.4898 2.9C13.7598 2.8 12.9398 2.75 12.0398 2.75C5.74978 2.75 3.64978 5.07 3.64978 12C3.64978 18.94 5.74978 21.25 12.0398 21.25C18.3398 21.25 20.4398 18.94 20.4398 12C20.4398 10.58 20.3498 9.35 20.1598 8.3Z" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M13.9342 2.83276V5.49376C13.9342 7.35176 15.4402 8.85676 17.2982 8.85676H20.2492" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    </g>
                </g>
            </svg><span>Projects</span></a>
        <ul class="sidebar-submenu">
            <li><a href="{{route('projects.index')}}">Project Master</a></li>
            <li><a href="{{route('projects.create')}}">Create Project</a></li>
        </ul>
    </li>
    @endif
    @if(Auth::user()->role == 'project_manager')
    <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="{{route('employee-details')}}">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g>
                    <g>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.9724 20.3683C8.73343 20.3683 5.96643 19.8783 5.96643 17.9163C5.96643 15.9543 8.71543 14.2463 11.9724 14.2463C15.2114 14.2463 17.9784 15.9383 17.9784 17.8993C17.9784 19.8603 15.2294 20.3683 11.9724 20.3683Z" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.9725 11.4488C14.0985 11.4488 15.8225 9.72576 15.8225 7.59976C15.8225 5.47376 14.0985 3.74976 11.9725 3.74976C9.84645 3.74976 8.12245 5.47376 8.12245 7.59976C8.11645 9.71776 9.82645 11.4418 11.9455 11.4488H11.9725Z" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M18.3622 10.3915C19.5992 10.0605 20.5112 8.93254 20.5112 7.58954C20.5112 6.18854 19.5182 5.01854 18.1962 4.74854" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M18.9431 13.5444C20.6971 13.5444 22.1951 14.7334 22.1951 15.7954C22.1951 16.4204 21.6781 17.1014 20.8941 17.2854" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M5.58372 10.3915C4.34572 10.0605 3.43372 8.93254 3.43372 7.58954C3.43372 6.18854 4.42772 5.01854 5.74872 4.74854" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M5.00176 13.5444C3.24776 13.5444 1.74976 14.7334 1.74976 15.7954C1.74976 16.4204 2.26676 17.1014 3.05176 17.2854" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    </g>
                </g>
            </svg><span>Employee Master</span></a>
    </li>
    @endif
    <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav" href="{{route('holiday.index')}}">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g>
                    <g>
                        <path d="M8.54248 9.21777H15.3975" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.9702 2.5C5.58324 2.5 4.50424 3.432 4.50424 10.929C4.50424 19.322 4.34724 21.5 5.94324 21.5C7.53824 21.5 10.1432 17.816 11.9702 17.816C13.7972 17.816 16.4022 21.5 17.9972 21.5C19.5932 21.5 19.4362 19.322 19.4362 10.929C19.4362 3.432 18.3572 2.5 11.9702 2.5Z" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    </g>
                </g>
            </svg><span>Holiday Master</span>
            <div class="according-menu"><i class="fa fa-angle-right"></i></div>
        </a></li>
    <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g>
                    <g>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M2.74976 12.7755C2.74976 5.81947 5.06876 3.50146 12.0238 3.50146C18.9798 3.50146 21.2988 5.81947 21.2988 12.7755C21.2988 19.7315 18.9798 22.0495 12.0238 22.0495C5.06876 22.0495 2.74976 19.7315 2.74976 12.7755Z" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M3.02515 9.32397H21.0331" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M16.4284 13.261H16.4374" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M12.0289 13.261H12.0379" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M7.62148 13.261H7.63048" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M16.4284 17.113H16.4374" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M12.0289 17.113H12.0379" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M7.62148 17.113H7.63048" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M16.033 2.05005V5.31205" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M8.02466 2.05005V5.31205" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    </g>
                </g>
            </svg><span>Leave Management</span></a>
        <ul class="sidebar-submenu">
            <li><a href="{{route('leave.create')}}">Apply Leave</a></li>
            <li><a href="{{route('leave.index')}}">Leave Summary</a></li>
            @if(Auth::user()->role == 'project_manager')
            <li><a href="{{route('assignleave.create')}}">Assign Leave</a></li>
            @elseif(Auth::user()->role == 'super_admin')
            <li><a href="{{route('assignleave.create')}}">Assign Leave</a></li>
            @endif
            @if(Auth::user()->role != 'employee')
            <li><a href="{{route('manageleave.index')}}">Approve Leave</a></li>
            @endif
        </ul>
    </li>

    <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g>
                    <g>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M2.75 12C2.75 18.937 5.063 21.25 12 21.25C18.937 21.25 21.25 18.937 21.25 12C21.25 5.063 18.937 2.75 12 2.75C5.063 2.75 2.75 5.063 2.75 12Z" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M15.39 14.018L11.999 11.995V7.63403" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    </g>
                </g>
            </svg><span>Attendance</span></a>
        <ul class="sidebar-submenu">
            <li><a href="{{route('attendance.create')}}">Add My Attendance</a></li>
            @if(Auth::user()->role != 'employee')
            <li><a href="{{route('myattendance')}}">My Attendance Summary</a></li>
            @endif
            @if(Auth::user()->role == 'employee')
            <li><a href="{{route('attendance.index')}}">Employee Attendance Summary</a></li>
            @endif
            @if(Auth::user()->role != 'employee')
            <li><a href="{{route('teamattendance')}}">Standup Attendance</a></li>
            <li><a href="{{route('assignattendance.index')}}">Assign Attendance</a></li>
            <li><a href="{{route('attendance.index')}}">Team Attendance Summary</a></li>
            @endif
        </ul>
    </li>

    <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g>
                    <g>
                        <path d="M15.596 15.6963H8.37598" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M15.596 11.9365H8.37598" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M11.1312 8.17725H8.37622" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M3.61011 12C3.61011 18.937 5.70811 21.25 12.0011 21.25C18.2951 21.25 20.3921 18.937 20.3921 12C20.3921 5.063 18.2951 2.75 12.0011 2.75C5.70811 2.75 3.61011 5.063 3.61011 12Z" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    </g>
                </g>
            </svg><span>Report</span></a>
        <ul class="sidebar-submenu">
            @if(Auth::user()->role == 'project_manager')
            <li><a href="{{route('leave-report-pm')}}">Leave Summary</a></li>
            <li><a href="{{route('atten-report-pm')}}">Attendance Summary</a></li>
            @endif
            @if(Auth::user()->role != 'employee')
            <li><a href="{{route('pm-rr-report')}}">Revenue Recognition</a></li>
            <li><a href="{{route('project-wise-attendance')}}">Employee Attendance Projectwise</a></li>
            @endif
            @if(Auth::user()->role == 'super_admin')
            <!--<li><a href="{{ route("report.attendancereport.index", ['year' => now()->year, 'month' => now()->format('m')]) }}" class="nav-link {{ request()->is('admin/attendances') || request()->is('admin/attendances/*') ? 'active' : '' }}">Attendance</a></li>-->
            <li><a href="{{route('leave-report-all')}}">Leave Summary</a></li>
            <li><a href="{{route('atten-report-all')}}">Attendance Summary</a></li>
            <li><a href="{{route('active-employee.index')}}">Active Employees</a></li>
            <li><a href="{{route('employee-join-report')}}">Joiners</a></li>
            <li><a href="{{route('employee-leaving-report')}}">Leavers</a></li>
            <li><a href="{{route('attendance-register')}}">Attendance Register</a></li>
            <li><a href="{{route('team-report-all')}}">Team Allocation</a></li>
            @endif
            @if(Auth::user()->role == 'employee')
            <li><a href="{{route('leave-report-employee')}}">Leave Summary</a></li>
            <li><a href="{{route('atten-report-emp')}}">Attendance Summary</a></li>
            @endif
        </ul>
    </li>
    @if(Auth::user()->role != 'employee')
    <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                <polyline points="14 2 14 8 20 8"></polyline>
                <line x1="16" y1="13" x2="8" y2="13"></line>
                <line x1="16" y1="17" x2="8" y2="17"></line>
                <polyline points="10 9 9 9 8 9"></polyline>
            </svg><span>Self Report</span></a>
        <ul class="sidebar-submenu">
            <li><a href="{{route('leave-report-employee')}}">Leave Summary</a></li>
            <li><a href="{{route('atten-report-emp')}}">Attendance Summary</a></li>
        </ul>
    </li>
    @endif

    @if(Auth::user()->role == 'super_admin')
    <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g>
                    <g>
                        <path d="M6.91699 14.854L9.90999 10.965L13.324 13.645L16.253 9.86499" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M19.6671 2.3501C20.7291 2.3501 21.5891 3.2101 21.5891 4.2721C21.5891 5.3331 20.7291 6.1941 19.6671 6.1941C18.6051 6.1941 17.7451 5.3331 17.7451 4.2721C17.7451 3.2101 18.6051 2.3501 19.6671 2.3501Z" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M20.7555 9.26898C20.8885 10.164 20.9495 11.172 20.9495 12.303C20.9495 19.241 18.6375 21.553 11.6995 21.553C4.76246 21.553 2.44946 19.241 2.44946 12.303C2.44946 5.36598 4.76246 3.05298 11.6995 3.05298C12.8095 3.05298 13.8005 3.11198 14.6825 3.23998" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    </g>
                </g>
            </svg><span>Year Leave Report</span></a>
        <ul class="sidebar-submenu">
            <li><a href="{{route('year-leave-record')}}">Leave Record</a></li>
            <li><a href="{{route('year-leave-report')}}">Leave Details</a></li>
        </ul>
    </li>
    @endif

    <li class="sidebar-list">

        <a class="sidebar-link sidebar-title " href="#">

            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g>
                    <g>
                        <path d="M17.5449 9.01904C17.5449 9.01904 14.3349 12.8717 11.987 12.8717C9.64016 12.8717 6.39404 9.01904 6.39404 9.01904" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M2.45215 11.9688C2.45215 5.13075 4.8331 2.85205 11.976 2.85205C19.1188 2.85205 21.4998 5.13075 21.4998 11.9688C21.4998 18.8059 19.1188 21.0856 11.976 21.0856C4.8331 21.0856 2.45215 18.8059 2.45215 11.9688Z" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    </g>
                </g>
            </svg><span>Feedback</span></a>
        <ul class="sidebar-submenu">
            <li><a href="{{route('feedback.index')}}">Feedback</a></li>
            <li><a href="{{route('feedback.create')}}">Submit Feedback</a></li>

        </ul>
    </li>
    @if(Auth::user()->role == 'super_admin' || Auth::user()->sub_role == 'hr')
    <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g>
                    <g>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M2.75024 12C2.75024 5.063 5.06324 2.75 12.0002 2.75C18.9372 2.75 21.2502 5.063 21.2502 12C21.2502 18.937 18.9372 21.25 12.0002 21.25C5.06324 21.25 2.75024 18.937 2.75024 12Z" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M9.42993 14.5697L14.5699 9.42969" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M14.4955 14.5H14.5045" stroke="#130F26" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M9.4955 9.5H9.5045" stroke="#130F26" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </g>
                </g>
            </svg><span>HR Section</span></a>
        <ul class="sidebar-submenu">
            <li><a class="submenu-title" href="#">Create New<span class="sub-arrow"><i class="fa fa-angle-right"></i></span></a>
                <ul class="nav-sub-childmenu submenu-content">
                    <li><a href="{{route('agency.create')}}">Consultancy</a></li>
                    <li><a href="{{route('job-position.index')}}">Job Position</a></li>
                    <li><a href="{{route('interview-round.index')}}">Interview Round</a></li>
                    <li><a href="{{route('skillset.index')}}">Skillset</a></li>
                    <li><a href="{{route('job.create')}}">Job</a></li>
                </ul>
            </li>
            <li><a class="submenu-title" href="#">Report<span class="sub-arrow"><i class="fa fa-angle-right"></i></span></a>
                <ul class="nav-sub-childmenu submenu-content">
                    <li><a href="{{route('daily-hr-report')}}">Daily HR</a></li>
                    <li><a href="{{route('offered-joiners-report')}}">Offered & Joiners</a></li>
                    <li><a href="{{route('unicef-report')}}">UNICEF</a></li>
                    <li><a href="{{route('daily-project-report')}}">Daily Project</a></li>
                    <li><a href="{{route('candidate-tracker-report')}}">Candidate Tracker</a></li>
                </ul>
            </li>
            <li><a href="{{route('agency.index')}}">Consultancy</a></li>
            <li><a href="{{route('job.index')}}">Job</a></li>
            <li><a href="{{route('candidate.index')}}">Candidates</a></li>

        </ul>
    </li>
    @endif
    @if(Auth::user()->sub_role == 'hr')
    <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav" href="{{route('employee.index')}}">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g>
                    <g>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.9724 20.3683C8.73343 20.3683 5.96643 19.8783 5.96643 17.9163C5.96643 15.9543 8.71543 14.2463 11.9724 14.2463C15.2114 14.2463 17.9784 15.9383 17.9784 17.8993C17.9784 19.8603 15.2294 20.3683 11.9724 20.3683Z" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.9725 11.4488C14.0985 11.4488 15.8225 9.72576 15.8225 7.59976C15.8225 5.47376 14.0985 3.74976 11.9725 3.74976C9.84645 3.74976 8.12245 5.47376 8.12245 7.59976C8.11645 9.71776 9.82645 11.4418 11.9455 11.4488H11.9725Z" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M18.3622 10.3915C19.5992 10.0605 20.5112 8.93254 20.5112 7.58954C20.5112 6.18854 19.5182 5.01854 18.1962 4.74854" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M18.9431 13.5444C20.6971 13.5444 22.1951 14.7334 22.1951 15.7954C22.1951 16.4204 21.6781 17.1014 20.8941 17.2854" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M5.58372 10.3915C4.34572 10.0605 3.43372 8.93254 3.43372 7.58954C3.43372 6.18854 4.42772 5.01854 5.74872 4.74854" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M5.00176 13.5444C3.24776 13.5444 1.74976 14.7334 1.74976 15.7954C1.74976 16.4204 2.26676 17.1014 3.05176 17.2854" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    </g>
                </g>
            </svg><span>Employee Summary</span></a>
    </li>
    @endif
    @if(Auth::user()->role == 'project_manager' || Auth::user()->role == 'employee')
    <li class="sidebar-list">
        <a class="sidebar-link sidebar-title " href="#">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-link">
                <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path>
                <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>
            </svg><span>Employee Referral</span></a>
        <ul class="sidebar-submenu">
            <li><a href="{{route('emp-referral')}}">Job Summary</a></li>
            <li><a href="{{route('candidate.index')}}">Candidates</a></li>
        </ul>
    </li>
    @endif

</ul>