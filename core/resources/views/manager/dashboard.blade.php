@extends('manager.layouts.app')
@section('panel')
    <div class="row gy-4">
        <div class="col-xxl-4 col-sm-6">
            <div class="card bg--purple has-link box--shadow2">
                <a href="{{ route('manager.livraison.sentQueue') }}" class="item-link"></a>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <i class="las la-hourglass-start f-size--56"></i>
                        </div>
                        <div class="col-8 text-end">
                            <span class="text-white text--small">@lang("Livraison en attente")</span>
                            <h2 class="text-white">{{ $livraisonQueueCount }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->

        <div class="col-xxl-4 col-sm-6">
            <div class="card bg--cyan has-link box--shadow2">
                <a href="{{ route('manager.livraison.upcoming') }}" class="item-link"></a>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <i class="las la-history f-size--56"></i>
                        </div>
                        <div class="col-8 text-end">
                            <span class="text-white text--small">@lang('Livraison encours')</span>
                            <h2 class="text-white">{{ $upcomingCount }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->

        <div class="col-xxl-4 col-sm-6">
            <div class="card bg--pink has-link box--shadow2">
                <a href="{{ route('manager.livraison.deliveryInQueue') }}" class="item-link"></a>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <i class="lab la-accessible-icon f-size--56"></i>
                        </div>
                        <div class="col-8 text-end">
                            <span class="text-white text--small">@lang('En attente de reception')</span>
                            <h2 class="text-white">{{ $deliveryQueueCount }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
        <div class="col-xxl-4 col-sm-6">
            <div class="card bg--green has-link box--shadow2">
                <a href="{{ route('manager.livraison.sent') }}" class="item-link"></a>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <i class="las la-check-double f-size--56"></i>
                        </div>
                        <div class="col-8 text-end">
                            <span class="text-white text--small">@lang("Total envoyé")</span>
                            <h2 class="text-white">{{ $totalSentCount }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->

        <div class="col-xxl-4 col-sm-6">
            <div class="card bg--deep-purple has-link box--shadow2">
                <a href="{{ route('manager.livraison.delivered') }}" class="item-link"></a>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <i class="las  la-list-alt f-size--56"></i>
                        </div>
                        <div class="col-8 text-end">
                            <span class="text-white text--small">@lang("Total Livré")</span>
                            <h2 class="text-white">{{ $livraisonDelivered }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->

        <div class="col-xxl-4 col-sm-6">
            <div class="card bg--teal has-link box--shadow2">
                <a href="{{ route('manager.livraison.index') }}" class="item-link"></a>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <i class="las  la-shipping-fast f-size--56"></i>
                        </div>
                        <div class="col-8 text-end">
                            <span class="text-white text--small">@lang('Toutes les livraisons')</span>
                            <h2 class="text-white">{{ $livraisonInfoCount }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
        <div class="col-xxl-4 col-sm-6">
            <div class="card bg--primary has-link overflow-hidden box--shadow2">
                <a href="{{ route('manager.staff.index') }}" class="item-link"></a>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <i class="las la-user-friends f-size--56"></i>
                        </div>
                        <div class="col-8 text-end">
                            <span class="text-white text--small">@lang('Total Staff')</span>
                            <h2 class="text-white">{{ $totalStaffCount }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->

        <div class="col-xxl-4 col-sm-6">
            <div class="card bg--lime has-link box--shadow2">
                <a href="{{ route('manager.cooperative.index') }}" class="item-link"></a>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <i class="las la-university f-size--56"></i>
                        </div>
                        <div class="col-8 text-end">
                            <span class="text-white text--small">@lang(' Total Coopérative')</span>
                            <h2 class="text-white">{{ $cooperativeCount }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
        <div class="col-xxl-4 col-sm-6">
            <div class="card bg--orange has-link box--shadow2">
                <a href="{{ route('manager.cooperative.income') }}" class="item-link"></a>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <i class="las la-money-bill-wave f-size--56"></i>
                        </div>
                        <div class="col-8 text-end">
                            <span class="text-white text--small">@lang("Total Recette")</span>
                            <h2 class="text-white">{{ showAmount($cooperativeIncome) }} {{ $general->cur_sym }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->





    </div><!-- row end-->

    <div class="row mt-50">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang("Coopérative Expéditeur - Staff")</th>
                                    <th>@lang('Coopérative Destinataire - Magasin')</th>
                                    <th>@lang("Montant - Numéro Commande")</th>
                                    <th>@lang('Creations Date')</th>
                                    <th>@lang("Paiement Status")</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($livraisonInfos as $livraisonInfo)
                                    <tr>
                                        <td>
                                            <span>{{ __($livraisonInfo->senderCooperative->name) }}</span><br>
                                            <a href="{{ route('manager.staff.edit', encrypt($livraisonInfo->senderStaff->id)) }}"><span>@</span>{{ __($livraisonInfo->senderStaff->username) }}</a>
                                        </td>

                                        <td>
                                            <span>
                                                @if ($livraisonInfo->receiver_cooperative_id)
                                                    {{ __($livraisonInfo->receiverCooperative->name) }}
                                                @else
                                                    @lang('N/A')
                                                @endif
                                            </span>
                                            <br>
                                            @if ($livraisonInfo->receiver_staff_id)
                                                <a href="{{ route('manager.staff.edit', encrypt($livraisonInfo->receiverStaff->id)) }}"><span>@</span>{{ __($livraisonInfo->receiverStaff->username) }}</a>
                                            @else
                                                <span>@lang('N/A')</span>
                                            @endif
                                        </td>

                                        <td>
                                            <span class="fw-bold">{{ showAmount(@$livraisonInfo->paymentInfo->final_amount) }}
                                                {{ __($general->cur_text) }}</span><br>
                                            <span>{{ $livraisonInfo->code }}</span>
                                        </td>

                                        <td>
                                            <span>{{ showDateTime($livraisonInfo->created_at, 'd M Y') }}</span><br>
                                            <span>{{ diffForHumans($livraisonInfo->created_at) }}</span>
                                        </td>

                                        <td>
                                            @if ($livraisonInfo->paymentInfo->status == Status::PAYE)
                                                <span class="badge badge--success">@lang('Paye')</span>
                                            @elseif($livraisonInfo->paymentInfo->status == Status::IMPAYE)
                                                <span class="badge badge--danger">@lang('Impaye')</span>
                                            @endif
                                        </td>

                                        <td>
                                            @if ($livraisonInfo->status == Status::COURIER_QUEUE)
                                                @if (auth()->user()->cooperative_id == $livraisonInfo->sender_cooperative_id)
                                                    <span class="badge badge--danger">@lang('Sent In Queue')</span>
                                                @else
                                                    <span></span>
                                                @endif
                                            @elseif($livraisonInfo->status == Status::COURIER_DISPATCH)
                                                @if (auth()->user()->cooperative_id == $livraisonInfo->sender_cooperative_id)
                                                    <span class="badge badge--warning">@lang("Expédié")</span>
                                                @else
                                                    <span class="badge badge--warning">@lang('Upcoming')</span>
                                                @endif
                                            @elseif($livraisonInfo->status == Status::COURIER_DELIVERYQUEUE)
                                                <span class="badge badge--primary">@lang('Confirmation de reception en attente')</span>
                                            @elseif($livraisonInfo->status == Status::COURIER_DELIVERED)
                                                <span class="badge badge--success">@lang("Livré")</span>
                                            @endif
                                        </td>

                                        <td>
                                            <a href="{{ route('manager.livraison.invoice', encrypt($livraisonInfo->id)) }}"
                                                title="" class="btn btn-sm btn-outline--info"><i
                                                    class="las la-file-invoice"></i> @lang("Facture")</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('breadcrumb-plugins')
    <div class="d-flex flex-wrap justify-content-end">
        <h3>{{ __(auth()->user()->cooperative->name) }}</h3>
    </div>
@endpush
