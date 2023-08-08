@extends('manager.layouts.app')
@section('panel')
  
    <div class="bg-light p-4 rounded">
        <div class="container mt-4">
            <form method="POST" action="{{ route('manager.roles.update', $role->id) }}">
                @method('patch')
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input value="{{ $role->name }}" 
                        type="text" 
                        class="form-control" 
                        name="name" 
                        placeholder="Name" required>
                </div>
                <label for="permissions" class="form-label">Assigner Permissions</label>

                <table class="table table-striped">
                    <thead>
                        <th scope="col" width="1%"><input type="checkbox" class="checkAll" name="all_permission"></th>
                        <th scope="col" width="20%">Nom permission</th>
                        <th scope="col" width="1%">Guard</th> 
                    </thead>
                    @forelse($permissions as $permission)
                        <tr>
                            <td>
                                <input type="checkbox" 
                                name="permission[{{ $permission->name }}]"
                                value="{{ $permission->name }}"
                                class='permission'
                                {{ in_array($permission->name, $rolePermissions) 
                                    ? 'checked'
                                    : '' }}>
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
                <button type="submit" class="btn btn-primary mt-4 w-100 h-45">Enregister</button>
            </form>
        </div>
    </div>
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