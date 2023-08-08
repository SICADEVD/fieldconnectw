@extends('manager.layouts.app')
@section('panel')
<div class="row mb-none-30">
    <div class="col-lg-12 col-md-12 mb-30">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('manager.permissions.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="form-group col-lg-12">
                            <label>@lang('Permission')</label>
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                required>
                        </div>
                        
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn--primary w-100 h-45 "> @lang('Envoyer')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('breadcrumb-plugins')
    <x-back route="{{ route('manager.permissions.index') }}"/>
@endpush