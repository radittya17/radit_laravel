<div class="modal fade employee-profile-modal" id="employeeProfile{{ $employee->id }}" tabindex="-1" aria-labelledby="employeeProfileTitle{{ $employee->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <span class="page-eyebrow">Profil karyawan</span>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body pt-2">
                <div class="employee-profile-summary mb-4">
                    <x-user-avatar :user="$employee" class="employee-profile-avatar" />
                    <div class="min-w-0">
                        <h2 class="h4 fw-bold mb-1 text-truncate" id="employeeProfileTitle{{ $employee->id }}">{{ $employee->name }}</h2>
                        <p class="text-muted mb-2">{{ $employee->jabatan ?: 'Karyawan' }}</p>
                        @if ($employee->is_active)
                            <span class="badge rounded-pill text-bg-success"><i class="bi bi-check-circle-fill me-1"></i>Akun aktif</span>
                        @else
                            <span class="badge rounded-pill text-bg-secondary"><i class="bi bi-pause-circle-fill me-1"></i>Akun nonaktif</span>
                        @endif
                    </div>
                </div>

                <div class="employee-profile-details">
                    <div><span>Email</span><strong>{{ $employee->email }}</strong></div>
                    <div><span>NIP</span><strong>{{ $employee->nip ?: 'Belum diisi' }}</strong></div>
                    <div><span>Nomor telepon</span><strong>{{ $employee->phone ?: 'Belum diisi' }}</strong></div>
                    <div><span>Bergabung</span><strong>{{ $employee->created_at?->translatedFormat('d F Y') ?: '—' }}</strong></div>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0"><button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button></div>
        </div>
    </div>
</div>
