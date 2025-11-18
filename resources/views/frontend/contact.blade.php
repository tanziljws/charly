@extends('layouts.frontend')

@section('title', 'Kontak - SMKN 4 BOGOR')
@section('description', 'Hubungi kami untuk informasi lebih lanjut tentang SMKN 4 BOGOR')

@push('styles')
<style>
    .contact-hero { border: none; border-radius: 16px; box-shadow: 0 12px 30px rgba(0,0,0,.08); }
    .contact-hero .card-body { background: linear-gradient(135deg, #0ea5e9 0%, #0f172a 100%); color: #fff; border-radius: 16px; }
    .contact-card { border: none; border-radius: 16px; box-shadow: 0 12px 30px rgba(0,0,0,.08); transition: transform .3s ease, box-shadow .3s ease; }
    .contact-card:hover { transform: translateY(-4px); box-shadow: 0 18px 40px rgba(0,0,0,.12); }
    .reveal { opacity: 0; transform: translateY(24px); transition: opacity .6s ease, transform .6s ease; }
    .reveal.visible { opacity: 1; transform: translateY(0); }
    .char-counter { font-size: .85rem; color: #64748b; }
    .contact-list li { display: flex; gap: .75rem; align-items: flex-start; padding: .35rem 0; }
    .contact-icon { width: 40px; height: 40px; border-radius: 50%; background: #e0f2fe; color: #0369a1; display: grid; place-items: center; }
    .map-embed { height: 320px; border: 0; width: 100%; }
    @media (max-width: 768px) { .map-embed { height: 260px; } }
</style>
@endpush

@section('content')
<div class="container py-4">
    <!-- Page Header -->
    <div class="row mb-4 reveal">
        <div class="col-12">
            <div class="card contact-hero">
                <div class="card-body text-center py-5">
                    <h1 class="h2 mb-3">
                        <i class="fas fa-envelope text-primary me-2"></i>Hubungi SMKN 4 BOGOR
                    </h1>
                    <p class="mb-0">Kami siap membantu dan menjawab pertanyaan Anda tentang SMKN 4 BOGOR</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Contact Form -->
        <div class="col-lg-7 reveal">
            <div class="card contact-card">
                <div class="card-header bg-white">
                    <h5 class="mb-0 d-flex align-items-center"><i class="fas fa-paper-plane me-2 text-primary"></i>Kirim Pesan</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Terjadi kesalahan:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('contact.store') }}" id="contactForm" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                                       id="nama" name="nama" value="{{ old('nama') }}" required>
                                @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="subjek" class="form-label">Subjek <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('subjek') is-invalid @enderror" 
                                   id="subjek" name="subjek" value="{{ old('subjek') }}" required>
                            @error('subjek')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="pesan" class="form-label">Pesan <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('pesan') is-invalid @enderror" id="pesan" name="pesan" rows="6" required>{{ old('pesan') }}</textarea>
                            @error('pesan')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="d-flex justify-content-between">
                                <div class="text-muted">Maksimal 1000 karakter</div>
                                <div class="char-counter" id="charCounter">0/1000</div>
                            </div>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                                <span class="loading" style="display:none"></span>
                                <i class="fas fa-paper-plane me-2"></i>Kirim Pesan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Contact Info -->
        <div class="col-lg-5 reveal">
            <div class="card contact-card mb-4">
                <div class="card-body">
                    <h5 class="mb-3"><i class="fas fa-address-book me-2 text-primary"></i>Kontak Sekolah</h5>
                    <ul class="list-unstyled contact-list mb-3">
                        <li><div class="contact-icon"><i class="fas fa-map-marker-alt"></i></div>
                            <div><div class="fw-semibold">Alamat</div>Jl. Pendidikan No. 45, Madesu</div>
                        </li>
                        <li><div class="contact-icon"><i class="fas fa-phone"></i></div>
                            <div><div class="fw-semibold">Telepon</div>(021) 5555-0123</div>
                        </li>
                        <li><div class="contact-icon"><i class="fas fa-envelope"></i></div>
                            <div><div class="fw-semibold">Email</div>info@smamadesu1.sch.id</div>
                        </li>
                        <li><div class="contact-icon"><i class="fab fa-whatsapp"></i></div>
                            <div><div class="fw-semibold">WhatsApp</div><a href="https://wa.me/6281234567890" target="_blank" class="text-decoration-none">+62 812-3456-7890</a></div>
                        </li>
                    </ul>
                    <div class="text-muted">Jam layanan: Senin - Jumat, 08.00 - 15.00 WIB</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Map Row below both columns -->
    <div class="row mt-3">
        <div class="col-12 reveal">
            <div class="card contact-card">
                <div class="card-body">
                    <h5 class="mb-3"><i class="fas fa-map me-2 text-primary"></i>Lokasi Sekolah</h5>
                    <iframe class="map-embed" loading="lazy" referrerpolicy="no-referrer-when-downgrade" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3963.049839558919!2d106.8246939!3d-6.640733399999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69c8b16ee07ef5%3A0x14ab253dd267de49!2sSMKN%204%20Bogor!5e0!3m2!1sen!2sid!4v1757425432957!5m2!1sen!2sid"></iframe>
                    <div class="text-end mt-2">
                        <a href="https://maps.app.goo.gl/Q84Ug3JoMqanQ4xb6" target="_blank" class="btn btn-outline-primary btn-sm">Buka di Google Maps</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="row mt-5">
        <div class="col-12 reveal">
            <div class="card contact-card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-question-circle me-2 text-primary"></i>Pertanyaan yang Sering Diajukan (FAQ)
                    </h5>
                </div>
                <div class="card-body">
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faq1">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1">
                                    Bagaimana cara mendaftar ke SMKN 4 BOGOR?
                                </button>
                            </h2>
                            <div id="collapse1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Pendaftaran siswa baru dapat dilakukan melalui formulir pendaftaran online atau datang langsung ke sekolah. Informasi lengkap tentang persyaratan dan jadwal pendaftaran dapat dilihat di halaman berita atau hubungi bagian administrasi.
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faq2">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2">
                                    Program apa saja yang tersedia di SMKN 4 BOGOR?
                                </button>
                            </h2>
                            <div id="collapse2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    SMKN 4 BOGOR menyediakan program kejuruan sesuai minat dan bakat siswa.
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faq3">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3">
                                    Apakah ada biaya pendaftaran?
                                </button>
                            </h2>
                            <div id="collapse3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Informasi lengkap tentang biaya pendaftaran dan SPP dapat diperoleh dengan menghubungi bagian administrasi sekolah atau melalui form kontak di halaman ini.
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faq4">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4">
                                    Kapan jadwal pendaftaran siswa baru?
                                </button>
                            </h2>
                            <div id="collapse4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Jadwal pendaftaran siswa baru biasanya dimulai pada bulan Januari-Maret setiap tahun. Informasi lengkap akan diumumkan melalui website dan media sosial sekolah.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    (function(){
        const form = document.getElementById('contactForm');
        const pesan = document.getElementById('pesan');
        const counter = document.getElementById('charCounter');
        const submitBtn = document.getElementById('submitBtn');
        if (pesan && counter) {
            const update = () => { counter.textContent = pesan.value.length + '/1000'; };
            pesan.addEventListener('input', update); update();
        }
        if (form && submitBtn) {
            form.addEventListener('submit', function(){
                submitBtn.disabled = true; submitBtn.classList.add('btn-loading');
                const loader = submitBtn.querySelector('.loading'); if (loader) loader.style.display = 'inline-block';
            });
        }
    })();
</script>
@endpush
