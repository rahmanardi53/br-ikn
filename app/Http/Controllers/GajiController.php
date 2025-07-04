<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\GajiMaster;

class GajiController extends Controller
{
    public function index(Request $request)
    {
        $senin = $request->input('senin');
        
        // Default: senin minggu ini
        if (!$senin) {
            $senin = Carbon::now()->startOfWeek(Carbon::MONDAY)->format('Y-m-d');
        }

        $periodeAwal = Carbon::parse($senin)->subDays(7);
        $periodeAkhir = Carbon::parse($senin)->subDays(1);

        $data = DB::table('absensis')
            ->join('users', 'users.id', '=', 'absensis.user_id')
            ->join('gaji_masters', 'gaji_masters.user_id', '=', 'users.id')
            ->select(
                'users.id as user_id',
                'users.name',
                'gaji_masters.gaji_pokok',
                DB::raw('SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(off_duty, on_duty)))) as total_waktu')
            )
            ->whereBetween('tanggal', [$periodeAwal->format('Y-m-d'), $periodeAkhir->format('Y-m-d')])
            ->groupBy('users.id', 'users.name', 'gaji_masters.gaji_pokok')
            ->get();

        // Hitung total gaji
        $rekap = [];
        foreach ($data as $item) {
            $waktu = explode(':', $item->total_waktu);
            $totalJam = $waktu[0] + ($waktu[1] / 60);

            if ($totalJam > 15) {
                $totalGaji = $item->gaji_pokok + 500000;
                $bonus = 500000;
            } else {
                $totalGaji = ($item->gaji_pokok / 15) * $totalJam;
                $bonus = 0;
            }

            $rekap[] = [
                'name' => $item->name,
                'total_jam' => $totalJam,
                'gaji_pokok' => $item->gaji_pokok,
                'bonus' => $bonus,
                'total_gaji' => $totalGaji,
            ];
        }

        return view('gaji.index', [
            'rekap' => $rekap,
            'senin' => $senin,
            'periodeAwal' => $periodeAwal->format('Y-m-d'),
            'periodeAkhir' => $periodeAkhir->format('Y-m-d'),
        ]);
    }
}
