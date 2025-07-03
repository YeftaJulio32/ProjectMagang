<div class="card card-bg-dark border-0">
    <div class="card-body">
        <h5 class="fw-bold border-bottom border-secondary pb-2 mb-4">Informasi Pengguna</h5>
        <div class="row mb-3">
            <div class="col-sm-4 text-muted">Nama Lengkap</div>
            <div class="col-sm-8">{{ $user->name }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-4 text-muted">Email</div>
            <div class="col-sm-8">{{ $user->email }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-4 text-muted">Peran</div>
            <div class="col-sm-8"><span class="badge bg-secondary">Pengguna</span></div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-4 text-muted">Tanggal Bergabung</div>
            <div class="col-sm-8">{{ $user->created_at->translatedFormat('d F Y') }}</div>
        </div>
    </div>
</div>
