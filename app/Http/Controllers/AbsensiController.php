<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use Illuminate\Support\Facades\Auth;
// use Carbon\Carbon;


class AbsensiController extends Controller
{
    public function index()
    {
        return view('absensi.form');
    }

    public function store(Request $request)
    {
        Absensi::create([
            'user_id' => auth()->id(),
            'tanggal' => $request->tanggal,
            'on_duty' => $request->on_duty,
        ]);

        return back()->with('success', 'Absen datang berhasil.');
    }

    // public function pulang(Request $request)
    // {
    //     $absenAktif = Absensi::where('user_id', auth()->id())
    //         ->whereDate('tanggal', $request->tanggal)
    //         ->whereNull('off_duty')
    //         ->latest()
    //         ->first();

    //     if ($absenAktif) {
    //         $absenAktif->update([
    //             'off_duty' => $request->off_duty,
    //         ]);

    //         return back()->with('success', 'Absen pulang berhasil.');
    //     }

    //     return back()->with('error', 'Tidak ditemukan absen datang yang aktif.');
    // }


public function pulang(Request $request)
{
    $userId = auth()->id();
    $tanggal = $request->tanggal;
    $offDuty = $request->off_duty;

    $absenAktif = Absensi::where('user_id', $userId)
        // ->whereDate('tanggal', $tanggal)
        ->whereNull('off_duty')
        ->latest()
        ->first();

    if (!$absenAktif) {
        return back()->with('error', 'Absen masuk tidak ditemukan.');
    }

    $onDuty = $absenAktif->on_duty;

    if ($onDuty > $offDuty) {
        // Lewat tengah malam, pisah jadi dua record
        // 1. Update record lama sampai 23:59:59
        $absenAktif->update([
            'off_duty' => '23:59:59'
        ]);

        // 2. Buat record baru di tanggal besok
        // $tanggalBesok = Carbon\Carbon::parse($tanggal)->addDay()->format('Y-m-d');

        $dataBaru = Absensi::create([
            'user_id'  => $userId,
            'tanggal'  => $tanggal,
            'on_duty'  => '00:00:00',
            'off_duty' => $offDuty
        ]);

        // dd($dataBaru);

    } else {
        // Normal, langsung update
        $absenAktif->update([
            'off_duty' => $offDuty
        ]);
    }

    return back()->with('success', 'Absen pulang berhasil.');
}



}
