@extends('layouts.app')

@section('title', 'Upload Dokumen')
@section('page-title', 'Upload Dokumen Baru')

@section('content')
<div style="max-width:860px;">
    <div class="panel">
        <div class="panel-body">
            <div class="panel-header">
                <div class="panel-title mb-2">
                    <i class="fas fa-cloud-arrow-up" style="color:var(--accent)"></i>
                    Form Input Dokumen
                </div>
                <a href="{{ route('documents.index') }}" class="btn btn-outline mb-2">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>

            <form method="POST" action="{{ route('documents.store') }}" enctype="multipart/form-data">
                @csrf

                <!-- Informasi Dokumen -->
                <div style="margin-bottom:28px;">
                    <div style="font-size:13px;font-weight:700;text-transform:uppercase;letter-spacing:0.8px;color:var(--accent);margin-bottom:16px;padding-bottom:8px;border-bottom:2px solid var(--gray100);">
                        <i class="fas fa-info-circle" style="margin-right:6px;"></i> Informasi Dokumen
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Judul Dokumen <span style="color:red">*</span></label>
                            <input type="text" name="title" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                                placeholder="Masukkan judul dokumen" value="{{ old('title') }}" required>
                            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Nomor Dokumen <span style="color:red">*</span></label>
                            <input type="text" name="document_number" class="form-control {{ $errors->has('document_number') ? 'is-invalid' : '' }}"
                                placeholder="Contoh: SK/001/2024" value="{{ old('document_number') }}" required>
                            @error('document_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tahun Anggaran</label>
                        <input type="text" name="tahun_anggaran" class="form-control"
                            placeholder="Contoh: 2024, 2025..."
                            value="{{ old('tahun_anggaran') }}">
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Kategori <span style="color:red">*</span></label>
                            <select name="category" class="form-control {{ $errors->has('category') ? 'is-invalid' : '' }}" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach(['Perencanaan','Pelaporan','Lainnya'] as $cat)
                                <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                            @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tanggal Dokumen <span style="color:red">*</span></label>
                            <input type="date" name="document_date" class="form-control {{ $errors->has('document_date') ? 'is-invalid' : '' }}"
                                value="{{ old('document_date') }}" required>
                            @error('document_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Deskripsi / Perihal</label>
                        <textarea name="description" class="form-control" rows="3"
                            placeholder="Keterangan singkat tentang dokumen ini...">{{ old('description') }}</textarea>
                    </div>
                </div>

                <!-- Lokasi Fisik -->
                <div style="margin-bottom:28px;">
                    <div style="font-size:13px;font-weight:700;text-transform:uppercase;letter-spacing:0.8px;color:var(--gold);margin-bottom:16px;padding-bottom:8px;border-bottom:2px solid var(--gray100);">
                        <i class="fas fa-map-location-dot" style="margin-right:6px;"></i> Lokasi Fisik Dokumen
                    </div>

                    <div style="background:#FFFBEB;border:1.5px solid #FDE68A;border-radius:10px;padding:16px 20px;margin-bottom:20px;font-size:13px;color:#92400E;display:flex;align-items:flex-start;gap:10px;">
                        <i class="fas fa-lightbulb" style="margin-top:1px;flex-shrink:0;"></i>
                        <div>
                            <strong>Panduan Lokasi:</strong> Tentukan di lemari nomor berapa dan map ordner nomor berapa dokumen fisik ini disimpan.
                            Informasi ini membantu menemukan dokumen aslinya dengan cepat.
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-cabinet-filing" style="color:var(--accent);margin-right:5px;"></i>
                            Nomor Lemari <span style="color:red">*</span>
                        </label>
                        <input type="text" name="cabinet_number" class="form-control {{ $errors->has('cabinet_number') ? 'is-invalid' : '' }}"
                            placeholder="Contoh: 1, 2, A, B" value="{{ old('cabinet_number') }}" required>
                        @error('cabinet_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-folder-open" style="color:var(--gold);margin-right:5px;"></i>
                            Nomor Map Ordner <span style="color:red">*</span>
                        </label>
                        <input type="text" name="ordner_number" class="form-control {{ $errors->has('ordner_number') ? 'is-invalid' : '' }}"
                            placeholder="Contoh: 01, 02, I, II" value="{{ old('ordner_number') }}" required>
                        @error('ordner_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group" style="max-width:280px;">
                        <label class="form-label">
                            <i class="fas fa-list-ol" style="color:var(--accent);margin-right:5px;"></i>
                            No. Urut dalam Ordner
                        </label>
                        <input type="number" name="document_sequence" class="form-control"
                            placeholder="Contoh: 1, 2, 3..." value="{{ old('document_sequence') }}" min="1">
                    </div>

                    <!-- Upload File -->
                    <div style="margin-bottom:28px;">
                        <div style="font-size:13px;font-weight:700;text-transform:uppercase;letter-spacing:0.8px;color:var(--green);margin-bottom:16px;padding-bottom:8px;border-bottom:2px solid var(--gray100);">
                            <i class="fas fa-cloud-upload-alt" style="margin-right:6px;"></i> Upload File Digital
                        </div>
                        <div class="form-group">
                            <label class="form-label">File Dokumen (PDF, Word, JPG, PNG — maks 10MB)</label>
                            <div id="drop-zone" style="border:2px dashed var(--gray200);border-radius:10px;padding:36px 24px;text-align:center;cursor:pointer;transition:all 0.2s;background:var(--gray50);">
                                <i class="fas fa-cloud-arrow-up" style="font-size:32px;color:var(--gray400);margin-bottom:10px;display:block;"></i>
                                <div style="font-weight:600;color:var(--gray600);margin-bottom:4px;">Drag & drop file di sini</div>
                                <div style="font-size:12px;color:var(--gray400);margin-bottom:12px;">atau klik untuk memilih file</div>
                                <input type="file" name="file" id="file-input" accept=".pdf,.doc,.docx,.jpg,.png"
                                    style="display:none;">
                                <label for="file-input" class="btn btn-outline btn-sm" style="cursor:pointer;">
                                    <i class="fas fa-folder-open"></i> Pilih File
                                </label>
                                <div id="file-name" style="margin-top:12px;font-size:13px;color:var(--accent);font-weight:600;display:none;"></div>
                            </div>
                            @error('file')<div class="invalid-feedback" style="display:block;">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div style="display:flex;gap:12px;justify-content:flex-end;padding-top:16px;border-top:1px solid var(--gray100);">
                        <a href="{{ route('documents.index') }}" class="btn btn-outline">
                            <i class="fas fa-times"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Dokumen
                        </button>
                    </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const dropZone = document.getElementById('drop-zone');
    const fileInput = document.getElementById('file-input');
    const fileNameDiv = document.getElementById('file-name');

    fileInput.addEventListener('change', function() {
        if (this.files.length) {
            fileNameDiv.textContent = '✓ ' + this.files[0].name;
            fileNameDiv.style.display = 'block';
            dropZone.style.borderColor = 'var(--green)';
            dropZone.style.background = '#F0FDF4';
        }
    });

    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.style.borderColor = 'var(--accent)';
        dropZone.style.background = '#EFF6FF';
    });
    dropZone.addEventListener('dragleave', () => {
        dropZone.style.borderColor = 'var(--gray200)';
        dropZone.style.background = 'var(--gray50)';
    });
    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        const files = e.dataTransfer.files;
        if (files.length) {
            fileInput.files = files;
            fileNameDiv.textContent = '✓ ' + files[0].name;
            fileNameDiv.style.display = 'block';
            dropZone.style.borderColor = 'var(--green)';
            dropZone.style.background = '#F0FDF4';
        }
    });
</script>
@endpush