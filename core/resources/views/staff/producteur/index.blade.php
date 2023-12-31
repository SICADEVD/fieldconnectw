@extends('staff.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
        <div class="card b-radius--10 mb-3">
                <div class="card-body">
                    <form action="">
                        <div class="d-flex flex-wrap gap-4">
                            <input type="hidden" name="table" value="producteurs"/>
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
                                    <option value="Candidat">Candidat</option>
                                    <option value="Certifie">Certifie</option>
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
                                    <th>@lang('Code Prod')</th>
                                    <th>@lang('Nom')</th>
                                    <th>@lang('Prenoms')</th>
                                    <th>@lang('Sexe')</th>
                                    <th>@lang('Nationalite')</th>
                                    <th>@lang('Telephone')</th>
                                    <th>@lang('Ajoutée le')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($producteurs as $producteur)
                                    <tr>
                                        <td>
                                            <span class="fw-bold">{{ __($producteur->localite->nom) }}</span>
                                        </td>
                                        <td>
                                            <span>{{ $producteur->codeProd }}</span>
                                        </td>
                                        <td> 
                                            <span class="small">
                                                <a href="{{ route('staff.traca.producteur.edit', $producteur->id) }}">
                                                    <span>@</span>{{$producteur->nom }}
                                                </a>
                                            </span>
                                        </td>
                                        <td>
                                            <span>{{ $producteur->prenoms }}</span>
                                        </td>
                                        <td>
                                            <span>{{ $producteur->sexe }}</span>
                                        </td>
                                        <td>
                                            <span>{{ $producteur->nationalite }}</span>
                                        </td>
                                        <td>
                                            <span>{{ $producteur->phone1 }}</span>
                                        </td>
                                        <td>
                                            <span class="d-block">{{ showDateTime($producteur->created_at) }}</span>
                                            <span>{{ diffForHumans($producteur->created_at) }}</span>
                                        </td>
                                        <td> @php echo $producteur->statusBadge; @endphp </td>
                                        <td>
                                        @can('staff.traca.producteur.infos')
                                            <a href="{{route('staff.traca.producteur.infos', encrypt($producteur->id))}}" class="icon-btn btn--info ml-1">@lang('Infos producteur')</a>
                                        @endcan

                                            <button type="button" class="btn btn-sm btn-outline--primary" data-bs-toggle="dropdown" aria-expanded="false"><i
                                                    class="las la-ellipsis-v"></i>@lang('Action')
                                             </button>
                                            <div class="dropdown-menu p-0">
                                                @can('staff.traca.producteur.edit')
                                                    <a href="{{ route('staff.traca.producteur.edit', $producteur->id) }}"
                                                        class="dropdown-item"><i class="la la-pen"></i>@lang('Edit')</a> 
                                                @endcan
                                                @can('staff.traca.producteur.status')
                                                    @if ($producteur->status == Status::DISABLE)
                                                        <button type="button" class="confirmationBtn  dropdown-item"
                                                            data-action="{{ route('staff.traca.producteur.status', $producteur->id) }}"
                                                            data-question="@lang('Are you sure to enable this producteur?')">
                                                            <i class="la la-eye"></i> @lang('Activé')
                                                        </button>
                                                    @else
                                                        <button type="button" class="confirmationBtn dropdown-item"
                                                            data-action="{{ route('staff.traca.producteur.status', $producteur->id) }}"
                                                            data-question="@lang('Are you sure to disable this producteur?')">
                                                            <i class="la la-eye-slash"></i> @lang('Désactivé')
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
                @if ($producteurs->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($producteurs) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div id="typeModel" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Importer des producteurs')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i> </button>
                </div>
                <form action="{{ route('staff.traca.producteur.uploadcontent') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">   
                        <p>Fichier d'exemple à utiliser :<a href="{{ asset('assets/producteur-import-exemple.xlsx') }}" target="_blank">@lang('producteur-import-exemple.xlsx')</a></p>
                    <div class="alert alert-danger">
          <p><i class="las la-exclamation-triangle"></i> Consignes à respecter avant de charger le fichier :</p>
              <ul>
                <li>Assurez-vous que les Localités qui sont dans le fichier sont déjà enregistrées dans la plateforme    dépuis la rubrique Localités</li>
                <li>Assurez-vous que les Localites qui sont dans le fichier ont été affecté soit aux ADG, PR ou COACHS, DELEGUES,...</li>
              </ul>
          </div>
                    <div class="form-group row">
                                <label class="col-sm-4 control-label">@lang('Type de Formation')</label>
                                <div class="col-xs-12 col-sm-8">
                                <select class="form-control" name="coop_id" required>
                                    <option value="">@lang('Selectionner une option')</option>
                                    @foreach($cooperatives as $coop)
                                        <option value="{{ $coop->id }}" @selected(old('cooperative'))>
                                            {{ __($coop->name) }}</option>
                                    @endforeach
                                </select>
                                </div>
                            </div> 

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
    @can('staff.traca.producteur.create')
        <a href="{{ route('staff.traca.producteur.create') }}" class="btn  btn-outline--primary h-45">
            <i class="las la-plus"></i>@lang("Ajouter nouveau")
        </a>
    @endcan
    @can('staff.traca.producteur.create')
        <a class="btn  btn-outline--info h-45 addType"><i class="las la-cloud-upload-alt"></i> Importer des Producteurs</a>
        <a href="{{ route('staff.traca.producteur.exportExcel.producteurAll') }}" class="btn  btn-outline--warning h-45"><i class="las la-cloud-download-alt"></i> Exporter en Excel</a>
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
