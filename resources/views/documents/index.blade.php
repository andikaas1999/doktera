@extends('layouts.app')

@section('title', 'Daftar Dokumen')
@section('page-title', 'Daftar Dokumen')

@section('content')

<div class="stat-grid">
    <div class="stat-card c1">
        <div class="stat-top">
            <span class="stat-badge">Total</span>
            <div class="stat-icon-box"><i class="fas fa-file-lines"></i></div>
        </div>
        <div class="stat-val">{{ number_format($stats['total']) }}</div>
        <div class="stat-lbl">Dokumen Tersimpan</div>
    </div>
    <div class="stat-card c2">
        <div class="stat-top">
            <span class="stat-badge">Lemari</span>
            <div class="stat-icon-box"><i class="fas fa-cabinet-filing"></i></div>
        </div>
        <div class="stat-val">{{ $stats['cabinets'] }}</div>
        <div class="stat-lbl">Lemari Aktif</div>
    </div>
    <div class="stat-card c3">
        <div class="stat-top">
            <span class="stat-badge">Ordner</span>
            <div class="stat-icon-box"><i class="fas fa-folder-open"></i></div>
        </div>
        <div class="stat-val">{{ $stats['ordners'] }}</div>
        <div class="stat-lbl">Map Ordner</div>
    </div>
    <div class="stat-card c4">
        <div class="stat-top">
            <span class="stat-badge">Hari Ini</span>
            <div class="stat-icon-box"><i class="fas fa-calendar-plus"></i></div>
        </div>
        <div class="stat-val">{{ $stats['today'] }}</div>
        <div class="stat-lbl">Upload Hari Ini</div>
    </div>
</div>

