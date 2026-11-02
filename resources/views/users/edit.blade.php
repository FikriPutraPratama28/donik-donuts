@extends('layouts.app')
@section('title', 'Edit Karyawan')
@section('page-title', 'Edit Karyawan')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card" style="border-radius:16px;border:1px solid #e5e7eb">
            <div class="card-header" style="background:transparent;border-color:#f3f4f6;font-weight:700;font-size:15px;padding:18px 24px">
                <i class="bi bi-pencil me-2 text-primary"></i>Edit: {{ $user->name }}
            </div>
            <div class="card-body p-4">
                <form action="{{ route('users.update', $user) }}" method="POST">
                    @csrf @method('PUT')
                    @include('users._form', ['editMode' => true])
                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-check-lg me-1"></i>Update
                        </button>
                        <a href="{{ route('users.show', $user) }}" class="btn btn-light px-4">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
