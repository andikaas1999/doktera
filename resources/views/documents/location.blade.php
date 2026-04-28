@extends('layouts.app')
@section('title', 'Lokasi Fisik')
@section('page-title', 'Lokasi Fisik Dokumen')

@section('content')

<div style="background:linear-gradient(135deg,#0F172A,#1E3A5F);border-radius:14px;padding:24px 28px;margin-bottom:24px;display:flex;align-items:center;gap:20px;">
    <div style="width:56px;height:56px;background:rgba(99,102,241,0.25);border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:24px;color:#A5B4FC;flex-shrink:0;">
        <i class="fas fa-warehouse"></i>
    </div>
    <div>
        <div style="color:white;font-size:18px;font-weight:800;margin-bottom:4px;">Denah Penyimpanan Arsip</div>
        <div style="color:rgba(255,255,255,0.5);font-size:13px;">Pilih lemari untuk melihat daftar map ordner di dalamnya</div>
    </div>
    <div style="margin-left:auto;text-align:right;">
        <div style="color:rgba(255,255,255,0.4);font-size:11px;text-transform:uppercase;letter-spacing:1px;">Total Lemari</div>
        <div style="color:white;font-size:32px;font-weight:800;font-family:'JetBrains Mono',monospace;">{{ count($cabinets) }}</div>
    </div>
</div>

<!-- Search Bar -->
<form method="GET" action="{{ route('documents.location') }}" style="margin-bottom:20px;">
    <div style="display:flex;gap:10px;">
        <div style="flex:1;position:relative;">
            <i class="fas fa-search" style="position:absolute;left:13px;top:50%;transform:translateY(-50%);color:#94A3B8;font-size:13px;"></i>
            <input type="text" name="search" class="form-control"
                   style="padding-left:38px;"
                   placeholder="Cari nomor atau nama lemari..."
                   value="{{ $search ?? '' }}">
        </div>
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-search"></i> Cari
        </button>
        @if($search)
        <a href="{{ route('documents.location') }}" class="btn btn-outline">
            <i class="fas fa-rotate-left"></i> Reset
        </a>
        @endif
    </div>
</form>
{{-- Hasil Pencarian --}}
@if(isset($search) && $search)
    @if(isset($results) && count($results) > 0)
    <div class="panel" style="margin-bottom:24px;">
        <div class="panel-head">
            <div class="panel-title">
                <div class="panel-title-icon"><i class="fas fa-search"></i></div>
                Hasil: "{{ $search }}" — {{ count($results) }} dokumen ditemukan
            </div>
        </div>
        <div class="panel-body">
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>No. Dokumen</th>
                            <th>Judul Dokumen</th>
                            <th>Kategori</th>
                            <th>Tahun</th>
                            <th>Lokasi Fisik</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results as $i => $doc)
                        <tr>
                            <td style="color:#CBD5E1;font-size:12px;">{{ $i + 1 }}</td>
                            <td><span class="doc-num">{{ $doc->document_number }}</span></td>
                            <td>
                                <div style="font-weight:600;color:#1E293B;">{{ $doc->title }}</div>
                                @if($doc->description)
                                <div style="font-size:11.5px;color:#94A3B8;margin-top:2px;">{{ Str::limit($doc->description, 50) }}</div>
                                @endif
                            </td>
                            <td>
                                @php
                                    $catClass = match($doc->category) {
                                        'Perencanaan' => 'cat-perencanaan',
                                        'Pelaporan'   => 'cat-pelaporan',
                                        default       => 'cat-lainnya',
                                    };
                                @endphp
                                <span class="cat-badge {{ $catClass }}">{{ $doc->category }}</span>
                            </td>
                            <td style="font-size:12.5px;color:#64748B;">
                                {{ $doc->tahun_anggaran ?? '-' }}
                            </td>
                            <td>
								<span class="loc-badge">
									<i class="fas fa-cabinet-filing"></i>
									L{{ $doc->cabinet_number }}
									<span style="color:#A5B4FC;margin:0 2px;">›</span>
									<i class="fas fa-folder"></i>
									O{{ $doc->ordner_number }}
									@if($doc->document_sequence)
									<span style="color:#A5B4FC;margin:0 2px;">›</span>
									<i class="fas fa-file"></i>
									No.{{ $doc->document_sequence }}
									@endif
								</span>
							</td>
                            <td>
                                <div style="display:flex;gap:5px;">
                                    <a href="{{ route('documents.show', $doc) }}" class="btn btn-outline btn-sm" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($doc->file_path)
                                    <a href="{{ route('documents.preview', $doc) }}" target="_blank" class="btn btn-success btn-sm" title="Lihat">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('documents.download', $doc) }}" class="btn btn-outline btn-sm" title="Download">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @else
    <div style="background:#FEF2F2;border:1px solid #FECACA;border-radius:10px;padding:16px 20px;margin-bottom:20px;color:#991B1B;font-size:13.5px;display:flex;align-items:center;gap:10px;">
        <i class="fas fa-circle-exclamation"></i>
        Tidak ada dokumen yang cocok dengan pencarian <strong>"{{ $search }}"</strong>
    </div>
    @endif
