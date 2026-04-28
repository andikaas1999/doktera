@extends('layouts.app')

@section('title', 'Detail Dokumen')
@section('page-title', 'Detail Dokumen')

@section('content')
<div style="max-width:860px;">
    <div class="panel">
        <div class="panel-header">
            <div class="panel-title">
                <i class="fas fa-file-lines" style="color:var(--accent)"></i>
                {{ $document->title }}
            </div>
            <div style="display:flex;gap:8px;">
                <a href="{{ route('documents.edit', $document) }}" class="btn btn-outline btn-sm">
                    <i class="fas fa-pen"></i> Edit
                </a>
                @if($document->file_path)
                <a href="{{ route('documents.download', $document) }}" class="btn btn-success btn-sm">
                    <i class="fas fa-download"></i> Download
                </a>
                @endif
                <a href="{{ route('documents.index') }}" class="btn btn-outline btn-sm">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
        <div class="panel-body">

            <!-- Location Banner -->
            <div style="background:linear-gradient(135deg,var(--navy),var(--blue));border-radius:12px;padding:22px 28px;margin-bottom:28px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:16px;">
                <div>
                    <div style="color:rgba(255,255,255,0.6);font-size:12px;letter-spacing:0.8px;text-transform:uppercase;margin-bottom:8px;">
                        <i class="fas fa-map-pin" style="margin-right:5px;"></i> Lokasi Fisik Dokumen
                    </div>
                    <div style="display:flex;align-items:center;gap:16px;flex-wrap:wrap;">
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div style="width:42px;height:42px;background:rgba(255,255,255,0.12);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px;color:white;">
                                <i class="fas fa-cabinet-filing"></i>
                            </div>
                            <div>
                                <div style="color:rgba(255,255,255,0.6);font-size:11px;">Lemari</div>
                                <div style="color:white;font-size:18px;font-weight:700;font-family:'DM Mono',monospace;">
                                    {{ $document->cabinet_number }}
                                </div>
                                @if($document->cabinet_label)
                                <div style="color:rgba(255,255,255,0.7);font-size:12px;">{{ $document->cabinet_label }}</div>
                                @endif
                            </div>
                        </div>
                        <div style="color:rgba(255,255,255,0.4);font-size:24px;">›</div>
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div style="width:42px;height:42px;background:rgba(232,160,32,0.25);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px;color:var(--gold);">
                                <i class="fas fa-folder-open"></i>
                            </div>
                            <div>
                                <div style="color:rgba(255,255,255,0.6);font-size:11px;">Map Ordner</div>
                                <div style="color:white;font-size:18px;font-weight:700;font-family:'DM Mono',monospace;">
                                    {{ $document->ordner_number }}
                                </div>
                                @if($document->ordner_label)
                                <div style="color:rgba(255,255,255,0.7);font-size:12px;">{{ $document->ordner_label }}</div>
                                @endif
                            </div>
                        </div>
                        @if($document->document_sequence)
                        <div style="color:rgba(255,255,255,0.4);font-size:24px;">›</div>
                        <div>
                            <div style="color:rgba(255,255,255,0.6);font-size:11px;">No. Urut</div>
                            <div style="color:white;font-size:18px;font-weight:700;font-family:'DM Mono',monospace;">
                                {{ $document->document_sequence }}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Details Grid -->
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:24px;">
                @php
                $fields = [
                    ['label'=>'Nomor Dokumen','value'=>$document->document_number,'icon'=>'fa-hashtag','mono'=>true],
                    ['label'=>'Kategori','value'=>$document->category,'icon'=>'fa-tag'],
                    ['label'=>'Tanggal Dokumen','value'=>$document->document_date->format('d F Y'),'icon'=>'fa-calendar'],
                    ['label'=>'Status','value'=>$document->status == 'active' ? 'Aktif' : 'Arsip','icon'=>'fa-circle-dot'],
                    ['label'=>'Diunggah Oleh','value'=>$document->creator->name ?? '-','icon'=>'fa-user'],
                    ['label'=>'Tanggal Input','value'=>$document->created_at->format('d F Y H:i'),'icon'=>'fa-clock'],
                ];
                @endphp
                @foreach($fields as $field)
                <div style="background:var(--gray50);border:1px solid var(--gray200);border-radius:10px;padding:14px 18px;">
                    <div style="font-size:11.5px;color:var(--gray400);font-weight:600;text-transform:uppercase;letter-spacing:0.6px;margin-bottom:5px;">
                        <i class="fas {{ $field['icon'] }}" style="margin-right:5px;"></i>{{ $field['label'] }}
                    </div>
                    <div style="font-size:15px;font-weight:600;color:var(--gray800);{{ isset($field['mono']) ? 'font-family:\'DM Mono\',monospace;color:var(--accent);' : '' }}">
                        {{ $field['value'] }}
                    </div>
                </div>
                @endforeach
            </div>

            @if($document->description)
            <div style="background:var(--gray50);border:1px solid var(--gray200);border-radius:10px;padding:16px 18px;margin-bottom:24px;">
                <div style="font-size:11.5px;color:var(--gray400);font-weight:600;text-transform:uppercase;letter-spacing:0.6px;margin-bottom:8px;">
                    <i class="fas fa-align-left" style="margin-right:5px;"></i>Deskripsi / Perihal
                </div>
                <p style="font-size:14px;color:var(--gray600);line-height:1.7;">{{ $document->description }}</p>
            </div>
            @endif

            <!-- File -->
            @if($document->file_path)
            <div style="background:#F0FDF4;border:1.5px solid #BBF7D0;border-radius:10px;padding:16px 20px;display:flex;align-items:center;justify-content:space-between;gap:16px;">
                <div style="display:flex;align-items:center;gap:12px;">
                    <div style="width:42px;height:42px;background:#16A34A22;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:20px;color:var(--green);">
                        <i class="fas fa-file-{{ in_array($document->file_type,['pdf']) ? 'pdf' : (in_array($document->file_type,['jpg','png']) ? 'image' : 'word') }}"></i>
                    </div>
                    <div>
                        <div style="font-weight:600;color:var(--gray800);font-size:14px;">{{ $document->file_name }}</div>
                        <div style="font-size:12px;color:var(--gray400);">File digital tersedia • {{ strtoupper($document->file_type) }}</div>
                    </div>
                </div>
                <a href="{{ route('documents.download', $document) }}" class="btn btn-success btn-sm">
                    <i class="fas fa-download"></i> Download
                </a>
            </div>
            @else
            <div style="background:var(--gray50);border:1.5px dashed var(--gray200);border-radius:10px;padding:16px 20px;text-align:center;color:var(--gray400);">
                <i class="fas fa-file-slash" style="font-size:20px;margin-bottom:6px;display:block;opacity:0.5;"></i>
                <div style="font-size:13px;">Belum ada file digital yang diunggah</div>
            </div>
            @endif

        </div>
    </div>
</div>
@endsection
