@extends('layouts.app')
@section('title', 'Ordner ' . $ordner)
@section('page-title', 'Isi Map Ordner ' . $ordner)
@section('content')

<div style="display:flex;align-items:center;gap:8px;margin-bottom:20px;font-size:13px;color:#94A3B8;flex-wrap:wrap;">
    <a href="{{ route('documents.location') }}" style="color:#4F46E5;text-decoration:none;font-weight:600;">
        <i class="fas fa-warehouse" style="margin-right:4px;"></i>Lokasi Fisik
    </a>
    <i class="fas fa-chevron-right" style="font-size:10px;"></i>
    <a href="{{ route('documents.cabinet', $cabinet) }}" style="color:#4F46E5;text-decoration:none;font-weight:600;">
        Lemari {{ $cabinet }}
    </a>
    <i class="fas fa-chevron-right" style="font-size:10px;"></i>
    <span style="color:#1E293B;font-weight:600;">Ordner {{ $ordner }}</span>
</div>

<div style="background:linear-gradient(135deg,#78350F,#D97706);border-radius:14px;padding:24px 28px;margin-bottom:24px;display:flex;align-items:center;gap:20px;">
    <div style="width:56px;height:56px;background:rgba(255,255,255,0.15);border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:24px;color:white;flex-shrink:0;">
        <i class="fas fa-folder-open"></i>
    </div>
    <div>
        <div style="color:rgba(255,255,255,0.6);font-size:11px;text-transform:uppercase;letter-spacing:1px;margin-bottom:4px;">Map Ordner</div>
        <div style="color:white;font-size:22px;font-weight:800;margin-bottom:2px;">
            {{ $ordnerInfo ? ($ordnerInfo->ordner_label ?: 'Ordner ' . $ordner) : 'Ordner ' . $ordner }}
        </div>
        <div style="color:rgba(255,255,255,0.5);font-size:13px;">Lemari {{ $cabinet }} › Ordner {{ $ordner }}</div>
    </div>
    <div style="margin-left:auto;text-align:right;">
        <div style="color:rgba(255,255,255,0.5);font-size:11px;text-transform:uppercase;letter-spacing:1px;">Total Berkas</div>
        <div style="color:white;font-size:32px;font-weight:800;font-family:'JetBrains Mono',monospace;">{{ count($documents) }}</div>
    </div>
</div>

<div class="panel">
    <div class="panel-head">
        <div class="panel-title">
            <div class="panel-title-icon"><i class="fas fa-file-lines"></i></div>
            Daftar Berkas dalam Ordner ini
        </div>
    </div>
    <div class="panel-body">
        @if(count($documents) > 0)
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>No. Urut</th>
                        <th>No. Dokumen</th>
                        <th>Judul Dokumen</th>
                        <th>Kategori</th>
                        <th>Tahun</th>
                        <th>Tanggal</th>
                        <th>File</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($documents as $i => $doc)
                    <tr>
                        <td>
							<span class="loc-badge" style="font-size:11px;">
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
                        <td><span class="doc-num">{{ $doc->document_number }}</span></td>
                        <td>
                            <div style="font-weight:600;color:#1E293B;">{{ Str::limit($doc->title, 40) }}</div>
                            @if($doc->description)
                            <div style="font-size:11.5px;color:#94A3B8;margin-top:2px;">{{ Str::limit($doc->description, 45) }}</div>
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
                        <td style="font-size:12.5px;color:#64748B;white-space:nowrap;">
                            {{ $doc->document_date->format('d/m/Y') }}
                        </td>
                        <td>
                            @if($doc->file_path)
                            <span style="background:#ECFDF5;color:#059669;padding:3px 10px;border-radius:20px;font-size:11.5px;font-weight:600;border:1px solid #A7F3D0;">
                                <i class="fas fa-paperclip" style="margin-right:3px;"></i>Ada
                            </span>
                            @else
                            <span style="background:#F8FAFC;color:#CBD5E1;padding:3px 10px;border-radius:20px;font-size:11.5px;font-weight:600;border:1px solid #E2E8F0;">
                                Tidak Ada
                            </span>
                            @endif
                        </td>
                        <td>
                            <div style="display:flex;gap:5px;">
                                <a href="{{ route('documents.show', $doc) }}" class="btn btn-outline btn-sm" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if($doc->file_path)
                                <a href="{{ route('documents.preview', $doc) }}" target="_blank" class="btn btn-success btn-sm" title="Lihat File">
                                    <i class="fas fa-file-arrow-up"></i>
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
        @else
        <div style="text-align:center;padding:48px;color:#94A3B8;">
            <i class="fas fa-folder-open" style="font-size:36px;display:block;margin-bottom:12px;opacity:0.3;"></i>
            <div style="font-size:15px;font-weight:700;color:#1E293B;">Belum ada dokumen di ordner ini</div>
        </div>
        @endif
    </div>
</div>
@endsection