<!doctype html>
<html>
<head>
<meta charset="utf-8">
<style>
  @page { size: Legal landscape; margin: 10mm; }
  body { font-family: DejaVu Sans, Arial, Helvetica, sans-serif; font-size: 9pt; background:#fff; }

  .page-center{ display:flex; align-items:center; justify-content:center; }

  /* পুরো পেইজে কলাম; আপনার অনুরোধ অনুযায়ী 3 কলাম রাখা হলো */
  .sheet { display: grid; grid-template-columns: repeat(3, 115mm); grid-auto-rows: 87mm; gap: 5mm; }

  /* একটি pair = দুইটি 55×87mm কার্ড + ভিতরের 5mm ফাঁক */
  .pair { width:115mm; height:87mm; display:flex; gap:5mm; }

  /* কার্ড—exact 55×87 mm */
  .card { width:55mm; height:87mm; background:#fff; border:0.3mm solid #d0d0d0;
          border-radius:3mm; overflow:hidden; position:relative; box-sizing:border-box; }

  .topbar, .back-top { height:16mm; background:#fff; display:flex; align-items:center;
                       padding:0 3mm; border-bottom:0.3mm solid #e5e5e5; }
  .logo { width:10mm; height:10mm; }
  .logo img { width:100%; height:100%; object-fit:contain; }
  .uni-bn { font-weight:700; font-size:12pt; line-height:1.1; }
  .uni-en { font-size:7pt; color:#333; line-height:1.1; }

  /* Photo center ফ্রেম */
  .photo-wrap { display:flex; justify-content:center; background:#e9f2ff; }
  .photo-frame { width:42mm; height:36mm; border-radius:1mm; display:flex; align-items:center; justify-content:center; }
  .photo { width:30mm; height:36mm; object-fit:cover; border:0.2mm solid #c9c9c9; }

  .name { text-align:center; font-weight:700; font-size:10pt; margin-top:1mm; color:#111; }
  .role { text-align:center; font-size:8pt; margin-top:0.5mm; color:#333; }
  .dept { text-align:center; font-size:7.5pt; color:#333; }

  /* FRONT bottom bar */
  .bottom { position:absolute; left:0; right:0; bottom:1.5mm; display:flex; justify-content:space-between; align-items:center; padding:0 3mm; }
  .sig { font-size:6.5pt; text-align:center; width:24mm; color:#333; }
  .qr  { width:18mm; height:18mm; border:0.2mm solid #c9c9c9; display:flex; align-items:center; justify-content:center; background:#fff; }

  /* ---------- BACK: আলাদা bottom bar যুক্ত ---------- */
  /* মূল কনটেন্টের জন্য body: নিচে bottom bar-এর জায়গা রাখার জন্য padding-bottom বাড়ানো */
  .back-body { padding: 3mm 4mm 22mm; }      /* 22mm bottom space so it won't overlap footer */

  /* Back FOOTER (frontend-এর মতো আলাদা) */
  .back-bottom {
    position:absolute; left:0; right:0; bottom:1.5mm;
    min-height:16mm; padding:2mm 4mm;
    border-top:0.3mm solid #e5e5e5;
    display:flex; align-items:center; justify-content:center;
    background:#fff;
  }
  .back-note { font-size:7.6pt; color:#222; text-align:center; }

  .row { display:flex; font-size:7.8pt; margin:0.6mm 0; color:#111; }
  .label { width:24mm; color:#333; }
  .value { flex:1; font-weight:600; color:#111; }

  /* Crop marks (কার্ডের ভিতরের কোণে) */
  .crop { position:absolute; inset:0; pointer-events:none; }
  .cm { position:absolute; background:#000; }
  .cm.h { height:0.25mm; width:3mm; }
  .cm.v { width:0.25mm; height:3mm; }
  .cm.tl.h { top:0.2mm; left:0.2mm; }
  .cm.tl.v { top:0.2mm; left:0.2mm; }
  .cm.tr.h { top:0.2mm; right:0.2mm; transform:translateX(-3mm); }
  .cm.tr.v { top:0.2mm; right:0.2mm; }
  .cm.bl.h { bottom:0.2mm; left:0.2mm; transform:translateY(-3mm); }
  .cm.bl.v { bottom:0.2mm; left:0.2mm; }
  .cm.br.h { bottom:0.2mm; right:0.2mm; transform:translate(-3mm,-3mm); }
  .cm.br.v { bottom:0.2mm; right:0.2mm; }
</style>
</head>
<body>

@foreach($chunks as $employees)
<div class="page-center">
  <div class="sheet">
    @foreach($employees as $e)
      @php $bg = $e->photo_bg ?: '#e9f2ff'; @endphp

      <div class="pair">
        <!-- LEFT: FRONT -->
        <div class="card">
          <div class="topbar">
            <div class="logo"><img src="{{ asset('img/nu_logo.png') }}"></div>
            <div>
              <div class="uni-bn">জাতীয় বিশ্ববিদ্যালয়</div>
              <div class="uni-en">National University Bangladesh</div>
            </div>
          </div>

          <div class="photo-wrap" style="background: {{ $bg }};">
            <div class="photo-frame">
              <img class="photo" src="{{ $e->photo_path ? public_path('storage/'.$e->photo_path) : asset('img/photo_placeholder.jpg') }}">
            </div>
          </div>

          <div class="name">{{ $e->name }}</div>
          <div class="role">{{ $e->designation }}</div>
          <div class="dept">{{ $e->department }}</div>

          <div class="bottom">
            <div class="sig"><div style="height:10mm;"><img src="{{ asset('img/c-holder-sig.png') }}" alt="" style="height:10mm;"></div><div>Card Holder</div></div>
            <div class="qr">{!! QrCode::size(70)->margin(0)->generate(json_encode($e->qr_payload ?? ['id'=>$e->id])) !!}</div>
            <div class="sig"><div style="height:10mm;"><img src="{{ asset('img/regi-sig.png') }}" alt="" style="height:10mm;"></div><div>Registrar</div></div>
          </div>

          <div class="crop">
            <div class="cm h tl"></div><div class="cm v tl"></div>
            <div class="cm h tr"></div><div class="cm v tr"></div>
            <div class="cm h bl"></div><div class="cm v bl"></div>
            <div class="cm h br"></div><div class="cm v br"></div>
          </div>
        </div>

        <!-- RIGHT: BACK (bottom আলাদা) -->
        <div class="card">
          <div class="back-top">
            <div class="logo"><img src="{{ asset('img/nu_logo.png') }}"></div>
            <div>
              <div class="uni-bn">জাতীয় বিশ্ববিদ্যালয়</div>
              <div class="uni-en">National University Bangladesh</div>
            </div>
          </div>

          <!-- মাঝের কনটেন্ট -->
          <div class="back-body">
            <div class="row"><div class="label">P.F. No.</div>           <div class="value">{{ $e->pf_no }}</div></div>
            <div class="row"><div class="label">Mobile No.</div>        <div class="value">{{ $e->mobile }}</div></div>
            <div class="row"><div class="label">Blood Group</div>       <div class="value">{{ $e->blood_group }}</div></div>
            <div class="row"><div class="label">Present Address</div>   <div class="value">{{ $e->address }}</div></div>
            <div class="row"><div class="label">Emergency Contact</div> <div class="value">{{ $e->emergency_contact }}</div></div>
            <div class="row"><div class="label">Valid Up to</div>       <div class="value">{{ optional($e->valid_to)->format('d-m-Y') }}</div></div>
          </div>

          <!-- আলাদা ফুটার বার -->
          <div class="back-bottom">
            <div class="back-note">
              If found, please return to the Registrar, National University, Gazipur-1704, Bangladesh
            </div>
          </div>

          <div class="crop">
            <div class="cm h tl"></div><div class="cm v tl"></div>
            <div class="cm h tr"></div><div class="cm v tr"></div>
            <div class="cm h bl"></div><div class="cm v bl"></div>
            <div class="cm h br"></div><div class="cm v br"></div>
          </div>
        </div>
      </div>

    @endforeach
  </div>
  </div>

  @if(!$loop->last)
    <div style="page-break-after: always;"></div>
  @endif
@endforeach

</body>
</html>
