<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class IdSheetController extends Controller
{
    // -------- PORTRAIT: Fronts -> Backs, 9 per page --------
    public function preview(Request $req)
    {
        $ids = $this->idsFromRequest($req);
        $employees = $this->fetchEmployees($ids);
        $chunks = collect([$employees->take(9)]); // single chunk preview
        return view('idcards.legal-multipage', compact('chunks'));
    }

    public function pdf(Request $req)
    {
        $ids = $this->idsFromRequest($req);
        $employees = $this->fetchEmployees($ids);
        $chunks = $employees->chunk(9);

        $html = view('idcards.legal-multipage', compact('chunks'))->render();
        $pdf  = Pdf::loadHTML($html)->setPaper('legal','portrait');
        return $pdf->download('idcards_legal_'.now()->format('Ymd_His').'.pdf');
    }

    // -------- LANDSCAPE: Side-by-side Front | Back, centered --------
    public function previewSide(Request $req)
    {
        [$cols, $rows] = $this->resolveGrid($req); // default 2x2
        $ids = $this->idsFromRequest($req);
        $employees = $this->fetchEmployees($ids);
        $pairsPerPage = $cols * $rows;
        $chunks = $employees->chunk($pairsPerPage);

        return view('idcards.legal-side-by-side', [
            'chunks' => $chunks,
            'cols'   => $cols,
            'rows'   => $rows,
            'forPdf' => false, // browser preview uses asset()
        ]);
    }

    public function pdfSide(Request $req)
    {
        // ল্যান্ডস্কেপে সেফ গ্রিড: 2 কলাম × 2 রো = 4 pair (8 কার্ড) / পেজ
        $cols = 2;
        $rows = 2;

        $ids = $this->idsFromRequest($req);
        $employees = $this->fetchEmployees($ids);

        $pairsPerPage = $cols * $rows;               // প্রতি পেজে যত pair
        $chunks = $employees->chunk($pairsPerPage);

        // টেবিল প্রস্থ = cols * 115mm + (cols-1)*5mm (gap)
        $gridWidthMm = $cols * 115 + ($cols - 1) * 5;

        $html = view('idcards.legal-side-by-side', [
            'chunks'      => $chunks,
            'cols'        => $cols,
            'rows'        => $rows,
            'gridWidthMm' => $gridWidthMm,
            'forPdf'      => true,     // PDF paths/CSS
        ])->render();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html)
                ->setPaper('legal', 'landscape');

        return $pdf->download('idcards_legal_side_'.now()->format('Ymd_His').'.pdf');
    }

    // -------- PORTRAIT: Side-by-side Front | Back, 1×3 per page (FIXED) --------
    public function previewSidePortrait(Request $req)
    {
        $cols = 1;      // portrait width can't fit 2 pairs per row
        $rows = 3;      // safe rows per page
        $ids  = $this->idsFromRequest($req);
        $employees = $this->fetchEmployees($ids);
        $pairsPerPage = $cols * $rows; // 3 pairs per page
        $chunks = $employees->chunk($pairsPerPage);

        return view('idcards.legal-side-by-side-portrait', [
            'chunks' => $chunks,
            'cols'   => $cols,
            'rows'   => $rows,
            'forPdf' => false, // browser preview
        ]);
    }

    public function pdfSidePortrait(Request $req)
    {
        $cols = 1;
        $rows = 3;
        $ids  = $this->idsFromRequest($req);
        $employees = $this->fetchEmployees($ids);
        $pairsPerPage = $cols * $rows; // 3 pairs per page
        $chunks = $employees->chunk($pairsPerPage);

        $html = view('idcards.legal-side-by-side-portrait', [
            'chunks' => $chunks,
            'cols'   => $cols,
            'rows'   => $rows,
            'forPdf' => true, // DomPDF-friendly paths & CSS
        ])->render();

        $pdf = Pdf::loadHTML($html)->setPaper('legal','portrait');
        return $pdf->download('idcards_legal_side_portrait_'.now()->format('Ymd_His').'.pdf');
    }

    // ---------------- Helpers ----------------
    private function resolveGrid(Request $req): array
    {
        // Legal landscape safe default: 2×2
        $cols = max(1, (int)$req->query('cols', 2));
        $rows = max(1, (int)$req->query('rows', 2));
        return [$cols, $rows];
    }

    private function idsFromRequest(Request $req): array
    {
        if ($req->filled('ids')) {
            return collect(explode(',', (string)$req->input('ids')))
                ->map(fn($v)=>(int)trim($v))->filter()->all();
        }
        return Employee::query()->orderBy('id')->pluck('id')->all();
    }

    private function fetchEmployees(array $ids): Collection
    {
        $q = Employee::query();
        if (!empty($ids)) {
            // Keep provided order so pairs stay aligned
            $q->whereIn('id', $ids)->orderByRaw('FIELD(id,'.implode(',', $ids).')');
        }
        return $q->get();
    }
}