@endif
@if(count($cabinets) > 0)
<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:16px;">
    @foreach($cabinets as $cab)
    <a href="{{ route('documents.cabinet', $cab['number']) }}" style="text-decoration:none;">
        <div style="background:white;border:1.5px solid #E2E8F0;border-radius:14px;overflow:hidden;transition:all 0.25s;box-shadow:0 2px 8px rgba(0,0,0,0.05);"
             onmouseover="this.style.borderColor='#4F46E5';this.style.transform='translateY(-4px)';this.style.boxShadow='0 12px 32px rgba(79,70,229,0.15)'"
             onmouseout="this.style.borderColor='#E2E8F0';this.style.transform='translateY(0)';this.style.boxShadow='0 2px 8px rgba(0,0,0,0.05)'">
            <div style="background:linear-gradient(135deg,#0F172A,#1E3A5F);padding:20px;position:relative;overflow:hidden;">
                <div style="position:absolute;top:-20px;right:-20px;width:80px;height:80px;background:rgba(99,102,241,0.2);border-radius:50%;"></div>
                <div style="display:flex;align-items:center;gap:12px;position:relative;">
                    <div style="width:46px;height:46px;background:rgba(255,255,255,0.12);border-radius:11px;display:flex;align-items:center;justify-content:center;font-size:20px;color:white;">
                        <i class="fas fa-cabinet-filing"></i>
                    </div>
                    <div>
                        <div style="color:rgba(255,255,255,0.5);font-size:11px;text-transform:uppercase;letter-spacing:1px;">Lemari</div>
                        <div style="color:white;font-size:22px;font-weight:800;font-family:'JetBrains Mono',monospace;line-height:1;">{{ $cab['number'] }}</div>
                    </div>
                    <div style="margin-left:auto;text-align:right;">
                        <div style="color:rgba(255,255,255,0.4);font-size:10px;">Dokumen</div>
                        <div style="color:white;font-size:20px;font-weight:700;font-family:'JetBrains Mono',monospace;">{{ $cab['count'] }}</div>
                    </div>
                </div>
            </div>
            <div style="padding:16px 20px;display:flex;align-items:center;justify-content:space-between;">
                <div>
                    <div style="font-size:13.5px;font-weight:600;color:#1E293B;">
                        {{ $cab['label'] ?: 'Lemari ' . $cab['number'] }}
                    </div>
                    <div style="font-size:12px;color:#94A3B8;margin-top:3px;">
                        <i class="fas fa-folder" style="margin-right:4px;color:#CBD5E1;"></i>
                        {{ $cab['ordner_count'] }} Map Ordner
                    </div>
                </div>
                <div style="width:34px;height:34px;background:#EEF2FF;border-radius:9px;display:flex;align-items:center;justify-content:center;color:#4F46E5;font-size:14px;">
                    <i class="fas fa-chevron-right"></i>
                </div>
            </div>
        </div>
    </a>
    @endforeach
</div>
@else
<div style="text-align:center;padding:80px;color:#94A3B8;">
    <i class="fas fa-warehouse" style="font-size:48px;display:block;margin-bottom:16px;opacity:0.3;"></i>
    <div style="font-size:17px;font-weight:700;margin-bottom:6px;color:#1E293B;">
        {{ $search ? 'Lemari tidak ditemukan' : 'Belum Ada Data Lokasi' }}
    </div>
    <div style="font-size:14px;margin-bottom:20px;">
        {{ $search ? 'Coba kata kunci lain' : 'Upload dokumen terlebih dahulu' }}
    </div>
    @if(!$search)
    <a href="{{ route('documents.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Upload Dokumen
    </a>
    @endif
</div>
@endif
@endsection