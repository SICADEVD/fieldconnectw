<div class="sidebar bg--dark">
    @php
        $upcomingCount = \App\Models\LivraisonInfo::where('receiver_cooperative_id', auth()->user()->id)
            ->where('status', 1)
            ->count();
        // $deliveryCount = \App\Models\LivraisonInfo::where('receiver_cooperative_id',)
    @endphp
    <button class="res-sidebar-close-btn"><i class="las la-times"></i></button>
    <div class="sidebar__inner">
        <div class="sidebar__logo">
            <a href="{{ route('staff.dashboard') }}" class="sidebar__main-logo"><img
                    src="{{ getImage(getFilePath('logoIcon') . '/logo.png') }}" alt="@lang('image')"></a>
        </div>
        <div class="sidebar__menu-wrapper" id="sidebar__menuWrapper">
            <ul class="sidebar__menu">
                <li class="sidebar-menu-item {{ menuActive('staff.dashboard') }}">
                    <a href="{{ route('staff.dashboard') }}" class="nav-link ">
                        <i class="menu-icon las la-home"></i>
                        <span class="menu-title">@lang("Tableau de bord")</span>
                    </a>
                </li>
                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{ menuActive('staff.livraison*', 3) }}">
                        <i class="menu-icon las la-sliders-h"></i>
                        <span class="menu-title">@lang('Livraison') </span>
                    </a>
                    <div class="sidebar-submenu {{ menuActive('staff.livraison*', 2) }} ">
                        <ul>
                               <li class="sidebar-menu-item {{ menuActive('staff.livraison.create') }}">
                    <a href="{{ route('staff.livraison.create') }}" class="nav-link ">
                        <i class="menu-icon las la-shipping-fast"></i>
                        <span class="menu-title">@lang("Enregistrement")</span>
                    </a>
                </li>
                <li class="sidebar-menu-item {{ menuActive('staff.livraison.sent.queue') }}">
                    <a href="{{ route('staff.livraison.sent.queue') }}" class="nav-link ">
                        <i class="menu-icon las la-hourglass-start"></i>
                        <span class="menu-title">@lang("En attente d'expédition")</span>
                    </a>
                </li>
                <li class="sidebar-menu-item {{ menuActive('staff.livraison.dispatch') }}">
                    <a href="{{ route('staff.livraison.dispatch') }}" class="nav-link ">
                        <i class="menu-icon las la-sync"></i>
                        <span class="menu-title">@lang("Expédiée") </span>
                    </a>
                </li>
                <li class="sidebar-menu-item {{ menuActive('staff.livraison.upcoming') }}">
                    <a href="{{ route('staff.livraison.upcoming') }}" class="nav-link ">
                        <i class="menu-icon las la-history"></i>
                        <span class="menu-title">@lang("Encours") @if ($upcomingCount > 0)
                                <span class="menu-badge pill bg--danger ms-auto">{{ $upcomingCount }}</span>
                            @endif
                        </span>

                    </a>
                </li>
                <li class="sidebar-menu-item {{ menuActive('staff.livraison.delivery.queue') }}">
                    <a href="{{ route('staff.livraison.delivery.queue') }}" class="nav-link ">
                        <i class="menu-icon lab la-accessible-icon"></i>
                        <span class="menu-title">@lang("En attente de reception")</span>
                    </a>
                </li>
                        </ul>
                    </div>
                </li>
                 
                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{ menuActive('staff.livraison.manage*', 3) }}">
                        <i class="menu-icon las la-sliders-h"></i>
                        <span class="menu-title">@lang('Gestion des livraisons') </span>
                    </a>
                    <div class="sidebar-submenu {{ menuActive('staff.livraison.manage*', 2) }} ">
                        <ul>
                            <li class="sidebar-menu-item {{ menuActive('staff.livraison.manage.sent.list') }}">
                                <a href="{{ route('staff.livraison.manage.sent.list') }}" class="nav-link ">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Total envoyé')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{ menuActive('staff.livraison.manage.delivered') }}">
                                <a href="{{ route('staff.livraison.manage.delivered') }}" class="nav-link ">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Total Livré')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{ menuActive('staff.livraison.index') }}">
                                <a href="{{ route('staff.livraison.index') }}" class="nav-link ">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Toutes les livraisons')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="sidebar-menu-item {{ menuActive('staff.cooperative.index') }}">
                    <a href="{{ route('staff.cooperative.index') }}" class="nav-link ">
                        <i class="menu-icon las la-university"></i>
                        <span class="menu-title">@lang('Liste des coopératives')</span>
                    </a>
                </li>
                <li class="sidebar-menu-item  {{ menuActive('staff.cash.livraison.income') }}">
                    <a href="{{ route('staff.cash.livraison.income') }}" class="nav-link">
                        <i class="menu-icon las la-wallet"></i>
                        <span class="menu-title">@lang('Recette')</span>
                    </a>
                </li>
                <li class="sidebar-menu-item  {{ menuActive('ticket*') }}">
                    <a href="{{ route('staff.ticket.index') }}" class="nav-link">
                        <i class="menu-icon las la-ticket-alt"></i>
                        <span class="menu-title">@lang('Support Ticket')</span>
                    </a>
                </li>

            </ul>
            <div class="text-center mb-3 text-uppercase">
                <span class="text--primary">{{ __(systemDetails()['name']) }}</span>
                <span class="text--success">@lang('V'){{ systemDetails()['version'] }} </span>
            </div>
        </div>
        <div class="sidebar__menu-wrapper" id="sidebar__menuWrapper">
            <div class="text-center mb-3 text-uppercase">
                <span class="text--primary">{{ __(systemDetails()['name']) }}</span>
                <span class="text--success">@lang('V'){{ systemDetails()['version'] }} </span>
            </div>
        </div>
    </div>
</div>
<!-- sidebar end -->

@push('script')
    <script>
        if ($('li').hasClass('active')) {
            $('#sidebar__menuWrapper').animate({
                scrollTop: eval($(".active").offset().top - 320)
            }, 500);
        }
    </script>
@endpush
