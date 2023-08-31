@extends('manager.layouts.app')
@section('panel')
    <div class="row mb-none-30">
        <div class="col-lg-12 col-md-12 mb-30">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('manager.roles.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nom de rôle</label>
                            <input value="{{ old('name') }}" 
                                type="text" 
                                class="form-control" 
                                name="name" 
                                placeholder="Name" required>
                        </div>
                        <label for="permissions" class="form-label">Attribuer permission</label>
                        <table class="table table-striped">
                            <thead>
                                <th scope="col" width="1%"><input type="checkbox" class="checkAll"  name="all_permission"></th>
                                <th scope="col" width="20%">Nom</th>
                                <th scope="col" width="1%">Guard</th> 
                            </thead>
                            @forelse($permissions as $permission)
                                <tr>
                                    <td>
                                        <input type="checkbox" 
                                        name="permission[{{ $permission->name }}]"
                                        value="{{ $permission->name }}"
                                        class='permission'>
                                    </td>
                                    <td>{{ $permission->name }}</td>
                                    <td>{{ $permission->guard_name }}</td>
                                </tr>
                            @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                            @endforelse
                        </table>
                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn--primary w-100 h-45 "> @lang('Envoyer')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('[name="all_permission"]').on('click', function() {

                if($(this).is(':checked')) {
                    $.each($('.permission'), function() {
                        $(this).prop('checked',true);
                    });
                } else {
                    $.each($('.permission'), function() {
                        $(this).prop('checked',false);
                    });
                }
                
            });
        });
    </script> 
@endsection
@push('breadcrumb-plugins')
    <x-back route="{{ route('manager.roles.index') }}" />
@endpush
@push('script')
    <script type="text/javascript">
        (function($) {
            "use strict";
           
            $(".permission").on('change', function(e) {
                let totalLength = $(".permission").length;
                let checkedLength = $(".permission:checked").length;
                if (totalLength == checkedLength) {
                    $('.checkAll').prop('checked', true);
                } else {
                    $('.checkAll').prop('checked', false);
                }
                if (checkedLength) {
                    $('.dispatch').removeClass('d-none')
                } else {
                    $('.dispatch').addClass('d-none')
                }
            });

            $('.checkAll').on('change', function() {
                if ($('.checkAll:checked').length) {
                    $('.permission').prop('checked', true);
                } else {
                    $('.permission').prop('checked', false);
                }
                $(".permission").change();
            });

        })(jQuery)
    </script>
@endpush