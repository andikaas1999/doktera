<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'document_number',
        'description',
        'category',
        'tahun_anggaran',
        'document_date',
        'file_path',
        'file_name',
        'file_type',
        'cabinet_number',
        'ordner_number',
        'cabinet_label',
        'ordner_label',
        'document_sequence',
        'status',
        'created_by',
    ];

    protected $casts = [
        'document_date' => 'date',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getLocationStringAttribute()
    {
        return "Lemari {$this->cabinet_number} -> Ordner {$this->ordner_number}";
    }
}