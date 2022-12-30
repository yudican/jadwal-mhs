<?php

namespace App\Http\Livewire;

use App\Models\DataDosen;
use App\Models\DataJadwal;
use App\Models\DataKelas;
use App\Models\DataMahasiswa;
use App\Models\DataNotifikasi;
use App\Models\DataProdi;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $jadwal = DataJadwal::count();
        $notifikasi = DataNotifikasi::where('user_id', auth()->user()->id)->count();
        $dosen = DataDosen::count();
        $mahasiswa = DataMahasiswa::count();
        $kelas = DataKelas::count();
        $prodi = DataProdi::count();
        return view('livewire.dashboard', [
            'jadwal' => $jadwal,
            'notifikasi' => $notifikasi,
            'dosen' => $dosen,
            'mahasiswa' => $mahasiswa,
            'kelas' => $kelas,
            'prodi' => $prodi,
        ]);
    }
}
