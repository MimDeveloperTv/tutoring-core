<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Request;

class FileImporterController extends Controller
{
    public $exam_type;
    public function store(Request $request)
    {
        $file = $request->file('file');
        # File name without ext.
        $fileNameWithoutExt = strtolower(pathinfo($request->file('file')->getClientOriginalName(), PATHINFO_FILENAME));

        # Explode file name by underline
        $fileNameExplodedUnderLine = explode('_', $fileNameWithoutExt);
        $FileExt = strtolower($request->file('file')->extension());



        if (Str::contains($fileNameWithoutExt, ['chamber', 'index', 'pachy', 'summary']) && $FileExt == 'csv')
        {
            $fileData = array_slice(file($file), 1);
            $parts = (array_chunk($fileData, 100));
            $partsName = [];
            if(Str::contains($this->exam_type, 'chamber')) {
                //$excelKeys      = collect(explode(";", "Last Name;First Name;Pat-ID;D.o.Birth;Exam Date;Exam Time;Exam Eye;Exam Type;Exam Comment;Rf;Rs;Axis (flat);Astig;Ecc;EccSph;Pupil;PupilX;PupilY;C.Height(Endo);C.Height(Epi);C.Angle;C.A.Min;C.A.Mean;C.A.Sup;C.A.Sup Pos;C.A.Inf;C.A.Inf Pos;C.A.Nas;C.A.Nas Pos;C.A.Tem;C.A.Tem Pos;C.Volume;Pachy Apex;Pachy Pupil;Pachy Sup;Pachy Inf;Pachy Nas;Pachy Tem;Pachy Min;PachyMinX;PachyMinY;Ecc Sup;Phi Sup;Ecc Inf;Phi Inf;Ecc Nas;Phi Nas;Ecc Tem;Phi Tem;Lens Thickn.;Sag3mm;Sag5mm;Sag7mm;Sag9mm;Sag11mm;Sag13mm;Sag15mm;Cor.Vol.;KPD;Ast3mm;Axs3mm;Ast5mm;Axs5mm;Ast7mm;Axs7mm;Ast9mm;Axs9mm;Ast11mm;Axs11mm;Ast13mm;Axs13mm;Ast15mm;Axs15mm;Ecc Type:-->;Ecc (Front);Ecc (Back);Axis (flt/stp);Axis Meridian;Status;Error;Cornea Dia;Sag. Height Mean [µm];EKR65 Flat K1;EKR65 Steep K2;EKR65 Axis K1;Cornea Center X [mm];Cornea Center Y [mm];"));
                $excelKeys        = collect(explode(';', str_replace(':', '', 'Last Name:;First Name:;Pat-ID:;D.o.Birth:;Exam Date:;Exam Time:;Exam Eye:;Exam Type:;Exam Comment:;Rf:;Rs:;Axis (flat):;Astig:;Ecc:;EccSph:;Pupil:;PupilX:;PupilY:;C.Height(Endo):;C.Height(Epi):;C.Angle:;C.A.Min:;C.A.Mean:;C.A.Sup:;C.A.Sup Pos:;C.A.Inf:;C.A.Inf Pos:;C.A.Nas:;C.A.Nas Pos:;C.A.Tem:;C.A.Tem Pos:;C.Volume:;Pachy Apex:;Pachy Pupil:;Pachy Sup:;Pachy Inf:;Pachy Nas:;Pachy Tem:;Pachy Min:;PachyMinX:;PachyMinY:;Ecc Sup:;Phi Sup:;Ecc Inf:;Phi Inf:;Ecc Nas:;Phi Nas:;Ecc Tem:;Phi Tem:;Lens Thickn.:;Sag3mm:;Sag5mm:;Sag7mm:;Sag9mm:;Sag11mm:;Sag13mm:;Sag15mm:;Cor.Vol.:;KPD:;Ast3mm:;Axs3mm:;Ast5mm:;Axs5mm:;Ast7mm:;Axs7mm:;Ast9mm:;Axs9mm:;Ast11mm:;Axs11mm:;Ast13mm:;Axs13mm:;Ast15mm:;Axs15mm:;Ecc Type:-->;Ecc (Front):;Ecc (Back):;Axis (flt/stp):;Axis Meridian:;Status:;Error:;Cornea Dia:;Sag. Height Mean [µm]:;EKR65 Flat K1:;EKR65 Steep K2:;EKR65 Axis K1:;Cornea Center X [mm]:;Cornea Center Y [mm]:;')));
                $this->exam_type  = 'chamber';
            }
            elseif(Str::contains($this->exam_type, 'index')) {
                //$excelKeys      = collect(explode(";", "Last Name;First Name;Pat-ID;D.o.Birth;Exam Date;Exam Time;Exam Eye;Exam Type;Exam Comment;Rf (mm);Rs (mm);K1 (D);K2 (D);Axis (flat);Astig;KKS;ISV;IVA;KI;CKI;IHA;IHD;AA;RSagMin;PachyMinX;PachyMinY;D0mm Pachy;D2mm Pachy;D4mm Pachy;D6mm Pachy;D8mm Pachy;D10mm Pachy;D12mm Pachy;D0mm StdDev;D2mm StdDev;D4mm StdDev;D6mm StdDev;D8mm StdDev;D10mm StdDev;D12mm StdDev;RPI Min;RPI Mid;RPI Max;RPI Min Axis;RPI Max Axis;C.Vol. D 3mm;C.Vol. D 5mm;C.Vol. D 7mm;LatShift;F-AA;B-AA;F-QF;B-QF;LostCut;LostCutSer;F-3DFit Devi;B-3DFit Devi;EyeMove;AlignXY;AlignZ;Status;Error;Axis (flt/stp);Axis Meridian;K Max (Front);K Max X (Front);K Max Y (Front);Pat. Comment 1;Pat. Comment 2;Pat. Comment 3;Pat. Comment 4;Pat. Comment 5;CF Sag. Zonal Mean 4mm;KMax Zonal Mean 3mm;KMax Zonal Mean 4mm;KMax Zonal Mean 5mm;IS-Value;Iris Convexity Mid (∞);Iris Convexity Max (∞);Iris Convexity Axis Max (∞);Iris Convexity Min (∞);Iris Convexity Axis Min (∞);ARC (3mm Zone);PRC (3mm Zone);Thinnest Pachy;DCVA;ABCD A;ABCD B;ABCD C;ABCD D;Chord Mu (polar vector rel. to pupil center) [mm];KISA;"));
                $excelKeys        = collect(explode(';', str_replace(':', '', 'Last Name:;First Name:;Pat-ID:;D.o.Birth:;Exam Date:;Exam Time:;Exam Eye:;Exam Type:;Exam Comment:;Rf (mm):;Rs (mm):;K1 (D):;K2 (D):;Axis (flat):;Astig:;KKS;ISV:;IVA:;KI:;CKI:;IHA:;IHD:;AA:;RSagMin:;PachyMinX:;PachyMinY:;D0mm Pachy:;D2mm Pachy:;D4mm Pachy:;D6mm Pachy:;D8mm Pachy:;D10mm Pachy:;D12mm Pachy:;D0mm StdDev;D2mm StdDev;D4mm StdDev;D6mm StdDev;D8mm StdDev;D10mm StdDev;D12mm StdDev;RPI Min;RPI Mid;RPI Max;RPI Min Axis;RPI Max Axis;C.Vol. D 3mm;C.Vol. D 5mm;C.Vol. D 7mm;LatShift;F-AA;B-AA;F-QF;B-QF;LostCut;LostCutSer;F-3DFit Devi;B-3DFit Devi;EyeMove;AlignXY;AlignZ;Status;Error;Axis (flt/stp):;Axis Meridian:;K Max (Front):;K Max X (Front):;K Max Y (Front):;Pat. Comment 1:;Pat. Comment 2:;Pat. Comment 3:;Pat. Comment 4:;Pat. Comment 5:;CF Sag. Zonal Mean 4mm:;KMax Zonal Mean 3mm:;KMax Zonal Mean 4mm:;KMax Zonal Mean 5mm:;IS-Value:;Iris Convexity Mid (°):;Iris Convexity Max (°):;Iris Convexity Axis Max (°):;Iris Convexity Min (°):;Iris Convexity Axis Min (°):;ARC (3mm Zone):;PRC (3mm Zone):;Thinnest Pachy:;DCVA:;ABCD A:;ABCD B:;ABCD C:;ABCD D:;Chord Mu (polar vector	 rel. to pupil center) [mm]:;Chord Mu (axis) [°]:;')));
                $this->exam_type  = 'index';
            }
            elseif(Str::contains($this->exam_type, 'pachy')) {
                //$excelKeys      = collect(explode(";", "Last Name;First Name;Pat-ID;D.o.Birth;Exam Date;Exam Time;Exam Eye;Exam Type;Exam Comment;K1 (D);K2 (D);Axis (K1);Astig;AC Depth;AC Volume;Ch. Angle;PMinX (+nas);PMinY (+sup);RPI Min;RPI Mid;RPI Max;RPI Min Axis;RPI Max Axis;C.Vol. D 1.0mm;C.Vol. D 1.5mm;C.Vol. D 2.0mm;C.Vol. D 2.5mm;C.Vol. D 3.0mm;C.Vol. D 3.5mm;C.Vol. D 4.0mm;C.Vol. D 4.5mm;C.Vol. D 5.0mm;C.Vol. D 5.5mm;C.Vol. D 6.0mm;C.Vol. D 6.5mm;C.Vol. D 7.0mm;D0.0mm Pachy;D0.4mm Pachy;D0.8mm Pachy;D1.2mm Pachy;D1.6mm Pachy;D2.0mm Pachy;D2.4mm Pachy;D2.8mm Pachy;D3.2mm Pachy;D3.6mm Pachy;D4.0mm Pachy;D4.4mm Pachy;D4.8mm Pachy;D5.2mm Pachy;D5.6mm Pachy;D6.0mm Pachy;D6.4mm Pachy;D6.8mm Pachy;D7.2mm Pachy;D7.6mm Pachy;D8.0mm Pachy;D8.4mm Pachy;D8.8mm Pachy;D9.2mm Pachy;D9.6mm Pachy;D10.0mm Pachy;D10.4mm Pachy;D10.8mm Pachy;D11.2mm Pachy;D11.6mm Pachy;D12.0mm Pachy;D0.0mm StdDev;D0.4mm StdDev;D0.8mm StdDev;D1.2mm StdDev;D1.6mm StdDev;D2.0mm StdDev;D2.4mm StdDev;D2.8mm StdDev;D3.2mm StdDev;D3.6mm StdDev;D4.0mm StdDev;D4.4mm StdDev;D4.8mm StdDev;D5.2mm StdDev;D5.6mm StdDev;D6.0mm StdDev;D6.4mm StdDev;D6.8mm StdDev;D7.2mm StdDev;D7.6mm StdDev;D8.0mm StdDev;D8.4mm StdDev;D8.8mm StdDev;D9.2mm StdDev;D9.6mm StdDev;D10.0mm StdDev;D10.4mm StdDev;D10.8mm StdDev;D11.2mm StdDev;D11.6mm StdDev;D12.0mm StdDev;D0.0mm Prog;D0.4mm Prog;D0.8mm Prog;D1.2mm Prog;D1.6mm Prog;D2.0mm Prog;D2.4mm Prog;D2.8mm Prog;D3.2mm Prog;D3.6mm Prog;D4.0mm Prog;D4.4mm Prog;D4.8mm Prog;D5.2mm Prog;D5.6mm Prog;D6.0mm Prog;D6.4mm Prog;D6.8mm Prog;D7.2mm Prog;D7.6mm Prog;D8.0mm Prog;D8.4mm Prog;D8.8mm Prog;D9.2mm Prog;D9.6mm Prog;D10.0mm Prog;D10.4mm Prog;D10.8mm Prog;D11.2mm Prog;D11.6mm Prog;D12.0mm Prog;R-6.0mm HThin ;R-5.8mm HThin ;R-5.6mm HThin ;R-5.4mm HThin ;R-5.2mm HThin ;R-5.0mm HThin ;R-4.8mm HThin ;R-4.6mm HThin ;R-4.4mm HThin ;R-4.2mm HThin ;R-4.0mm HThin ;R-3.8mm HThin ;R-3.6mm HThin ;R-3.4mm HThin ;R-3.2mm HThin ;R-3.0mm HThin ;R-2.8mm HThin ;R-2.6mm HThin ;R-2.4mm HThin ;R-2.2mm HThin ;R-2.0mm HThin ;R-1.8mm HThin ;R-1.6mm HThin ;R-1.4mm HThin ;R-1.2mm HThin ;R-1.0mm HThin ;R-0.8mm HThin ;R-0.6mm HThin ;R-0.4mm HThin ;R-0.2mm HThin ;R0.0mm HThin ;R0.2mm HThin ;R0.4mm HThin ;R0.6mm HThin ;R0.8mm HThin ;R1.0mm HThin ;R1.2mm HThin ;R1.4mm HThin ;R1.6mm HThin ;R1.8mm HThin ;R2.0mm HThin ;R2.2mm HThin ;R2.4mm HThin ;R2.6mm HThin ;R2.8mm HThin ;R3.0mm HThin ;R3.2mm HThin ;R3.4mm HThin ;R3.6mm HThin ;R3.8mm HThin ;R4.0mm HThin ;R4.2mm HThin ;R4.4mm HThin ;R4.6mm HThin ;R4.8mm HThin ;R5.0mm HThin ;R5.2mm HThin ;R5.4mm HThin ;R5.6mm HThin ;R5.8mm HThin ;R6.0mm HThin ;R-6.0mm HApex;R-5.8mm HApex;R-5.6mm HApex;R-5.4mm HApex;R-5.2mm HApex;R-5.0mm HApex;R-4.8mm HApex;R-4.6mm HApex;R-4.4mm HApex;R-4.2mm HApex;R-4.0mm HApex;R-3.8mm HApex;R-3.6mm HApex;R-3.4mm HApex;R-3.2mm HApex;R-3.0mm HApex;R-2.8mm HApex;R-2.6mm HApex;R-2.4mm HApex;R-2.2mm HApex;R-2.0mm HApex;R-1.8mm HApex;R-1.6mm HApex;R-1.4mm HApex;R-1.2mm HApex;R-1.0mm HApex;R-0.8mm HApex;R-0.6mm HApex;R-0.4mm HApex;R-0.2mm HApex;R0.0mm HApex;R0.2mm HApex;R0.4mm HApex;R0.6mm HApex;R0.8mm HApex;R1.0mm HApex;R1.2mm HApex;R1.4mm HApex;R1.6mm HApex;R1.8mm HApex;R2.0mm HApex;R2.2mm HApex;R2.4mm HApex;R2.6mm HApex;R2.8mm HApex;R3.0mm HApex;R3.2mm HApex;R3.4mm HApex;R3.6mm HApex;R3.8mm HApex;R4.0mm HApex;R4.2mm HApex;R4.4mm HApex;R4.6mm HApex;R4.8mm HApex;R5.0mm HApex;R5.2mm HApex;R5.4mm HApex;R5.6mm HApex;R5.8mm HApex;R6.0mm HApex;Status;Error;"));
                $excelKeys        = collect(explode(';', str_replace(':', '', 'Last Name:;First Name:;Pat-ID:;D.o.Birth:;Exam Date:;Exam Time:;Exam Eye:;Exam Type:;Exam Comment:;K1 (D):;K2 (D):;Axis (K1):;Astig:;AC Depth;AC Volume;Ch. Angle;PMinX (+nas):;PMinY (+sup):;RPI Min;RPI Mid;RPI Max;RPI Min Axis;RPI Max Axis;C.Vol. D 1.0mm;C.Vol. D 1.5mm;C.Vol. D 2.0mm;C.Vol. D 2.5mm;C.Vol. D 3.0mm;C.Vol. D 3.5mm;C.Vol. D 4.0mm;C.Vol. D 4.5mm;C.Vol. D 5.0mm;C.Vol. D 5.5mm;C.Vol. D 6.0mm;C.Vol. D 6.5mm;C.Vol. D 7.0mm;D0.0mm Pachy;D0.4mm Pachy;D0.8mm Pachy;D1.2mm Pachy;D1.6mm Pachy;D2.0mm Pachy;D2.4mm Pachy;D2.8mm Pachy;D3.2mm Pachy;D3.6mm Pachy;D4.0mm Pachy;D4.4mm Pachy;D4.8mm Pachy;D5.2mm Pachy;D5.6mm Pachy;D6.0mm Pachy;D6.4mm Pachy;D6.8mm Pachy;D7.2mm Pachy;D7.6mm Pachy;D8.0mm Pachy;D8.4mm Pachy;D8.8mm Pachy;D9.2mm Pachy;D9.6mm Pachy;D10.0mm Pachy;D10.4mm Pachy;D10.8mm Pachy;D11.2mm Pachy;D11.6mm Pachy;D12.0mm Pachy;D0.0mm StdDev;D0.4mm StdDev;D0.8mm StdDev;D1.2mm StdDev;D1.6mm StdDev;D2.0mm StdDev;D2.4mm StdDev;D2.8mm StdDev;D3.2mm StdDev;D3.6mm StdDev;D4.0mm StdDev;D4.4mm StdDev;D4.8mm StdDev;D5.2mm StdDev;D5.6mm StdDev;D6.0mm StdDev;D6.4mm StdDev;D6.8mm StdDev;D7.2mm StdDev;D7.6mm StdDev;D8.0mm StdDev;D8.4mm StdDev;D8.8mm StdDev;D9.2mm StdDev;D9.6mm StdDev;D10.0mm StdDev;D10.4mm StdDev;D10.8mm StdDev;D11.2mm StdDev;D11.6mm StdDev;D12.0mm StdDev;D0.0mm Prog;D0.4mm Prog;D0.8mm Prog;D1.2mm Prog;D1.6mm Prog;D2.0mm Prog;D2.4mm Prog;D2.8mm Prog;D3.2mm Prog;D3.6mm Prog;D4.0mm Prog;D4.4mm Prog;D4.8mm Prog;D5.2mm Prog;D5.6mm Prog;D6.0mm Prog;D6.4mm Prog;D6.8mm Prog;D7.2mm Prog;D7.6mm Prog;D8.0mm Prog;D8.4mm Prog;D8.8mm Prog;D9.2mm Prog;D9.6mm Prog;D10.0mm Prog;D10.4mm Prog;D10.8mm Prog;D11.2mm Prog;D11.6mm Prog;D12.0mm Prog;R-6.0mm HThin ;R-5.8mm HThin ;R-5.6mm HThin ;R-5.4mm HThin ;R-5.2mm HThin ;R-5.0mm HThin ;R-4.8mm HThin ;R-4.6mm HThin ;R-4.4mm HThin ;R-4.2mm HThin ;R-4.0mm HThin ;R-3.8mm HThin ;R-3.6mm HThin ;R-3.4mm HThin ;R-3.2mm HThin ;R-3.0mm HThin ;R-2.8mm HThin ;R-2.6mm HThin ;R-2.4mm HThin ;R-2.2mm HThin ;R-2.0mm HThin ;R-1.8mm HThin ;R-1.6mm HThin ;R-1.4mm HThin ;R-1.2mm HThin ;R-1.0mm HThin ;R-0.8mm HThin ;R-0.6mm HThin ;R-0.4mm HThin ;R-0.2mm HThin ;R0.0mm HThin ;R0.2mm HThin ;R0.4mm HThin ;R0.6mm HThin ;R0.8mm HThin ;R1.0mm HThin ;R1.2mm HThin ;R1.4mm HThin ;R1.6mm HThin ;R1.8mm HThin ;R2.0mm HThin ;R2.2mm HThin ;R2.4mm HThin ;R2.6mm HThin ;R2.8mm HThin ;R3.0mm HThin ;R3.2mm HThin ;R3.4mm HThin ;R3.6mm HThin ;R3.8mm HThin ;R4.0mm HThin ;R4.2mm HThin ;R4.4mm HThin ;R4.6mm HThin ;R4.8mm HThin ;R5.0mm HThin ;R5.2mm HThin ;R5.4mm HThin ;R5.6mm HThin ;R5.8mm HThin ;R6.0mm HThin ;R-6.0mm HApex;R-5.8mm HApex;R-5.6mm HApex;R-5.4mm HApex;R-5.2mm HApex;R-5.0mm HApex;R-4.8mm HApex;R-4.6mm HApex;R-4.4mm HApex;R-4.2mm HApex;R-4.0mm HApex;R-3.8mm HApex;R-3.6mm HApex;R-3.4mm HApex;R-3.2mm HApex;R-3.0mm HApex;R-2.8mm HApex;R-2.6mm HApex;R-2.4mm HApex;R-2.2mm HApex;R-2.0mm HApex;R-1.8mm HApex;R-1.6mm HApex;R-1.4mm HApex;R-1.2mm HApex;R-1.0mm HApex;R-0.8mm HApex;R-0.6mm HApex;R-0.4mm HApex;R-0.2mm HApex;R0.0mm HApex;R0.2mm HApex;R0.4mm HApex;R0.6mm HApex;R0.8mm HApex;R1.0mm HApex;R1.2mm HApex;R1.4mm HApex;R1.6mm HApex;R1.8mm HApex;R2.0mm HApex;R2.2mm HApex;R2.4mm HApex;R2.6mm HApex;R2.8mm HApex;R3.0mm HApex;R3.2mm HApex;R3.4mm HApex;R3.6mm HApex;R3.8mm HApex;R4.0mm HApex;R4.2mm HApex;R4.4mm HApex;R4.6mm HApex;R4.8mm HApex;R5.0mm HApex;R5.2mm HApex;R5.4mm HApex;R5.6mm HApex;R5.8mm HApex;R6.0mm HApex;Status;Error;')));
                $this->exam_type  = 'pachy';
            }
            elseif(Str::contains($this->exam_type, 'summary')) {
                //$excelKey       = collect(explode(";", "Last Name;First Name;Pat-ID;D.o.Birth;Exam Date;Exam Time;Exam Eye;Exam Type;Exam Comment;Status;Error;Rf F (mm);Rs F (mm);Rh F (mm);Rv F (mm);K1 F (D);K2 F (D);Rm F (mm);Km F (D);Axis F (flat);Astig F (D);R Per F (mm);R Min (mm);Num. Ecc. F;Asph. Q F;Rf B (mm);Rs B (mm);Rh B (mm);Rv B (mm);K1 B (D);K2 B (D);Rm B (mm);Km B (mm);Axis B (flat);Astig B (D);R Per B (mm);R Min B (mm);Num. Ecc. B;Asph. Q B;Ecc. Zone;Pachy Apex;Pachy Pupil;Pupil Pos X;Pupil Pos Y;Pachy Min;Pachy Min Pos X;Pachy Min Pos Y;C.Vol D 3mm;C.Vol D 5mm;C.Vol D 7mm;C.Vol D 10mm;ISV;IVA;KI;CKI;IHA;IHD;RSagMin;TKC;D0mm Pachy;D2mm Pachy;D4mm Pachy;D6mm Pachy;D8mm Pachy;D10mm Pachy;D0mm Prog;D2mm Prog;D4mm Prog;D6mm Prog;D8mm Prog;D10mm Prog;F Ele Avg Zone3mm;F Ele Avg Zone3.5mm;F Ele Avg Zone4mm;F Ele Avg Zone4.5mm;F Ele Avg Zone5mm;F Ele Avg Zone5.5mm;F Ele Avg Zone6mm;F Ele Avg Ring3mm;F Ele Avg Ring3.5mm;F Ele Avg Ring4mm;F Ele Avg Ring4.5mm;F Ele Avg Ring5mm;F Ele Avg Ring5.5mm;F Ele Avg Ring6mm;B Ele Avg Zone3mm;B Ele Avg Zone3.5mm;B Ele Avg Zone4mm;B Ele Avg Zone4.5mm;B Ele Avg Zone5mm;B Ele Avg Zone5.5mm;B Ele Avg Zone6mm;B Ele Avg Ring3mm;B Ele Avg Ring3.5mm;B Ele Avg Ring4mm;B Ele Avg Ring4.5mm;B Ele Avg Ring5mm;B Ele Avg Ring5.5mm;B Ele Avg Ring6mm;KMax Sagittal Front (D);Measuring Head Status;Measuring Head Status Text;Measuring Head Type;"));
                $excelKeys        = collect(explode(';', str_replace(':', '', 'Last Name:;First Name:;Pat-ID:;D.o.Birth:;Exam Date:;Exam Time:;Exam Eye:;Exam Type:;Exam Comment:;Status;Error;Rf F (mm):;Rs F (mm):;Rh F (mm):;Rv F (mm):;K1 F (D):;K2 F (D):;Rm F (mm):;Km F (D):;Axis F (flat):;Astig F (D):;R Per F (mm);R Min (mm);Num. Ecc. F:;Asph. Q F:;Rf B (mm):;Rs B (mm):;Rh B (mm):;Rv B (mm):;K1 B (D):;K2 B (D):;Rm B (mm):;Km B (mm):;Axis B (flat):;Astig B (D):;R Per B (mm):;R Min B (mm):;Num. Ecc. B:;Asph. Q B:;Ecc. Zone:;Pachy Apex:;Pachy Pupil:;Pupil Pos X:;Pupil Pos Y:;Pachy Min:;Pachy Min Pos X:;Pachy Min Pos Y:;C.Vol D 3mm:;C.Vol D 5mm:;C.Vol D 7mm:;C.Vol D 10mm:;ISV:;IVA:;KI:;CKI:;IHA:;IHD:;RSagMin:;TKC:;D0mm Pachy;D2mm Pachy;D4mm Pachy;D6mm Pachy;D8mm Pachy;D10mm Pachy;D0mm Prog;D2mm Prog;D4mm Prog;D6mm Prog;D8mm Prog;D10mm Prog;KMax Sagittal Front (D);Measuring Head Status:;Measuring Head Status Text:;Measuring Head Type:;')));
                $this->exam_type  = 'summary';
            }
        }
    }
}
