@extends('layouts.app')

@section('title', 'Edit Dokumen')
@section('page-title', 'Edit Dokumen')

@section('content')
<div style="max-width:860px;">
    <div class="panel">
        <div class="panel-header">
            <div class="panel-title">
                <i class="fas fa-pen-to-square" style="color:var(--accent)"></i>
                Edit: {{ Str::limit($document->title, 40) }}
            </div>
            <a href="{{ route('documents.show', $document) }}" class="btn btn-outline">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="panel-body">
            <form method="POST" action="{{ route('documents.update', $document) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div style="margin-bottom:28px;">
                    <div style="font-size:13px;font-weight:700;text-transform:uppercase;letter-spacing:0.8px;color:var(--accent);margin-bottom:16px;padding-bottom:8px;border-bottom:2px solid var(--gray100);">
                        <i class="fas fa-info-circle" style="margin-right:6px;"></i> Informasi Dokumen
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Judul Dokumen <span style="color:red">*</span></label>
                            <input type="text" name="title" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                                   value="{{ old('title', $document->title) }}" required>
                            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Nomor Dokumen <span style="color:red">*</span></label>
                            <input type="text" name="document_number" class="form-control {{ $errors->has('document_number') ? 'is-invalid' : '' }}"
                                   value="{{ old('document_number', $document->document_number) }}" required>
                            @error('document_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Kategori <span style="color:red">*</span></label>
                            <select name="category" class="form-control" required>
                                @foreach(['Surat Masuk','Surat Keluar','Surat Keputusan','Peraturan','Laporan','Notulen Rapat','Kontrak','Izin','Berita Acara','Lainnya'] as $cat)
                                    <option value="{{ $cat }}" {{ old('category', $document->category) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tanggal Dokumen <span style="color:red">*</span></label>
                            <input type="date" name="document_date" class="form-control"
                                   value="{{ old('document_date', $document->document_date->format('Y-m-d')) }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Deskripsi / Perihal</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description', $document->description) }}</textarea>
                    </div>
                </div>

                <div style="margin-bottom:28px;">
                    <div style="font-size:13px;font-weight:700;text-transform:uppercase;letter-spacing:0.8px;color:var(--gold);margin-bottom:16px;padding-bottom:8px;border-bottom:2px solid var(--gray100);">
                        <i class="fas fa-map-location-dot" style="margin-right:6px;"></i> Lokasi Fisik
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-cabinet-filing" style="color:var(--accent);margin-right:5px;"></i> Nomor Lemari *</label>
                            <input type="text" name="cabinet_number" class="form-control" value="{{ old('cabinet_number', $document->cabinet_number) }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Label Lemari</label>
                            <input type="text" name="cabinet_label" class="form-control" value="{{ old('cabinet_label', $document->cabinet_label) }}">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-folder-open" style="color:var(--gold);margin-right:5px;"></i> Nomor Ordner *</label>
                            <input type="text" name="ordner_number" class="form-control" value="{{ old('ordner_number', $document->ordner_number) }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Label Ordner</label>
                            <input type="text" name="ordner_label" class="form-control" value="{{ old('ordner_label', $document->ordner_label) }}">
                        </div>
                    </div>
                    <div class="form-group" style="max-width:280px;">
                        <label class="form-label">No. Urut dalam Ordner</label>
                        <input type="number" name="document_sequence" class="form-control" value="{{ old('document_sequence', $document->document_sequence) }}" min="1">
                    </div>
                </div>

                <div style="margin-bottom:28px;">
                    <div style="font-size:13px;font-weight:700;text-transform:uppercase;letter-spacing:0.8px;color:var(--green);margin-bottom:16px;padding-bottom:8px;border-bottom:2px solid var(--gray100);">
                        <i class="fas fa-cloud-upload-alt" style="margin-right:6px;"></i> File Digital
                    </div>
                    @if($document->file_path)
                    <div style="background:#F0FDF4;border:1.5px solid #BBF7D0;border-radius:10px;padding:14px 18px;margin-bottom:14px;display:flex;align-items:center;gap:12px;">
                        <i class="fas fa-file-check" style="color:var(--green);font-size:20px;"></i>
                        <div>
                            <div style="font-weight:600;font-size:13.5px;color:var(--gray800);">{{ $document->file_name }}</div>
                            <div style="font-size:12px;color:var(--gray400);">File saat ini. Upload baru untuk mengganti.</div>
                        </div>
                    </div>
                    @endif
                    <div class="form-group">
                        <label class="form-label">{{ $document->file_path ? 'Ganti File (opsional)' : 'Upload File (opsional)' }}</label>
                        <input type="file" name="file" class="form-control" accept=".pdf,.doc,.docx,.jpg,.png">
                        @error('file')<div class="invalid-feedback" style="display:block;">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div style="display:flex;gap:12px;justify-content:flex-end;padding-top:16px;border-top:1px solid var(--gray100);">
                    <a href="{{ route('documents.show', $document) }}" class="btn btn-outline">
                        <i class="fas fa-times"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
