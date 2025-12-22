@extends('layouts.app')

@section('title', 'Manajemen User')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Data Akun Pengguna</h5>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <i class="bx bx-plus me-1"></i> Tambah User
        </a>
    </div>
    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse ($users as $index => $user)
                <tr>
                    <td>{{ $users->firstItem() + $index }}</td>
                    <td><strong>{{ $user->name }}</strong></td>

                    <td>{{ $user->email }}</td>

                    <td>
                        @foreach ($user->roles as $role)
                        <span class="badge bg-label-primary me-1">{{ $role->name }}</span>
                        @endforeach
                    </td>

                    <td>
                        <div class="d-flex">
                            <a class="btn btn-sm btn-icon btn-info me-2"
                                href="{{ route('admin.users.edit', $user->id) }}" data-bs-toggle="tooltip"
                                data-bs-offset="0,4" data-bs-placement="top" title="Edit User">
                                <i class="bx bx-edit-alt"></i>
                            </a>

                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-icon btn-danger" data-bs-toggle="tooltip"
                                    data-bs-offset="0,4" data-bs-placement="top" title="Hapus User">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data user.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($users->hasPages())
    <div class="card-footer d-flex justify-content-center">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection
