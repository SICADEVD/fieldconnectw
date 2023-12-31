<div class="sidebar bg--dark">
    <button class="res-sidebar-close-btn"><i class="las la-times"></i></button>
    <div class="sidebar__inner">
        <div class="sidebar__logo">
            <a href="{{ route('manager.dashboard') }}" class="sidebar__main-logo"><img
                    src="{{ getImage(getFilePath('logoIcon') . '/logo.png') }}" alt="@lang('image')"></a>
        </div>
        <div class="sidebar__menu-wrapper" id="sidebar__menuWrapper">
            <ul class="sidebar__menu">
                <li class="sidebar-menu-item {{ menuActive('manager.dashboard') }}">
                    <a href="{{ route('manager.dashboard') }}" class="nav-link ">
                        <i class="menu-icon las la-home"></i>
                        <span class="menu-title">@lang("Tableau de bord")</span>
                    </a>
                </li>
               
                
                <li class="sidebar-menu-item {{ menuActive('manager.cooperative.index') }}">
                    <a href="{{ route('manager.cooperative.index') }}" class="nav-link ">
                        <i class="menu-icon las la-university"></i>
                        <span class="menu-title">@lang('Liste coopérative')</span>
                    </a>
                </li>
                <li class="sidebar-menu-item {{ menuActive('manager.cooperative.localite*') }}">
                                <a href="{{ route('manager.cooperative.localite.index') }}" class="nav-link">
                                    <i class="menu-icon las la-code-branch"></i>
                                    <span class="menu-title">@lang('Gestion des Localites')</span>
                                </a>
                </li>
                <li class="sidebar-menu-item {{ menuActive('manager.staff.index') }}">
                    <a href="{{ route('manager.staff.index') }}" class="nav-link ">
                        <i class="menu-icon las la-user-friends"></i>
                        <span class="menu-title">@lang('Gestion des Staffs')</span>
                    </a>
                </li>
                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{ menuActive('manager.traca.*', 3) }}">
                        <i class="menu-icon las la-users"></i>
                        <span class="menu-title">@lang('Gestion de la Traçabilites') </span>
                    </a>
                    <div class="sidebar-submenu {{ menuActive('manager.traca.*', 2) }} ">
                        <ul>

                            <li class="sidebar-menu-item {{ menuActive('manager.traca.producteur.index') }}">
                                <a href="{{ route('manager.traca.producteur.index') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Producteurs')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{ menuActive('manager.traca.parcelle.index') }}">
                                <a href="{{ route('manager.traca.parcelle.index') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Parcelles')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{ menuActive('manager.traca.estimation.index') }}">
                                <a href="{{ route('manager.traca.estimation.index') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Estimations')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{ menuActive('manager.livraison.deliveryInQueue') }}">
                                <a href="{{ route('manager.livraison.deliveryInQueue') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Livraison')</span>
                                </a>
                            </li> 

                        </ul>
                    </div>
                </li>

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{ menuActive('manager.suivi*', 3) }}">
                        <i class="menu-icon las la-users"></i>
                        <span class="menu-title">@lang('Gestion de suivis') </span>
                    </a>
                    <div class="sidebar-submenu {{ menuActive('manager.suivi*', 2) }} ">
                        <ul>
 
                           <li class="sidebar-menu-item {{ menuActive('manager.suivi.menage.index') }}">
                                <a href="{{ route('manager.suivi.menage.index') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Menages')</span>
                                </a>
                            </li>

							<li class="sidebar-menu-item {{ menuActive('manager.suivi.parcelles.index') }}">
                                <a href="{{ route('manager.suivi.parcelles.index') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Parcelles')</span>
                                </a>
                            </li>
							
                            <li class="sidebar-menu-item {{ menuActive('manager.suivi.formation.index') }}">
                                <a href="{{ route('manager.suivi.formation.index') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Formations')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{ menuActive('manager.suivi.inspection.index') }}">
                                <a href="{{ route('manager.suivi.inspection.index') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Inspections')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{ menuActive('manager.suivi.application.index') }}">
                                <a href="{{ route('manager.suivi.application.index') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Applications')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{ menuActive('manager.suivi.ssrteclmrs.index') }}">
                                <a href="{{ route('manager.suivi.ssrteclmrs.index') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('SSRTE-CLMRS')</span>
                                </a>
                            </li> 
							 
                        </ul>
                    </div>
                </li>

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{ menuActive('manager.livraison.*', 3) }}">
                        <i class="menu-icon las la-university"></i>
                        <span class="menu-title">@lang('Gestion des livraisons') </span>
                    </a>
                    <div class="sidebar-submenu {{ menuActive('manager.livraison.*', 2) }} ">
                        <ul>

                            <li class="sidebar-menu-item {{ menuActive('manager.livraison.sentQueue') }}">
                                <a href="{{ route('manager.livraison.sentQueue') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang("En attente d'expédition")</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{ menuActive('manager.livraison.dispatch') }}">
                                <a href="{{ route('manager.livraison.dispatch') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Expédiée')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{ menuActive('manager.livraison.upcoming') }}">
                                <a href="{{ route('manager.livraison.upcoming') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Encours')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{ menuActive('manager.livraison.deliveryInQueue') }}">
                                <a href="{{ route('manager.livraison.deliveryInQueue') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('En attente de reception')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{ menuActive('manager.livraison.delivered') }}">
                                <a href="{{ route('manager.livraison.delivered') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang("Livré")</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{ menuActive('manager.livraison.sent') }}">
                                <a href="{{ route('manager.livraison.sent') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Toutes les envoies')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{ menuActive('manager.livraison.index') }}">
                                <a href="{{ route('manager.livraison.index') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Toutes les livraisons')</span>
                                </a>
                            </li>


                        </ul>
                    </div>
                </li>
                <li class="sidebar-menu-item  {{ menuActive('manager.cooperative.income') }}">
                    <a href="{{ route('manager.cooperative.income') }}" class="nav-link">
                        <i class="menu-icon las la-wallet"></i>
                        <span class="menu-title">@lang('Cooperative Revenus')</span>
                    </a>
                </li>
                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{ menuActive('manager.agro*', 3) }}">
                        <i class="menu-icon las la-tree"></i>
                        <span class="menu-title">@lang('Agroforesterie') </span>
                    </a>
                    <div class="sidebar-submenu {{ menuActive('manager.agro*', 2) }} ">
                        <ul>
 
                           <li class="sidebar-menu-item {{ menuActive('manager.agro.evaluation.index') }}">
                                <a href="{{ route('manager.agro.evaluation.index') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Evaluation des besoins')</span>
                                </a>
                            </li>

							<li class="sidebar-menu-item {{ menuActive('manager.agro.approvisionnement.index') }}">
                                <a href="{{ route('manager.agro.approvisionnement.index') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Approvisionnement')</span>
                                </a>
                            </li>
							
                            <li class="sidebar-menu-item {{ menuActive('manager.agro.distribution.index') }}">
                                <a href="{{ route('manager.agro.distribution.index') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Suivi distribution')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{ menuActive('manager.agro.deforestation.index') }}">
                                <a href="{{ route('manager.agro.deforestation.index') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Risques Déforestation')</span>
                                </a>
                            </li>
                            
							 
                        </ul>
                    </div>
                </li>
                <li class="sidebar-menu-item  {{ menuActive('ticket*') }}">
                    <a href="{{ route('manager.ticket.index') }}" class="nav-link">
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
