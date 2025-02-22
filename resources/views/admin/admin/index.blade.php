@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
@endsection

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Admins</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline mb-2">
                        <h6 class="card-title mb-0">Admins</h6>
                        <div class="dropdown mb-2">
                            @can('Create Admins')
                                <a href="{{ route('admin.admins.create') }}" class="btn btn-sm btn-primary">Create Admin</a>
                            @endcan
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                            <tr>
                                <th><i class="fas fa-list-ul"></i></th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($admins as $key=>$admin)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $admin['name'] }}</td>
                                <td>{{ $admin['email'] }}</td>
                                <td>{{ $admin->roles()->first()['name'] }}</td>
                                <td>
                                    @if($admin['active'] == 1)
                                        <span class="badge badge-pill badge-success">Active</span>
                                    @else
                                        <span class="badge badge-pill badge-danger">Blocked</span>
                                    @endif
                                </td>
                                <td>
                                    @if($admin->roles()->first()['name'] <> 'Super Admin')
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-primary" type="button" id="dropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Action <i class="icon-lg" data-feather="chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="changeRoleModalLabel">
                                                @can('Change Admins Role')
                                                <button data-toggle="modal" onclick="setParametersForChangingRole('{{ $admin->roles()->first()['id'] }}', {{ $admin['id'] }})" data-target="#changeRoleModal" class="dropdown-item d-flex align-items-center">
                                                    <i data-feather="settings" class="icon-sm mr-2"></i> <span class="">Change Role</span>
                                                </button>
                                                @endcan
                                                @if($admin['active'] == 1)
                                                    @can('Block Admins')
                                                    <a class="dropdown-item d-flex align-items-center" onclick="event.preventDefault(); confirmFormSubmit('adminBlock{{ $admin['id'] }}')" href="{{ route('admin.admins.block', $admin['id']) }}"><i data-feather="user-x" class="icon-sm mr-2"></i> <span class="">Block</span></a>
                                                    <form id="adminBlock{{ $admin['id'] }}" action="{{ route('admin.admins.block', $admin['id']) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                    </form>
                                                    @endcan
                                                @else
                                                    @can('Unblock Admins')
                                                    <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.admins.unblock', $admin['id']) }}" onclick="event.preventDefault(); confirmFormSubmit('adminUnblock{{ $admin['id'] }}')"><i data-feather="user-check" class="icon-sm mr-2"></i> <span class="">Unblock</span></a>
                                                    <form id="adminUnblock{{ $admin['id'] }}" action="{{ route('admin.admins.unblock', $admin['id']) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                    </form>
                                                    @endcan
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    @include('partials.admin.modal.change-role')
@endsection

@section('scripts')
    <script src="{{ asset('assets/vendors/datatables.net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('assets/js/data-table.js') }}"></script>
    <script>
        function setParametersForChangingRole(role, user){
            document.getElementById('oldAdminRole').value = role;
            document.getElementById('adminToChangeRoleID').value = user;
        }
    </script>
@endsection
