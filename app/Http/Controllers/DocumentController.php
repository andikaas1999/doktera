<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    protected function uploadToCloudinary($tempPath, $fileName, $fileType)
    {
        $cloudinary = new \Cloudinary\Cloudinary([
            'cloud' => [
                'cloud_name' => config('cloudinary.cloud_name'),
                'api_key'    => config('cloudinary.api_key'),
                'api_secret' => config('cloudinary.api_secret'),
            ],
            'url' => ['secure' => true]
        ]);

        $resourceType = in_array(strtolower($fileType), ['jpg','jpeg','png','gif']) ? 'image' : 'raw';

        $result = $cloudinary->uploadApi()->upload($tempPath, [
            'resource_type' => $resourceType,
            'public_id'     => 'doktera/' . time() . '_' . pathinfo($fileName, PATHINFO_FILENAME),
        ]);

        return $result['secure_url'];
    }

    public function index(Request $request)
    {
        $query = Document::with('creator')->where('status', '!=', 'deleted');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('document_number', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('tahun_anggaran', 'like', "%{$search}%")
                  ->orWhere('cabinet_number', 'like', "%{$search}%")
                  ->orWhere('ordner_number', 'like', "%{$search}%")
                  ->orWhere('document_date', 'like', "%{$search}%");
            });
        }

        if ($request->filled('cabinet')) {
            $query->where('cabinet_number', $request->cabinet);
        }
        if ($request->filled('ordner')) {
            $query->where('ordner_number', $request->ordner);
        }
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('tahun')) {
            $query->where('tahun_anggaran', $request->tahun);
        }

        $documents  = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        $stats      = [
            'total'    => Document::where('status', '!=', 'deleted')->count(),
            'cabinets' => Document::where('status', '!=', 'deleted')->distinct('cabinet_number')->count('cabinet_number'),
            'ordners'  => Document::where('status', '!=', 'deleted')->selectRaw('cabinet_number, ordner_number')->distinct()->get()->count(),
            'today'    => Document::whereDate('created_at', today())->count(),
        ];
        $cabinets   = Document::distinct('cabinet_number')->pluck('cabinet_number', 'cabinet_number');
        $ordners    = Document::when($request->filled('cabinet'), function($q) use ($request) {
            $q->where('cabinet_number', $request->cabinet);
        })->distinct('ordner_number')->pluck('ordner_number', 'ordner_number');
        $categories = Document::distinct('category')->pluck('category', 'category');

        return view('documents.index', compact('documents', 'stats', 'cabinets', 'ordners', 'categories'));
    }

    public function create()
    {
        return view('documents.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'             => 'required|string|max:255',
            'document_number'   => 'required|string|max:100|unique:documents',
            'description'       => 'nullable|string',
            'category'          => 'required|string|max:100',
            'tahun_anggaran'    => 'nullable|string|max:10',
            'document_date'     => 'required|date',
            'cabinet_number'    => 'required|string|max:50',
            'ordner_number'     => 'required|string|max:50',
            'document_sequence' => 'nullable|integer',
            'file'              => 'nullable|file|max:20480',
            'gdrive_link'       => 'nullable|url',
        ]);

        $filePath = null;
        $fileName = null;
        $fileType = null;

        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $file     = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $fileType = $file->getClientOriginalExtension();
            $tempPath = $file->getRealPath();

            // Kompresi jika gambar
            if (in_array(strtolower($fileType), ['jpg', 'jpeg', 'png'])) {
                $tempCompressed = storage_path('app/temp_' . $fileName);
                if (strtolower($fileType) == 'png') {
                    $img = imagecreatefrompng($tempPath);
                    imagepng($img, $tempCompressed, 7);
                } else {
                    $img = imagecreatefromjpeg($tempPath);
                    imagejpeg($img, $tempCompressed, 70);
                }
                imagedestroy($img);
                $tempPath = $tempCompressed;
            }

            // Upload ke Cloudinary
            try {
                $filePath = $this->uploadToCloudinary($tempPath, $fileName, $fileType);
                if (isset($tempCompressed) && file_exists($tempCompressed)) {
                    unlink($tempCompressed);
                }
            } catch (\Exception $e) {
                return back()->with('error', 'Gagal upload: ' . $e->getMessage())->withInput();
            }
        }

        Document::create([
            'title'             => $request->title,
            'document_number'   => $request->document_number,
            'description'       => $request->description,
            'category'          => $request->category,
            'tahun_anggaran'    => $request->tahun_anggaran,
            'document_date'     => $request->document_date,
            'cabinet_number'    => $request->cabinet_number,
            'ordner_number'     => $request->ordner_number,
            'cabinet_label'     => null,
            'ordner_label'      => null,
            'document_sequence' => $request->document_sequence,
            'file_path'         => $filePath,
            'file_name'         => $fileName,
            'file_type'         => $fileType,
            'gdrive_link'       => $request->gdrive_link,
            'status'            => 'active',
            'created_by'        => Auth::id(),
        ]);

        return redirect()->route('documents.index')
            ->with('success', 'Dokumen berhasil ditambahkan!');
    }

    public function show(Document $document)
    {
        return view('documents.show', compact('document'));
    }

    public function edit(Document $document)
    {
        return view('documents.edit', compact('document'));
    }

    public function update(Request $request, Document $document)
    {
        $request->validate([
            'title'             => 'required|string|max:255',
            'document_number'   => 'required|string|max:100|unique:documents,document_number,' . $document->id,
            'description'       => 'nullable|string',
            'category'          => 'required|string|max:100',
            'tahun_anggaran'    => 'nullable|string|max:10',
            'document_date'     => 'required|date',
            'cabinet_number'    => 'required|string|max:50',
            'ordner_number'     => 'required|string|max:50',
            'document_sequence' => 'nullable|integer',
            'file'              => 'nullable|file|max:20480',
            'gdrive_link'       => 'nullable|url',
        ]);

        $filePath = $document->file_path;
        $fileName = $document->file_name;
        $fileType = $document->file_type;

        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $file     = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $fileType = $file->getClientOriginalExtension();
            $tempPath = $file->getRealPath();

            if (in_array(strtolower($fileType), ['jpg', 'jpeg', 'png'])) {
                $tempCompressed = storage_path('app/temp_' . $fileName);
                if (strtolower($fileType) == 'png') {
                    $img = imagecreatefrompng($tempPath);
                    imagepng($img, $tempCompressed, 7);
                } else {
                    $img = imagecreatefromjpeg($tempPath);
                    imagejpeg($img, $tempCompressed, 70);
                }
                imagedestroy($img);
                $tempPath = $tempCompressed;
            }

            try {
                $filePath = $this->uploadToCloudinary($tempPath, $fileName, $fileType);
                if (isset($tempCompressed) && file_exists($tempCompressed)) {
                    unlink($tempCompressed);
                }
            } catch (\Exception $e) {
                return back()->with('error', 'Gagal upload: ' . $e->getMessage())->withInput();
            }
        }

        $document->update([
            'title'             => $request->title,
            'document_number'   => $request->document_number,
            'description'       => $request->description,
            'category'          => $request->category,
            'tahun_anggaran'    => $request->tahun_anggaran,
            'document_date'     => $request->document_date,
            'cabinet_number'    => $request->cabinet_number,
            'ordner_number'     => $request->ordner_number,
            'document_sequence' => $request->document_sequence,
            'file_path'         => $filePath,
            'file_name'         => $fileName,
            'file_type'         => $fileType,
            'gdrive_link'       => $request->gdrive_link,
        ]);

        return redirect()->route('documents.index')
            ->with('success', 'Dokumen berhasil diperbarui!');
    }

    public function destroy(Document $document)
    {
        $document->update(['status' => 'deleted']);
        return redirect()->route('documents.index')
            ->with('success', 'Dokumen berhasil dihapus!');
    }

    public function download(Document $document)
    {
        if (!$document->file_path) {
            return back()->with('error', 'File tidak ditemukan!');
        }
        return redirect($document->file_path);
    }

    public function preview(Document $document)
    {
        if (!$document->file_path) {
            return back()->with('error', 'File tidak ditemukan!');
        }
        return redirect($document->file_path);
    }

    public function location(Request $request)
    {
        $search = $request->search;

        if ($search) {
            $results = Document::where('status', 'active')
                ->where(function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('document_number', 'like', "%{$search}%")
                      ->orWhere('cabinet_number', 'like', "%{$search}%")
                      ->orWhere('ordner_number', 'like', "%{$search}%")
                      ->orWhere('category', 'like', "%{$search}%")
                      ->orWhere('tahun_anggaran', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                })
                ->orderBy('cabinet_number')
                ->get();
        } else {
            $results = collect();
        }

        $cabinets = Document::where('status', 'active')
            ->select('cabinet_number', 'cabinet_label')
            ->distinct()
            ->orderBy('cabinet_number')
            ->get()
            ->unique('cabinet_number')
            ->map(function($item) {
                return [
                    'number'       => $item->cabinet_number,
                    'label'        => $item->cabinet_label,
                    'count'        => Document::where('cabinet_number', $item->cabinet_number)->where('status', 'active')->count(),
                    'ordner_count' => Document::where('cabinet_number', $item->cabinet_number)->where('status', 'active')->selectRaw('cabinet_number, ordner_number')->distinct()->count(),
                ];
            })
            ->values();

        return view('documents.location', compact('cabinets', 'search', 'results'));
    }

    public function cabinetDetail($cabinet)
    {
        $cabinetInfo = Document::where('cabinet_number',