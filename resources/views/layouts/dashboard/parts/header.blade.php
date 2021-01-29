<!-- begin:: Header -->
<div id="kt_header" class="kt-header kt-grid kt-grid--ver  kt-header--fixed ">

    <!-- begin:: Aside -->
    <div class="kt-header__brand kt-grid__item  " id="kt_header_brand">
        <div class="kt-header__brand-logo">
            <a href="#">
                <img alt="Logo" width="100" height="80" src="{{asset('storage/companies/logos/' . (App\Company::find(App\Company::companyID())->logo ?? 'logo-6.png'))}}" />
            </a>
        </div>
    </div>

    <!-- end:: Aside -->

    <!-- begin:: Title -->
{{--    <h3 class="kt-header__title kt-grid__item">--}}
{{--        {{__('Hi! ') . explode(' ',auth()->user()->name())[0]}}--}}
{{--    </h3>--}}

    <!-- end:: Title -->

    <!-- begin: Header Menu -->
    <button class="kt-header-menu-wrapper-close" id="kt_header_menu_mobile_close_btn"><i class="la la-close"></i></button>
    <div class="kt-header-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_header_menu_wrapper">
        <div id="kt_header_menu" class="kt-header-menu kt-header-menu-mobile  kt-header-menu--layout-default ">
            <ul class="kt-menu__nav ">
                <li class="kt-menu__item kt-menu__item--open kt-menu__item--here kt-menu__item--submenu kt-menu__item--rel" data-ktmenu-submenu-toggle="click" aria-haspopup="true"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-text">{{__('Hi! ') . auth()->user()->name()}}</span><i class="kt-menu__hor-arrow la la-angle-down"></i><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                    <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">
                        <ul class="kt-menu__subnav">
                           @if(auth()->guard('company')->check())
                            <li class="kt-menu__item  kt-menu__item--submenu" data-ktmenu-submenu-toggle="hover" aria-haspopup="true"><a href="{{route('dashboard.profile.company_profile','')}}" class="kt-menu__link "><i class="kt-menu__link-icon flaticon2-user"></i><span class="kt-menu__link-text">{{__('Company Profile')}}</span></a></li>
                           @else
                            <li class="kt-menu__item  kt-menu__item--submenu" data-ktmenu-submenu-toggle="hover" aria-haspopup="true"><a href="{{route('dashboard.myProfile.account_info', '')}}" class="kt-menu__link "><i class="kt-menu__link-icon flaticon2-user"></i><span class="kt-menu__link-text">{{__('My Profile')}}</span></a></li>
                           @endif
                            <li class="kt-menu__item  kt-menu__item--submenu" data-ktmenu-submenu-toggle="hover" aria-haspopup="true"><a onclick="document.getElementById('logout-header').submit();" href="javascript:" class="kt-menu__link "><i class="kt-menu__link-icon fas fa-sign-out-alt"></i><span class="kt-menu__link-text">{{__('Log Out')}}</span></a></li>
                            <form id="logout-header" action="{{ route('logout', '') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <!-- end: Header Menu -->


    <!-- begin:: Header Topbar -->
    <div class="kt-header__topbar">

        <!--begin: Notifications -->
        <div class="kt-header__topbar-item dropdown">
            <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px">
                <span class="kt-header__topbar-icon kt-header__topbar-icon--success" ><i class="flaticon2-bell-alarm-symbol"></i>
                <span id="bellCounter"></span>
                </span>
                <span class="kt-hidden kt-badge kt-badge--danger"></span>
            </div>
            <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-xl">
                <form>

                    <!--begin: Head -->
                    <div class="kt-head kt-head--skin-dark kt-head--fit-x kt-head--fit-b" style="background-image: url({{asset('assets/media/misc/bg-1.jpg')}})">
                        <h3 class="kt-head__title">
                            <a href="{{route('dashboard.notifications.index', '')}}" class="btn btn-success btn-sm btn-bold btn-font-md">
                                <span>{{__('See All Notifications')}} <i class="flaticon2-bell "></i></span>
                            </a>
                        </h3>
                        <ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-success kt-notification-item-padding-x" role="tablist">

                        </ul>
                    </div>

                    <!--end: Head -->
                    <div class="tab-content">
                        <div class="tab-pane active show" id="topbar_notifications_notifications" role="tabpanel">
                            <div class="kt-notification kt-margin-t-10 kt-margin-b-10 kt-scroll" data-scroll="true" data-height="300" data-mobile-height="200">
                                @forelse(auth()->user()->unReadNotifications as $notification)
                                    <a href="{{route('dashboard.notifications.mark_as_read', $notification->id, '')}}" class="kt-notification__item">
                                        <div class="kt-notification__item-icon">
                                            <i class="flaticon2-user-outline-symbol kt-font-success"></i>
                                        </div>
                                        <div class="kt-notification__item-details">
                                            <div class="kt-notification__item-title">
                                                {{__($notification->data['message']) . ' ' .  \Carbon\Carbon::today()->translatedFormat('Y-M-d')}}
                                            </div>
                                            <div class="kt-notification__item-time">
                                                {{$notification->created_at->diffForHumans()}}
                                            </div>
                                        </div>
                                    </a>
                                @empty
                                    <div class="kt-grid kt-grid--ver" style="min-height: 200px;">
                                        <div class="kt-grid kt-grid--hor kt-grid__item kt-grid__item--fluid kt-grid__item--middle">
                                            <div class="kt-grid__item kt-grid__item--middle kt-align-center">
                                                {{__('All caught up!')}}
                                                <br>{{__('No new notifications.')}}
                                            </div>
                                        </div>
                                    </div>
                                @endforelse
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!--end: Notifications -->
    @can('view_settings')
        <!--begin: Quick actions -->
        <div class="kt-header__topbar-item dropdown">
            <a href="{{route('dashboard.settings.payrolls', '')}}"  class="kt-header__topbar-wrapper"  data-offset="10px,0px">
                <span class="kt-header__topbar-icon kt-header__topbar-icon--warning"><i class="flaticon2-gear"></i></span>
            </a>
        </div>
    @endcan
        <!--end: Quick actions -->



        <!--begin: Language bar -->
        <div class="kt-header__topbar-item kt-header__topbar-item--langs">
            <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px">
                <span class="kt-header__topbar-icon kt-header__topbar-icon--brand">
                    <img class="" src="{{asset('assets/media/flags/' . LaravelLocalization::getCurrentLocale() . '.svg')}}" alt="english" />
                </span>
            </div>
            <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim">
                <ul class="kt-nav kt-margin-t-10 kt-margin-b-10">
                @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                    <li class="kt-nav__item">
                        <a href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}" class="kt-nav__link">
                            <span class="kt-nav__link-icon"><img src="{{asset('assets/media/flags/' . $localeCode . '.svg')}}" alt="" /></span>
                            <span class="kt-nav__link-text">{{ $properties['native'] }}</span>
                        </a>
                    </li>
                @endforeach
                </ul>
            </div>
        </div>

        <!--end: Language bar -->

    </div>

    <!-- end:: Header Topbar -->
</div>

<!-- end:: Header -->

@push('scripts')
    <script>
        $(function (){
            $.ajax({
                method: 'get',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: '/dashboard/unReadNotificationsNumber',
                success:function (response){
                    if(response.unReadNotificationsNumber > 0){
                        $("#bellCounter").text(response.unReadNotificationsNumber)
                        $("#bellCounter").css('display', 'initial')
                    }
                },
                error: function (err) {
                    console.log(err);
                }
            })
        });
    </script>
@endpush
