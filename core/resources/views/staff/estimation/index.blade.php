@extends('staff.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
        <div class="card b-radius--10 mb-3">
                <div class="card-body">
                    <form action="">
                        <div class="d-flex flex-wrap gap-4">
                            <input type="hidden" name="table" value="estimations"/>
                            <div class="flex-grow-1">
                                <label>@lang('Recherche par Mot(s) clé(s)')</label>
                                <input type="text" name="search" value="{{ request()->search }}" class="form-control">
                            </div>
                            <div class="flex-grow-1">
                                <label>@lang('Localité')</label>
                                <select name="localite" class="form-control">
                                    <option value="">@lang('Toutes')</option>
                                    @foreach($localites as $local)
                                    <option value="{{ $local->id }}">{{ $local->nom }}</option>
                                    @endforeach 
                                </select>
                            </div> 
                            <div class="flex-grow-1">
                                <label>@lang('Statut')</label>
                                <select name="status" class="form-control">
                                    <option value="">@lang('Tous')</option>
                                    <option value="0">@lang('Non atteint')</option>
                                    <option value="1">@lang('Atteint')</option>
                                </select>
                            </div>
                            <div class="flex-grow-1">
                                <label>@lang('Date')</label>
                                <input name="date" type="text" class="date form-control" placeholder="@lang('Date de début - Date de fin')" autocomplete="off" value="{{ request()->date }}">
                            </div>
                            <div class="flex-grow-1 align-self-end">
                                <button class="btn btn--primary w-100 h-45"><i class="fas fa-filter"></i> @lang('Filter')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card b-radius--10 ">
                <div class="card-body  p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr> 
                                    <th>@lang('Localite')</th> 
                                    <th>@lang('Producteur')</th>
                                    <th>@lang('Code Parcelle')</th>
                                    <th>@lang('Superficie')</th>
                                    <th>@lang('Rendement des 3 carrés A, B, C')</th>
                                    <th>@lang('Rendement final')</th> 
                                    <th>@lang('Estimation de production')</th> 
                                    <th>@lang('Production annuelle')</th>  
                                    <th>@lang("Date d'estimation")</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($estimations as $estimation)
                                    <tr>
                                        <td>
                                            <span class="fw-bold">{{ $estimation->parcelle->producteur->localite->nom }}</span>
                                        </td>
                                        <td> 
                                            <span class="small">
                                            {{ $estimation->parcelle->producteur->nom }} {{ $estimation->parcelle->producteur->prenoms }}
                                            </span>
                                        </td>
                                        <td>
                                            <span> <a href="{{ route('staff.traca.estimation.edit', $estimation->id) }}">
                                                    <span>@</span>{{ $estimation->parcelle->codeParc }}
                                                </a></span>
                                        </td>
                                        
                                        <td>
                                            <span>{{ $estimation->parcelle->superficie }}</span>
                                        </td>
                                        <td>
                                            <span>{{ $estimation->Q }}</span>
                                        </td>
                                        <td>
                                            <span>{{ $estimation->RF }}</span>
                                        </td>
                                        <td>
                                            <span>{{ $estimation->EsP }}</span>
                                        </td>
                                        <td>
                                            <span>{{ $estimation->productionAnnuelle }}</span>
                                        </td>
                                        <td>
                                            <span class="d-block">{{ showDateTime($estimation->date_estimation) }}</span>
                                            <span>{{ diffForHumans($estimation->date_estimation) }}</span>
                                        </td>
                                        <td> @php echo $estimation->statusEstim; @endphp </td>
                                        <td>
                                         
                                            <button type="button" class="btn btn-sm btn-outline--primary" data-bs-toggle="dropdown" aria-expanded="false"><i
                                                    class="las la-ellipsis-v"></i>@lang('Action')
                                             </button>
                                            <div class="dropdown-menu p-0">
                                            @can('staff.traca.estimation.edit')
                                                <a href="{{ route('staff.traca.estimation.edit', $estimation->id) }}"
                                                    class="dropdown-item"><i class="la la-pen"></i>@lang('Edit')</a> 
                                            @endcan
                                            @can('staff.traca.estimation.status')
                                                @if ($estimation->status == Status::DISABLE)
                                                    <button type="button" class="confirmationBtn  dropdown-item"
                                                        data-action="{{ route('staff.traca.estimation.status', $estimation->id) }}"
                                                        data-question="@lang('Are you sure to enable this estimation?')">
                                                        <i class="la la-eye"></i> @lang('Atteint')
                                                    </button>
                                                @else
                                                    <button type="button" class="confirmationBtn dropdown-item"
                                                        data-action="{{ route('staff.traca.estimation.status', $estimation->id) }}"
                                                        data-question="@lang('Are you sure to disable this estimation?')">
                                                        <i class="la la-eye-slash"></i> @lang('Non atteint')
                                                    </button>
                                                @endif 
                                            @endcan
                                                
                                            </div>
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
                @if ($estimations->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($estimations) }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div id="typeModel" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Importer des estimations')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i> </button>
                </div>
                <form action="{{ route('staff.traca.estimation.uploadcontent') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">   
                        <p>Fichier d'exemple à utiliser :<a href="{{ asset('assets/estimation-import-exemple.xlsx') }}" target="_blank">@lang('estimation-import-exemple.xlsx')</a></p>
                     

        <div class="form-group row">
            {{ Form::label(__('Fichier(.xls, .xlsx)'), null, ['class' => 'control-label col-sm-4']) }}
            <div class="col-xs-12 col-sm-8 col-md-8">
            <input type="file" name="uploaded_file" accept=".xls, .xlsx" class="form-control dropify-fr" placeholder="Choisir une image" id="image" required> 
        </div>
    </div>
    
 
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary w-100 h-45 ">@lang('Envoyer')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>  
    <x-confirmation-modal />
@endsection

@push('breadcrumb-plugins')
    <x-search-form placeholder="Search here..." />
    @can('staff.traca.estimation.create')
        <a href="{{ route('staff.traca.estimation.create') }}" class="btn  btn-outline--primary h-45 addNewCooperative">
            <i class="las la-plus"></i>@lang("Ajouter nouveau")
        </a>
    @endcan
    @can('staff.traca.estimation.exportExcel.estimationAll)')
        <a class="btn  btn-outline--info h-45 addType"><i class="las la-cloud-upload-alt"></i> Importer des Estimations</a>
        <a href="{{ route('staff.traca.estimation.exportExcel.estimationAll') }}" class="btn  btn-outline--warning h-45"><i class="las la-cloud-download-alt"></i> Exporter en Excel</a>
    @endcan
@endpush
@push('style')
    <style>
        .table-responsive {
            overflow-x: auto;
        }
    </style>
@endpush
@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/fcadmin/css/vendor/datepicker.min.css') }}">
@endpush
@push('script-lib')
    <script src="{{ asset('assets/fcadmin/js/vendor/datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/fcadmin/js/vendor/datepicker.en.js') }}"></script>
@endpush
@push('script')
    <script>
        (function($) {
            "use strict";

            $('.addType').on('click', function() {
                $('#typeModel').modal('show');
            });
            
            $('.date').datepicker({
                maxDate:new Date(),
                range:true,
                multipleDatesSeparator:"-",
                language:'en'
            });

            let url=new URL(window.location).searchParams;
            if(url.get('localite') != undefined && url.get('localite') != ''){
                $('select[name=localite]').find(`option[value=${url.get('localite')}]`).attr('selected',true);
            }
            if(url.get('status') != undefined && url.get('status') != ''){
                $('select[name=status]').find(`option[value=${url.get('status')}]`).attr('selected',true);
            }

        })(jQuery)
    </script>
@endpush

