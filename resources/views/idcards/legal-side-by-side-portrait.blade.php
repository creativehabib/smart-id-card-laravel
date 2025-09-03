<!doctype html>
<html>
<head>
<meta charset="utf-8">
<style>
  @page { size: Legal portrait; margin: 10mm; }

  html, body { padding:0; margin:0; }
  body { font-family: DejaVu Sans, Arial, Helvetica, sans-serif; font-size: 9pt; background:#fff; }

  .page { break-after: page; page-break-after: always; }
  .page:last-of-type { break-after: auto; page-break-after: auto; }

  .page-center{ min-height:100vh; display:flex; align-items:center; justify-content:center; }

  /* Preview grid/flex */
  .sheet-grid{ display:grid; grid-auto-rows:87mm; gap:5mm; margin-bottom: 5mm;}
  .pair-flex{ width:115mm; height:87mm; display:flex; gap:5mm; }

  /* PDF table/inline-block */
  .sheet-table{ border-collapse:separate; border-spacing:5mm 5mm; }
  .pair-cell{ width:115mm; vertical-align:top; }
  .pair-ib{ width:115mm; height:87mm; }
  .card-ib{ display:inline-block; vertical-align:top; width:55mm; height:87mm; }

  .card{
    width:55mm; height:87mm; background:#fff; border:0.3mm solid #d0d0d0;
    border-radius:3mm; overflow:hidden; position:relative; box-sizing:border-box;
    page-break-inside: avoid;
  }

  .topbar, .back-top {height: 16mm;background: #fff;display: flex;align-items: center;border-bottom: 0.3mm solid #e5e5e5;padding: 7px 3mm 0;}
  .logo{ width:10mm; height:10mm; }
  .logo img{ width:100%; height:100%; object-fit:contain; }
  .uni-bn{ font-weight:700; font-size:12pt; line-height:1.1; }
  .uni-en{ font-size:7pt; color:#333; line-height:1.1; }

  .photo-wrap{ display:flex; justify-content:center; background:#e9f2ff; }
  .photo-frame{ width:25mm; height:30mm; display:flex; align-items:center; justify-content:center; }
  .photo{ width:25mm; height:30mm; object-fit:cover; border:0.2mm solid #c9c9c9; background:#fff; }

  .name{ text-align:center; font-weight:700; font-size:10pt; margin-top:1mm; color:#111; }
  .role{ text-align:center; font-size:8pt; margin-top:0.5mm; color:#333; }
  .dept{ text-align:center; font-size:7.5pt; color:#333; }
  .bottom {position: absolute;left: 0;right: 0;bottom: 1.5mm;display: flex;justify-content: space-between;align-items: center;padding: 0 3mm;}
  .sig{ font-size:6.5pt; text-align:center; width:24mm; color:#333; }
  .qr{ width:15mm; height:15mm; border:0.2mm solid #c9c9c9; display:flex; align-items:center; justify-content:center; background:#fff; }
  .qr-svg svg { width:15mm; height:15mm; display:block; }

  .back-body{ padding:3mm 4mm 22mm; }
  .back-bottom {position: absolute;left: 0;right: 0;bottom: 1.5mm;min-height: 16mm;border-top: 0.3mm solid #e5e5e5;display: flex;align-items: center;justify-content: center;background: #fff;padding: 2mm 4mm;}
  .back-note{ font-size:7.6pt; color:#222; text-align:center; }

  .row {display: flex;font-size: 7.8pt;margin: 0.6mm 0;color: #111;line-height: 14px;}
  .label{ width:25mm; color:#333; }
  .value{ flex:1; font-weight:600; color:#111; }


  @media print { .page-center { display:block; min-height:0; height:auto; } }
</style>
</head>
<body>

@foreach($chunks as $employees)
  <section class="page">
    <div class="page-center" @if($forPdf ?? false) style="min-height:0;height:auto;display:block;" @endif>

      @if($forPdf ?? false)
        {{-- ======== PDF MODE: TABLE LAYOUT (1 column × 3 rows) ======== --}}
        <table class="sheet-table">
          <tbody>
          @foreach($employees->chunk($cols ?? 1) as $row)
            <tr>
              @foreach($row as $e)
                @php
                      $bg = $e->photo_bg ?: '#e9f2ff';
                      $logoSrc       = public_path('img/nu_logo.png');
                      $photoSrc      = $e->photo_path ? public_path('storage/'.$e->photo_path) : public_path('img/photo_placeholder.jpg');
                      $cardSigSrc    = public_path('img/c-holder-sig.png');
                      $regiSigSrc    = public_path('img/regi-sig.png');
                      $qrPayload     = json_encode($e->qr_payload ?? ['id'=>$e->id]);
                      $qrSvg         = QrCode::format('svg')->size(180)->margin(0)->generate($qrPayload);
                @endphp
                <td class="pair-cell">
                  <div class="pair-ib">
                    <!-- FRONT -->
                    <div class="card card-ib">
                      <div class="topbar">
                        <div class="logo"><img src="{{ $logoSrc }}" alt="NU"></div>
                        <div><div class="uni-bn">জাতীয় বিশ্ববিদ্যালয়</div><div class="uni-en">National University Bangladesh</div></div>
                      </div>
                      <div class="photo-wrap" style="background: {{ $bg }};">
                        <div class="photo-frame"><img class="photo" src="{{ $photoSrc }}" alt=""></div>
                      </div>
                      <div class="name">{{ $e->name }}</div>
                      <div class="role">{{ $e->designation }}</div>
                      <div class="dept">{{ $e->department }}</div>
                      <div class="bottom">
                        <div class="sig"><div style="height:10mm;"><img src="{{ $cardSigSrc }}" alt="" style="height:10mm;"></div><div>Card Holder</div></div>
                          <div class="qr"><span class="qr-pdf qr-svg">{!! $qrSvg !!}</span></div>
                        <div class="sig"><div style="height:10mm;"><img src="{{ $regiSigSrc }}" alt="" style="height:10mm;"></div><div>Registrar</div></div>
                      </div>
                      <div class="crop"><div class="cm h tl"></div><div class="cm v tl"></div><div class="cm h tr"></div><div class="cm v tr"></div><div class="cm h bl"></div><div class="cm v bl"></div><div class="cm h br"></div><div class="cm v br"></div></div>
                    </div>
                    <div style="display:inline-block;width:5mm;height:87mm;"></div>
                    <!-- BACK -->
                    <div class="card card-ib">
                      <div class="back-top">
                        <div class="logo"><img src="{{ $logoSrc }}" alt="NU"></div>
                        <div><div class="uni-bn">জাতীয় বিশ্ববিদ্যালয়</div><div class="uni-en">National University Bangladesh</div></div>
                      </div>
                      <div class="back-body">
                        <div class="row"><div class="label">P.F. No:</div><div class="value">{{ $e->pf_no }}</div></div>
                        <div class="row"><div class="label">Mobile No:</div><div class="value">{{ $e->mobile }}</div></div>
                        <div class="row"><div class="label">Blood Group:</div><div class="value">{{ $e->blood_group }}</div></div>
                        <div class="row"><div class="label">Present Address:</div><div class="value">{{ $e->address }}</div></div>
                        <div class="row"><div class="label">Emergency Contact:</div><div class="value">{{ $e->emergency_contact }}</div></div>
                        <div class="row"><div class="label">Valid Up to:</div><div class="value">{{ optional($e->valid_to)->format('d-m-Y') }}</div></div>
                      </div>
                      <div class="back-bottom"><div class="back-note">If found, please return to the Registrar, National University, Gazipur-1704, Bangladesh</div></div>
                    </div>
                  </div>
                </td>
              @endforeach
            </tr>
          @endforeach
          </tbody>
        </table>
      @else
        {{-- ======== PREVIEW MODE ======== --}}
        <div class="sheet-grid" style="grid-template-columns: repeat({{ $cols ?? 1 }}, 115mm);">
          @foreach($employees as $e)
            @php
              $bg = $e->photo_bg ?: '#e9f2ff';
              $logoSrc     = asset('img/nu_logo.png');
              $photoSrc    = $e->photo_path ? asset('storage/'.$e->photo_path) : asset('img/photo_placeholder.jpg');
              $cardSigSrc  = asset('img/c-holder-sig.png');
              $regiSigSrc  = asset('img/regi-sig.png');
              $qrPayload   = json_encode($e->qr_payload ?? ['id'=>$e->id]);
            @endphp
            <div class="pair-flex">
              <!-- FRONT -->
              <div class="card">
                <div class="topbar">
                  <div class="logo"><img src="{{ $logoSrc }}" alt="NU"></div>
                  <div><div class="uni-bn">জাতীয় বিশ্ববিদ্যালয়</div><div class="uni-en">National University Bangladesh</div></div>
                </div>
                <div class="photo-wrap" style="background: {{ $bg }};">
                  <div class="photo-frame"><img class="photo" src="{{ $photoSrc }}"></div>
                </div>
                <div class="name">{{ $e->name }}</div>
                <div class="role">{{ $e->designation }}</div>
                <div class="dept">{{ $e->department }}</div>
                <div class="bottom">
                  <div class="sig"><div style="height:10mm;"><img src="{{ $cardSigSrc }}" alt="" style="height:10mm;"></div><div>Card Holder</div></div>
                  <div class="qr">{!! QrCode::size(70)->margin(0)->generate($qrPayload) !!}</div>
                  <div class="sig"><div style="height:10mm;"><img src="{{ $regiSigSrc }}" alt="" style="height:10mm;"></div><div>Registrar</div></div>
                </div>
                <div class="crop"><div class="cm h tl"></div><div class="cm v tl"></div><div class="cm h tr"></div><div class="cm v tr"></div><div class="cm h bl"></div><div class="cm v bl"></div><div class="cm h br"></div><div class="cm v br"></div></div>
              </div>
              <!-- BACK -->
              <div class="card">
                <div class="back-top">
                  <div class="logo"><img src="{{ $logoSrc }}" alt="NU"></div>
                  <div><div class="uni-bn">জাতীয় বিশ্ববিদ্যালয়</div><div class="uni-en">National University Bangladesh</div></div>
                </div>
                <div class="back-body">
                  <div class="row"><div class="label">P.F. No</div>:<div class="value">{{ $e->pf_no }}</div></div>
                  <div class="row"><div class="label">Mobile No</div>:<div class="value">{{ $e->mobile }}</div></div>
                  <div class="row"><div class="label">Blood Group</div>:<div class="value">{{ $e->blood_group }}</div></div>
                  <div class="row"><div class="label">Present Address</div>:<div class="value">{{ $e->address }}</div></div>
                  <div class="row"><div class="label">Emergency Contact</div>:<div class="value">{{ $e->emergency_contact }}</div></div>
                  <div class="row"><div class="label">Valid Up to</div>:<div class="value">{{ optional($e->valid_to)->format('d-m-Y') }}</div></div>
                </div>
                <div class="back-bottom"><div class="back-note">If found, please return to the Registrar, National University, Gazipur-1704, Bangladesh</div></div>
                <div class="crop"><div class="cm h tl"></div><div class="cm v tl"></div><div class="cm h tr"></div><div class="cm v tr"></div><div class="cm h bl"></div><div class="cm v bl"></div><div class="cm h br"></div><div class="cm v br"></div></div>
              </div>
            </div>
          @endforeach
        </div>
      @endif

    </div>
  </section>
@endforeach

</body>
</html>
