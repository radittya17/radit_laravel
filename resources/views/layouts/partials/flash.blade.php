@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert"><div class="d-flex gap-2"><i class="bi bi-exclamation-circle-fill"></i><div><strong>Data belum dapat disimpan.</strong><ul class="mb-0 mt-2 ps-3">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div></div><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
@endif
@foreach (['success' => 'success', 'error' => 'danger', 'info' => 'info'] as $key => $type)
    @if (session($key))<div class="alert alert-{{ $type }} alert-dismissible fade show" role="alert"><i class="bi bi-{{ $type === 'success' ? 'check-circle-fill' : ($type === 'danger' ? 'exclamation-octagon-fill' : 'info-circle-fill') }} me-2"></i>{{ session($key) }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>@endif
@endforeach