<div class="panel">
    <div class="panel-head">
        <div class="panel-title">
            <div class="panel-title-icon"><i class="fas fa-table-list"></i></div>
            Katalog Dokumen
        </div>
        <a href="{{ route('documents.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Upload Dokumen
        </a>
    </div>
    <div class="panel-body">

        <form method="GET" action="{{ route('documents.index') }}">
            <div class="search-bar">
                <div class="search-wrap">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" class="form-control"
                           placeholder="Cari judul, nomor, deskripsi..."
                           value="{{ request('search') }}">
                </div>
                <select name="cabinet" class="form-control" style="min-width:150px;">
                    <option value="">Semua Lemari</option>
                    @foreach($cabinets as $c)
                        <option value="{{ $c }}" {{ request('cabinet') == $c ? 'selected' : '' }}>
                            Lemari {{ $c }}
                        </option>
                    @endforeach
                </select>
                <select name="ordner" class="form-control" style="min-width:150px;">
                    <option value="">Semua Ordner</option>
                    @foreach($ordners as $o)
                        <option value="{{ $o }}" {{ request('ordner') == $o ? 'selected' : '' }}>
                            Ordner {{ $o }}
                        </option>
                    @endforeach
                </select>
				<input type="text" name="tahun" class="form-control"
						style="min-width:150px;"
						placeholder="Tahun anggaran..."
						value="{{ request('tahun') }}">
                <select name="category" class="form-control" style="min-width:150px;">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                            {{ $cat }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Cari
                </button>
                @if(request()->hasAny(['search','cabinet','ordner','category']))
                <a href="{{ route('documents.index') }}" class="btn btn-outline">
                    <i class="fas fa-rotate-left"></i> Reset
                </a>
                @endif
            </div>
        </form>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>No. Dokumen</th>
                        <th>Judul Dokumen</th>
                        <th>Kategori</th>
                        <th>Tahun</th>
                        <th>Tanggal</th>
                        <th>Lokasi Fisik</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($documents as $i => $doc)
                    <tr>
                        <td style="color:#CBD5E1;font-size:12px;font-family:'JetBrains Mono',monospace;">
                            {{ $documents->firstItem() + $i }}
                        </td>
                        <td><span class="doc-num">{{ $doc->document_number }}</span></td>
                        <td>
                            <div style="font-weight:600;color:#1E293B;font-size:13.5px;">
                                {{ Str::limit($doc->title, 38) }}
                            </div>
                            @if($doc->description)
                            <div style="font-size:11.5px;color:#94A3B8;margin-top:2px;">
                                {{ Str::limit($doc->description, 45) }}
                            </div>
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
                            <i class="fas fa-calendar-days" style="margin-right:5px;color:#CBD5E1;"></i>
                            {{ $doc->document_date->format('d/m/Y') }}
                        </td>
                        <td>
                            <span class="loc-badge">
                                <i class="fas fa-cabinet-filing"></i>
                                L{{ $doc->cabinet_number }}
								<span style="color:#A5B4FC;margin:0 1px;">›</span>
								<i class="fas fa-folder"></i>
								O{{ $doc->ordner_number }}
								@if($doc->document_sequence)
								<span style="color:#A5B4FC;margin:0 1px;">›</span>
								<i class="fas fa-file"></i>
								No.{{ $doc->document_sequence }}
								@endif
                            </span>
                        </td>
                        <td>
                            <span class="status-dot">
                                <span class="dot dot-{{ $doc->status == 'active' ? 'active' : 'archived' }}"></span>
                                {{ $doc->status == 'active' ? 'Aktif' : 'Arsip' }}
                            </span>
                        </td>
                        <td>
                            <div style="display:flex;gap:5px;">
                                <a href="{{ route('documents.show', $doc) }}" class="btn btn-outline btn-sm" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('documents.edit', $doc) }}" class="btn btn-warning btn-sm" title="Edit">
                                    <i class="fas fa-pen"></i>
                                </a>
                                @if($doc->file_path)
                                <a href="{{ route('documents.preview', $doc) }}" target="_blank" class="btn btn-success btn-sm" title="Lihat File">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('documents.download', $doc) }}" class="btn btn-outline btn-sm" title="Download">
                                    <i class="fas fa-download"></i>
                                </a>
                                @endif
                                <form method="POST" action="{{ route('documents.destroy', $doc) }}"
                                      onsubmit="return confirm('Hapus dokumen ini?')" style="display:inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" style="text-align:center;padding:56px 16px;">
                            <div style="width:64px;height:64px;background:#EEF2FF;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;font-size:24px;color:#6366F1;">
                                <i class="fas fa-folder-open"></i>
                            </div>
                            <div style="font-size:15px;font-weight:700;color:#1E293B;margin-bottom:5px;">Belum ada dokumen</div>
                            <div style="font-size:13px;color:#94A3B8;">Coba ubah filter atau upload dokumen baru</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($documents->hasPages())
        <div class="pager">
            @if($documents->onFirstPage())
                <span style="opacity:0.3"><i class="fas fa-chevron-left"></i></span>
            @else
                <a href="{{ $documents->previousPageUrl() }}"><i class="fas fa-chevron-left"></i></a>
            @endif
            @foreach($documents->getUrlRange(max(1, $documents->currentPage()-2), min($documents->lastPage(), $documents->currentPage()+2)) as $page => $url)
                @if($page == $documents->currentPage())
                    <span class="active">{{ $page }}</span>
                @else
                    <a href="{{ $url }}">{{ $page }}</a>
                @endif
            @endforeach
            @if($documents->hasMorePages())
                <a href="{{ $documents->nextPageUrl() }}"><i class="fas fa-chevron-right"></i></a>
            @else
                <span style="opacity:0.3"><i class="fas fa-chevron-right"></i></span>
            @endif
        </div>
        <p style="text-align:right;font-size:12px;color:#94A3B8;margin-top:8px;">
            {{ $documents->firstItem() }}–{{ $documents->lastItem() }} dari {{ $documents->total() }} dokumen
        </p>
        @endif

    </div>
</div>
@endsection