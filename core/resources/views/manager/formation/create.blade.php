@extends('manager.layouts.app')
@section('panel')
    <div class="row mb-none-30">
        <div class="col-lg-12 mb-30">
            <div class="card">
                <div class="card-body"> 
                    {!! Form::open(array('route' => ['manager.suivi.formation.store'],'method'=>'POST','class'=>'form-horizontal', 'id'=>'flocal', 'enctype'=>'multipart/form-data')) !!} 
                        
                            <div class="form-group row">
                                <label class="col-sm-4 control-label">@lang('Selectionner une localite')</label>
                                <div class="col-xs-12 col-sm-8">
                                <select class="form-control" name="localite" id="localite" required>
                                    <option value="">@lang('Selectionner une option')</option>
                                    @foreach($localites as $localite)
                                        <option value="{{ $localite->id }}" @selected(old('localite'))>
                                            {{ $localite->nom }}</option>
                                    @endforeach
                                </select>
                                </div>
                            </div>  
                       
                            <div class="form-group row">
                                <label class="col-sm-4 control-label">@lang("Les producteurs présents à la formation")</label>
                                <div class="col-xs-12 col-sm-8">
                                <select class="form-control select2-multi-select" name="producteur[]" id="producteur" multiple required>
                                    <option value="">@lang('Selectionner une option')</option>
                                    @foreach($producteurs as $producteur)
                                        <option value="{{ $producteur->id }}" data-chained="{{ $producteur->localite->id }}" @selected(old('producteur'))>
                                            {{ $producteur->nom }} {{ $producteur->prenoms }}</option>
                                    @endforeach
                                </select>
                                </div>
                            </div>

                            <div class="form-group row">
        <?php echo Form::label(__("Nom des visiteurs ayant participer à la formation"), null, ['class' => 'col-sm-4 control-label']); ?>
        <div class="col-xs-12 col-sm-8">
            <select name="visiteurs[]" id="visiteurs" class="form-control select2-auto-tokenize" multiple>
                                                   <option value="null" disabled>@lang('Entrer un nom')</option>
                                                </select>
        </div>
    </div>
      <hr class="panel-wide">
    <div class="form-group row">
        <?php echo Form::label(__("Lieu de la formation"), null, ['class' => 'col-sm-4 control-label']); ?>
        <div class="col-xs-12 col-sm-8">
            <?php echo Form::select('lieu_formation', ["Dans le ménage"=>"Dans le ménage","Place Publique"=>"Place Publique","Champs Ecole"=>"Champs Ecole"], null, array('placeholder' => __('Selectionner une option'),'class' => 'form-control', 'id'=>'lieu_formations','required'=>'required')); ?>
        </div>
    </div>
    <div class="form-group row">
        <?php echo Form::label(__("Type de formations"), null, ['class' => 'col-sm-4 control-label']); ?>
        <div class="col-xs-12 col-sm-8">
               <?php echo Form::select('type_formation', $typeformations, null, array('placeholder' => __('Selectionner une option'),'class' => 'form-control type_formations','id'=>'typeformation','required'=>'required')); ?>
        </div>
    </div>

             <div class="form-group row">
             <?php echo Form::label(__("Thème de la formation"), null, ['class' => 'col-sm-4 control-label']); ?>
             <div class="col-xs-12 col-sm-8">
             <select class="form-control select2-multi-select" name="theme[]" id="theme" multiple required>
                                    <option value="">@lang('Selectionner une option')</option>
                                    @foreach($themes as $theme)
                                        <option value="{{ $theme->id }}" data-chained="{{ $theme->type_formation_id }}" @selected(old('theme'))>
                                            {{ $theme->nom }} </option>
                                    @endforeach
                                </select> 
             </div>
    </div>

    <hr class="panel-wide">

    <div class="form-group row">
        <?php echo Form::label(__("Staff ayant dispensé la formation"), null, ['class' => 'col-sm-4 control-label']); ?>
        <div class="col-xs-12 col-sm-8"> 
             <select class="form-control" name="staff" id="staff" required>
                                    <option value="">@lang('Selectionner une option')</option>
                                    @foreach($staffs as $staff)
                                        <option value="{{ $staff->id }}"  @selected(old('staff'))>
                                            {{ $staff->lastname }} {{ $staff->firstname }}</option>
                                    @endforeach
                                </select>  
        </div>
    </div>
    <div class="form-group row">
        <?php echo Form::label(__("Date de la formation"), null, ['class' => 'col-sm-4 control-label required']); ?>
        <div class="col-xs-12 col-sm-8">
            <?php echo Form::date('date_formation', null,array('class' => 'form-control dateactivite','required'=>'required') ); ?>
        </div>
    </div>
    <div class="form-group row">
                     <?php echo Form::label(__('Photo de la formation'), null, ['class' => 'col-sm-4 control-label']); ?>
                     <div class="col-xs-12 col-sm-8">
                           <input type="file" name="photo_formation" class="form-control dropify-fr">
                 </div>
     </div>

<hr class="panel-wide">
 
                        <div class="form-group row">
                            <button type="submit" class="btn btn--primary w-100 h-45"> @lang('Envoyer')</button>
                        </div>
                        {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>


@endsection

@push('breadcrumb-plugins')
    <x-back route="{{ route('manager.suivi.formation.index') }}" />
@endpush

@push('script')
<script type="text/javascript">
    $("#producteur").chained("#localite");
    $("#theme").chained("#typeformation");
 </script>
@endpush