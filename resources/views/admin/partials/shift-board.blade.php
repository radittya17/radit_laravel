<div class="row g-3">
    @foreach ($shiftGroups as $shift)
        <div class="col-md-4">
            <section class="card shift-card h-100" data-shift="{{ $shift['key'] }}">
                <div class="card-body p-3 p-lg-4">
                    <div class="d-flex align-items-start justify-content-between mb-3">
                        <div><span class="shift-card__eyebrow">{{ $shift['hours'] }} WIB</span><h3 class="h5 fw-bold mb-0 mt-1">{{ $shift['name'] }}</h3></div>
                        <span class="shift-card__icon"><i class="bi {{ $shift['icon'] }}"></i></span>
                    </div>
                    <div class="shift-card__count">{{ $shift['count'] }} <span>orang hadir</span></div>
                    <div class="shift-card__attendances">
                        @forelse ($shift['attendances'] as $attendance)
                            <div class="shift-attendance">
                                <x-user-avatar :user="$attendance->user" />
                                <div class="min-w-0 flex-grow-1"><strong class="d-block text-truncate">{{ $attendance->user->name }}</strong><small class="text-muted">{{ $attendance->user->jabatan ?: 'Karyawan' }}</small></div>
                                <time class="shift-attendance__time">{{ \Carbon\Carbon::parse($attendance->time_in)->format('H:i') }}</time>
                            </div>
                        @empty
                            <div class="shift-card__empty"><i class="bi bi-hourglass"></i><span>Belum ada absensi</span></div>
                        @endforelse
                    </div>
                    @if ($shift['count'] > 5)
                        <small class="text-muted d-block mt-2">+{{ $shift['count'] - 5 }} absensi lainnya</small>
                    @endif
                </div>
            </section>
        </div>
    @endforeach
</div>