<!-- begin:: Aside -->
<button class="kt-aside-close " id="kt_aside_close_btn"><i class="la la-close"></i></button>
<div class="kt-aside  kt-aside--fixed  kt-grid__item kt-grid kt-grid--desktop kt-grid--hor-desktop" id="kt_aside">

    <!-- begin:: Aside Menu -->
    <div class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_aside_menu_wrapper">
        <div id="kt_aside_menu" class="kt-aside-menu " data-ktmenu-vertical="1" data-ktmenu-scroll="1" data-ktmenu-dropdown-timeout="500">
            <ul class="kt-menu__nav ">
                <li class="kt-menu__item  kt-menu__item--active" aria-haspopup="true"><a href="{{route('dashboard.index')}}" class="kt-menu__link "><i class="kt-menu__link-icon flaticon2-protection"></i><span class="kt-menu__link-text">{{__('Dashboard')}}</span></a></li>

                @canany(['view_roles','create_roles'])
                <li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon flaticon-lock"></i><span class="kt-menu__link-text">{{__('Roles')}}</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                    <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                        <ul class="kt-menu__subnav">
                            <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span class="kt-menu__link-text">Config</span></span></li>
                            @can('view_roles')
                            <li class="kt-menu__item " aria-haspopup="true"><a href="{{route('dashboard.roles.index')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{__('All Roles')}}</span></a></li>
                            @endcan
                            @can('create_roles')
                            <li class="kt-menu__item " aria-haspopup="true"><a href="{{route('dashboard.roles.create')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{__('New Role')}}</span></a></li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @endcanany

                @canany(['view_users','create_users'])
                <li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon flaticon-user-ok"></i><span class="kt-menu__link-text">{{__('Companies')}}</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                    <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                        <ul class="kt-menu__subnav">
                            <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span class="kt-menu__link-text">Config</span></span></li>
                            @can('view_users')
                            <li class="kt-menu__item " aria-haspopup="true"><a href="{{route('dashboard.companies.index')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{__('All Companies')}}</span></a></li>
                            @endcan
                            @can('create_users')
                            <li class="kt-menu__item " aria-haspopup="true"><a href="{{route('dashboard.companies.create')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{__('New Company')}}</span></a></li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @endcanany


                @canany(['view_violations','create_violations'])
                <li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon flaticon2-open-box"></i><span class="kt-menu__link-text">{{__('Violations Panel')}}</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                    <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                        <ul class="kt-menu__subnav">
                            <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span class="kt-menu__link-text">Config</span></span></li>
                            @can('view_violations')
                            <li class="kt-menu__item " aria-haspopup="true"><a href="{{route('dashboard.violations.index')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{__('AlL Violations')}}</span></a></li>
                            @endcan
                            @can('create_violations')
                            <li class="kt-menu__item " aria-haspopup="true"><a href="{{route('dashboard.violations.create')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{__('New Violation')}}</span></a></li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @endcanany
                @canany(['view_employees','create_employees'])
                <li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon flaticon2-group"></i><span class="kt-menu__link-text">{{__('Employees')}}</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                    <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                        <ul class="kt-menu__subnav">
                            <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span class="kt-menu__link-text">Config</span></span></li>
                            @can('view_employees')
                            <li class="kt-menu__item " aria-haspopup="true"><a href="{{route('dashboard.employees.index')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{__('All Employees')}}</span></a></li>
                            @endcan

                            <li class="kt-menu__item " aria-haspopup="true"><a href="{{route('dashboard.employees.ended_employees')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{__('All Ended Employees')}}</span></a></li>

                            @can('create_employees')
                            <li class="kt-menu__item " aria-haspopup="true"><a href="{{route('dashboard.employees.create')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{__('New Employee')}}</span></a></li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @endcanany

                <li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon flaticon2-group"></i><span class="kt-menu__link-text">{{__('All Ended Employees')}}</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                    <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                        <ul class="kt-menu__subnav">
                            <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span class="kt-menu__link-text">Config</span></span></li>
                            <li class="kt-menu__item " aria-haspopup="true"><a href="{{route('dashboard.employees.ended_employees')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{__('All Ended Employees')}}</span></a></li>
                        </ul>
                    </div>
                </li>

                @canany(['view_employees_violations','create_employees_violations'])
                <li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon flaticon2-layers-1"></i><span class="kt-menu__link-text">{{__('Employees Violations')}}</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                    <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                        <ul class="kt-menu__subnav">
                            <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span class="kt-menu__link-text">Config</span></span></li>
                            @can('view_employees_violations')
                            <li class="kt-menu__item " aria-haspopup="true"><a href="{{route('dashboard.employees_violations.index')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{__('AlL Employees Violations')}}</span></a></li>
                            @endcan
                            @can('create_employees_violations')
                            <li class="kt-menu__item " aria-haspopup="true"><a href="{{route('dashboard.employees_violations.create')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{__('New Violation')}}</span></a></li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @endcanany

                @canany(['view_reports','create_reports'])
                <li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon  flaticon2-document"></i><span class="kt-menu__link-text">{{__('Reports')}}</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                    <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                        <ul class="kt-menu__subnav">
                            <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span class="kt-menu__link-text">Config</span></span></li>
                            @can('view_reports')
                            <li class="kt-menu__item " aria-haspopup="true"><a href="{{route('dashboard.reports.index')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{__('AlL Reports')}}</span></a></li>
                            @endcan
                            @can('view_reports')
                            <li class="kt-menu__item " aria-haspopup="true"><a href="{{route('dashboard.reports.create')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{__('New Report')}}</span></a></li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @endcan

                @canany(['view_conversations','create_conversations'])
                <li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon  flaticon-envelope"></i><span class="kt-menu__link-text">{{__('Conversations')}}</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                    <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                        <ul class="kt-menu__subnav">
                            <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span class="kt-menu__link-text">Config</span></span></li>
                            @can('view_conversations')
                            <li class="kt-menu__item " aria-haspopup="true"><a href="{{route('dashboard.conversations.index')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{__('AlL Conversation')}}</span></a></li>
                            @endcan
                            @can('view_conversations')
                            <li class="kt-menu__item " aria-haspopup="true"><a href="{{route('dashboard.conversations.create')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{__('New Conversation')}}</span></a></li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @endcan

                @canany(['view_payrolls','view_my_salaries'])
                <li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon fas fa-comment-dollar"></i><span class="kt-menu__link-text reportCount">{{__('Payrolls')}}</span><i class="kt-menu__ver-arrow la la-angle-right" ></i></a>
                        <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                            <ul class="kt-menu__subnav">
                                @can('view_payrolls')
                                <li class="kt-menu__item " aria-haspopup="true"><a href="{{route('dashboard.payrolls.index')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{__('All Payrolls')}}</span></a></li>
                                <li class="kt-menu__item " aria-haspopup="true"><a href="{{route('dashboard.payrolls.pending')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text reportCount">{{__('Pending Payrolls')}} </span></a></li>
                                @endcan
                                @can('view_my_salaries')
                                <li class="kt-menu__item " aria-haspopup="true"><a href="{{route('dashboard.salaries.my_salaries')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{__('My Salaries')}}</span></a></li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcan

                @canany(['view_requests', 'view_my_requests'])
                <li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon flaticon2-layers"></i><span class="kt-menu__link-text">{{__('Requests')}}</span><i class="kt-menu__ver-arrow la la-angle-right" ></i></a>
                    <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                        <ul class="kt-menu__subnav">
                            @can('view_requests')
                            <li class="kt-menu__item " aria-haspopup="true"><a href="{{route('dashboard.requests.index')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{__('All Requests')}}</span></a></li>
                            <li class="kt-menu__item " aria-haspopup="true"><a href="{{route('dashboard.requests.pending_requests')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{__('Pending Requests')}}</span></a></li>
                            @endcan
                            @can('view_my_requests')
                            <li class="kt-menu__item " aria-haspopup="true"><a href="{{route('dashboard.requests.my_requests')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{__('My Requests')}}</span></a></li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @endcan

                @canany(['create_vacation_request', 'create_attendance_record_forgotten_request'])
                <li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon flaticon2-website"></i><span class="kt-menu__link-text">{{__('Employees Services')}}</span><i class="kt-menu__ver-arrow la la-angle-right" ></i></a>
                    <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                        <ul class="kt-menu__subnav">
                            @can('create_vacation_request')
                            <li class="kt-menu__item " aria-haspopup="true"><a href="{{route('dashboard.vacations.create')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{__('Vacation Request')}}</span></a></li>
                            @endcan
                            @can('create_attendance_record_forgotten_request')
                            <li class="kt-menu__item " aria-haspopup="true"><a href="{{route('dashboard.attendance_forgottens.create')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{__('Attendance Record Forgetting Request')}}</span></a></li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @endcan

                @canany(['view_attendance_record_page','view_attendance_sheet', 'view_my_attendance_history'])
                <li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon  flaticon-event-calendar-symbol"></i><span class="kt-menu__link-text">{{__('Attendance')}}</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                    <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                        <ul class="kt-menu__subnav">
                            <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span class="kt-menu__link-text">Config</span></span></li>
                            @can('view_attendance_record_page')
                                <li class="kt-menu__item " aria-haspopup="true"><a href="{{route('dashboard.attendances.create')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{__('Attendance Record')}}</span></a></li>
                            @endcan
                            @can('view_attendance_record_page')
                                <li class="kt-menu__item " aria-haspopup="true"><a href="{{route('dashboard.attendances.create_manually')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{__('Attendance Record Manually')}}</span></a></li>
                            @endcan
                            @can('view_attendance_sheet')
                                <li class="kt-menu__item " aria-haspopup="true"><a href="{{route('dashboard.attendances.index')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{__('Attendance Sheet')}}</span></a></li>
                            @endcan
                            @can('view_my_attendance_history')
                                <li class="kt-menu__item " aria-haspopup="true"><a href="{{route('dashboard.attendances.my_attendances')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{__('My Attendance')}}</span></a></li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @endcan

                @can('view_settings')
                <li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon  flaticon2-settings"></i><span class="kt-menu__link-text">{{__('Settings')}}</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                    <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                        <ul class="kt-menu__subnav">
                            <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span class="kt-menu__link-text">Config</span></span></li>
                            <li class="kt-menu__item " aria-haspopup="true"><a href="{{route('dashboard.settings.payrolls')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{__('General Settings')}}</span></a></li>
                            <li class="kt-menu__item " aria-haspopup="true"><a href="{{route('dashboard.nationalities.index')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{__('Nationalities')}}</span></a></li>
                            <li class="kt-menu__item " aria-haspopup="true"><a href="{{route('dashboard.job_titles.index')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{__('Job Titles')}}</span></a></li>
                            <li class="kt-menu__item " aria-haspopup="true"><a href="{{route('dashboard.allowances.index')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{__('Allowances')}}</span></a></li>
                            <li class="kt-menu__item " aria-haspopup="true"><a href="{{route('dashboard.work_shifts.index')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{__('Work Shifts')}}</span></a></li>
                            <li class="kt-menu__item " aria-haspopup="true"><a href="{{route('dashboard.leave_balances.index')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{__('Leave Balances')}}</span></a></li>
                            <li class="kt-menu__item " aria-haspopup="true"><a href="{{route('dashboard.vacation_types.index')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{__('Vacations Types')}}</span></a></li>
                            <li class="kt-menu__item " aria-haspopup="true"><a href="{{route('dashboard.departments.index')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{__('Departments')}}</span></a></li>
                            <li class="kt-menu__item " aria-haspopup="true"><a href="{{route('dashboard.sections.index')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{__('Sections')}}</span></a></li>
                            <li class="kt-menu__item " aria-haspopup="true"><a href="{{route('dashboard.providers.index')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{__('Providers')}}</span></a></li>
                        </ul>
                    </div>
                </li>
                @endcan

                <li class="kt-menu__item " aria-haspopup="true"><a onclick="document.getElementById('logout').submit();" href="javascript:" class="kt-menu__link "><i class="kt-menu__link-icon  fas fa-sign-out-alt"></i><span class="kt-menu__link-text">{{__('Log Out')}}</span></a></li>
                <form id="logout" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </ul>
        </div>
    </div>

    <!-- end:: Aside Menu -->
</div>

<!-- end:: Aside -->
@push('scripts')
    <Script>
        $(function (){
{{--            @canany(['view_all_salaries', 'view_pending_reports'])--}}
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                method: "get",
                url: "/dashboard/payrolls/pending",
                data: function (params) {
                    return {
                        _token: CSRF_TOKEN,
                    };
                },
                success:function(data){
                    if(data.length > 0){
                        $(".reportCount").append('<span class="kt-badge kt-badge--rounded kt-badge--brand mx-auto" style="" >' + data.length + '</span>')
                    }

                }
            });
{{--            @endcan--}}
        })
    </Script>
@endpush