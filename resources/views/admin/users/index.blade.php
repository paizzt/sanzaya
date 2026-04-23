@extends('layouts.app') @section('content')
<div class="container-fluid p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">Manajemen Pengguna</h4>
            <p class="text-muted small mb-0">Kelola akun Staff dan Manajer Marketing/Finance</p>
        </div>
        <button class="btn btn-primary rounded-3 px-4 py-2 fw-semibold">
            <i class="fas fa-user-plus me-2"></i> Tambah User Baru
        </button>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 border-0 text-muted small uppercase">NAMA</th>
                            <th class="py-3 border-0 text-muted small uppercase">EMAIL</th>
                            <th class="py-3 border-0 text-muted small uppercase">ROLE</th>
                            <th class="py-3 border-0 text-muted small uppercase text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-light rounded-circle p-2 me-3 text-center" style="width: 40px">
                                        <i class="fas fa-user text-primary"></i>
                                    </div>
                                    <span class="fw-semibold text-dark">Faisal Faiz</span>
                                </div>
                            </td>
                            <td>faisal@sanzaya.com</td>
                            <td><span class="badge bg-info-subtle text-info rounded-pill px-3">Staff</span></td>
                            <td class="text-center">
                                <button class="btn btn-light btn-sm rounded-3 me-1"><i class="fas fa-edit text-muted"></i></button>
                                <button class="btn btn-light btn-sm rounded-3"><i class="fas fa-trash text-danger"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-light rounded-circle p-2 me-3 text-center" style="width: 40px">
                                        <i class="fas fa-user-tie text-success"></i>
                                    </div>
                                    <span class="fw-semibold text-dark">Rina Marketing</span>
                                </div>
                            </td>
                            <td>rina@sanzaya.com</td>
                            <td><span class="badge bg-success-subtle text-success rounded-pill px-3">Manager</span></td>
                            <td class="text-center">
                                <button class="btn btn-light btn-sm rounded-3 me-1"><i class="fas fa-edit text-muted"></i></button>
                                <button class="btn btn-light btn-sm rounded-3"><i class="fas fa-trash text-danger"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    /* Tambahan Style khusus tabel agar modern */
    .bg-info-subtle { background-color: #e0f7fa; color: #00acc1; }
    .bg-success-subtle { background-color: #e8f5e9; color: #2e7d32; }
    .table thead th { font-weight: 600; font-size: 11px; letter-spacing: 0.5px; }
    .table tbody td { font-size: 14px; border-bottom: 1px solid #f8f9fa; }
</style>
@endsection