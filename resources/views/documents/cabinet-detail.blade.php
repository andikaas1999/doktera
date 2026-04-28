@extends('layouts.app')
@section('title', 'Detail Lemari ' . $cabinet)
@section('page-title', 'Detail Lemari ' . $cabinet)
@section('content')

<div style="display:flex;align-items:center;gap:8px;margin-bottom:20px;font-size:13px;color:#94A3B8;">
    <a href="{{ route('documents.location') }}" style="color:#4F46E5;text-decoration:none;font-weight:600;">
        <i class="fas fa-warehouse" style="margin-right:4px;"></i>Lokasi Fisik
    </a>
    <i class="fas fa-chevron-right" style="font-size:10px;"></i>
    <span style="color:#1E293B;font-weight:600;">Lemari {{ $cabinet }}</span>
</div>

<div style="background:linear-gradient(135deg,#0F172A,#1E3A5F);border-radius:14px;padding:24px 28px;margin-bottom:24px;display:flex;align-items:center;gap:20px;">
    <div style="width:56px;height:56px;background:rgba(255,255,255,0.1);border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:24px;color:white;flex-shrink:0;">
        <i class="fas fa-cabinet-filing"></i>
    </div>
    <div>
        <div style="color:rgba(255,255,255,0.5);font-size:11px;text-transform:uppercase;letter-spacing:1px;margin-bottom:4px;">Lemari</div>
        <div style="color:white;font-size:22px;font-weight:800;margin-bottom:2px;">
            {{ $cabinetInfo ? ($cabinetInfo->cabinet_label ?: 'Lemari ' . $cabinet) : 'Lemari ' . $cabinet }}
        </div>
        <div style="color:rgba(255,255,255,0.4);font-size:13px;">Nomor Lemari: {{ $cabinet }}</div>
    </div>
    <div style="margin-left:auto;text-align:right;">
        <div style="color:rgba(255,255,255,0.4);font-size:11px;text-transform:uppercase;letter-spacing:1px;">Total Ordner</div>
        <div style="color:white;font-size:32px;font-weight:800;font-family:'JetBrains Mono',monospace;">{{ count($ordners) }}</div>
    </div>
</div>

@if(count($ordners) > 0)
<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:16px;">
    @foreach($ordners as $ord)
    <a href="{{ route('documents.ordner', [$cabinet, $ord['number']]) }}" style="text-decoration:none;">
        <div style="background:white;border:1.5px solid #E2E8F0;border-radius:14px;overflow:hidden;transition:all 0.25s;box-shadow:0 2px 8px rgba(0,0,0,0.05);"
             onmouseover="this.style.borderColor='#F59E0B';this.style.transform='translateY(-4px)';this.style.boxShadow='0 12px 32px rgba(245,158,11,0.15)'"
             onmouseout="this.style.borderColor='#E2E8F0';this.style.transform='translateY(0)';this.style.boxShadow='0 2px 8px rgba(0,0,0,0.05)'">
            <div style="background:linear-gradient(135deg,#78350F,#D97706);padding:20px;position:relative;overflow:hidden;">
                <div style="position:absolute;top:-20px;right:-20px;width:80px;height:80px;background:rgba(255,255,255,0.1);border-radius:50%;"></div>
                <div style="display:flex;align-items:center;gap:12px;position:relative;">
                    <div style="width:46px;height:46px;background:rgba(255,255,255,0.15);border-radius:11px;display:flex;align-items:center;justify-content:center;font-size:20px;color:white;">
                        <i class="fas fa-folder-open"></i>
                    </div>
                    <div>
                        <div style="color:rgba(255,255,255,0.6);font-size:11px;text-transform:uppercase;letter-spacing:1px;">Map Ordner</div>
                        <div style="color:white;font-size:22px;font-weight:800;font-family:'JetBrains Mono',monospace;line-height:1;">{{ $ord['number'] }}</div>
                    </div>
                    <div style="margin-left:auto;text-align:right;">
                        <div style="color:rgba(255,255,255,0.5);font-size:10px;">Berkas</div>
                        <div style="color:white;font-size:20px;font-weight:700;font-family:'JetBrains Mono',monospace;">{{ $ord['count'] }}</div>
                    </div>
                </div>
            </div>
            <div style="padding:16px 20px;display:flex;align-items:center;justify-content:space-between;">
                <div>
                    <div style="font-size:13.5px;font-weight:600;color:#1E293B;">
                        {{ $ord['label'] ?: 'Ordner ' . $ord['number'] }}
                    </div>
                    <div style="font-size:12px;color:#94A3B8;margin-top:3px;">
                        <i class="fas fa-file-lines" style="margin-right:4px;color:#CBD5E1;"></i>
                        {{ $ord['count'] }} Dokumen
                    </div>
                </div>
                <div style="width:34px;height:34px;background:#FFFBEB;border-radius:9px;display:flex;align-items:center;justify-content:center;color:#D97706;font-size:14px;">
                    <i class="fas fa-chevron-right"></i>
                </div>
            </div>
        </div>
    </a>
    @endforeach
</div>
@else
<div style="text-align:center;padding:60px;color:#94A3B8;">
    <i class="fas fa-folder-open" style="font-size:40px;display:block;margin-bottom:14px;opacity:0.3;"></i>
    <div style="font-size:15px;font-weight:700;color:#1E293B;">Belum ada ordner di lemari ini</div>
</div>
@endif
@endsection