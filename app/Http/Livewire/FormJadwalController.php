<?php

namespace App\Http\Livewire;

use App\Models\DataDosen;
use App\Models\DataJadwal;
use App\Models\DataKelas;
use App\Models\DataNotifikasi;
use App\Models\FormJadwal;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;


class FormJadwalController extends Component
{

    public $tbl_form_jadwal_id;
    public $alasan_perubahan;
    public $hari_perubahan;
    public $jam_perubahan;
    public $status;
    public $keterangan;
    public $data_kelas_id;
    public $data_dosen_id;
    public $data_jadwal_id;
    public $admin_id = 'e859c822-4bd1-472b-84eb-361799c0d850';

    public $form_active = false;
    public $form = false;
    public $update_mode = false;
    public $modal = true;

    protected $listeners = ['getDataFormJadwalById', 'getFormJadwalId'];

    public function render()
    {
        $dosen = auth()->user()->dosen;
        $jadwals = DataJadwal::all();
        if (Auth::user()->role->role_type == 'dosen') {
            $jadwals = DataJadwal::where('data_dosen_id', $dosen->id)->get();
        }
        return view('livewire..tbl-form-jadwal', [
            'items' => FormJadwal::all(),
            'kelass' => DataKelas::all(),
            'dosens' => DataDosen::all(),
            'jadwals' => $jadwals,
        ]);
    }

    public function store()
    {
        $this->_validate();

        $dosen = auth()->user()->dosen;
        $data = [
            'alasan_perubahan'  => $this->alasan_perubahan,
            'hari_perubahan'  => $this->hari_perubahan,
            'jam_perubahan'  => $this->jam_perubahan,
            'status'  => $this->status,
            'keterangan'  => $this->keterangan,
            'data_kelas_id'  => $this->data_kelas_id,
            'data_dosen_id'  => $dosen->id,
            'data_jadwal_id'  => $this->data_jadwal_id
        ];

        DataNotifikasi::create([
            'title' => 'Perubahan Jadwal',
            'body' => $dosen->nama_dosen . ' Telah Melakukan Permintaan Perubahan Jadwal',
            'user_id' => $this->admin_id,
            'tanggal' => Carbon::now()
        ]);

        FormJadwal::create($data);
        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Disimpan']);
    }

    public function update()
    {
        $this->_validate();
        $dosen = DataDosen::find($this->data_dosen_id);
        $data = [
            'alasan_perubahan'  => $this->alasan_perubahan,
            'hari_perubahan'  => $this->hari_perubahan,
            'jam_perubahan'  => $this->jam_perubahan,
            'status'  => $this->status,
            'keterangan'  => $this->keterangan,
            'data_kelas_id'  => $this->data_kelas_id,
            'data_dosen_id'  => $this->data_dosen_id,
            'data_jadwal_id'  => $this->data_jadwal_id
        ];
        $row = FormJadwal::find($this->tbl_form_jadwal_id);

        if ($this->status == 1) {
            DataNotifikasi::create([
                'title' => 'Jadwal Perubahan Diterima',
                'body' =>  'Selamat Data Perubahan Jadwal Telah Disetujui',
                'user_id' => $dosen->user->id,
                'tanggal' => Carbon::now()
            ]);

            foreach ($row->kelas->mahasiswa as $mahasiswa) {
                DataNotifikasi::create([
                    'title' => 'Informasi Perubahan Jadwal',
                    'body' =>  'Jadwal Telah Dirubah silahkan ke menu jadwal untuk melihat detail perubahan',
                    'user_id' => $mahasiswa->user_id,
                    'tanggal' => Carbon::now()
                ]);
            }
        }

        if ($this->status == 2) {
            DataNotifikasi::create([
                'title' => 'Jadwal Ditolak',
                'body' =>  'Mohon Maaf Perubahan Jadwal Belum Disetujui',
                'user_id' => $this->data_dosen_id,
                'tanggal' => Carbon::now()
            ]);
        }

        $row->update($data);
        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Diupdate']);
    }

    public function delete()
    {
        FormJadwal::find($this->tbl_form_jadwal_id)->delete();

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Dihapus']);
    }

    public function _validate()
    {
        if (auth()->user()->role->role_type == 'dosen') {
            $rule = [
                'alasan_perubahan'  => 'required',
                'hari_perubahan'  => 'required',
                'jam_perubahan'  => 'required',
                'data_kelas_id'  => 'required',
                'data_jadwal_id'  => 'required'
            ];
        }
        if (in_array(auth()->user()->role->role_type, ['superadmin', 'admin'])) {
            $rule = [
                'status'  => 'required',
            ];

            if ($this->status == 2) {
                $rule['status'] = 'required';
            }
        }

        return $this->validate($rule);
    }

    public function getDataFormJadwalById($tbl_form_jadwal_id)
    {
        $this->_reset();
        $tbl_form_jadwal = FormJadwal::find($tbl_form_jadwal_id);
        $this->tbl_form_jadwal_id = $tbl_form_jadwal->id;
        $this->alasan_perubahan = $tbl_form_jadwal->alasan_perubahan;
        $this->hari_perubahan = $tbl_form_jadwal->hari_perubahan;
        $this->jam_perubahan = $tbl_form_jadwal->jam_perubahan;
        $this->status = $tbl_form_jadwal->status;
        $this->keterangan = $tbl_form_jadwal->keterangan;
        $this->data_kelas_id = $tbl_form_jadwal->data_kelas_id;
        $this->data_dosen_id = $tbl_form_jadwal->data_dosen_id;
        $this->data_jadwal_id = $tbl_form_jadwal->data_jadwal_id;
        if ($this->form) {
            $this->form_active = true;
            $this->emit('loadForm');
        }
        if ($this->modal) {
            $this->emit('showModal');
        }
        $this->update_mode = true;
    }

    public function getFormJadwalId($tbl_form_jadwal_id)
    {
        $tbl_form_jadwal = FormJadwal::find($tbl_form_jadwal_id);
        $this->tbl_form_jadwal_id = $tbl_form_jadwal->id;
    }

    public function toggleForm($form)
    {
        $this->_reset();
        $this->form_active = $form;
        $this->emit('loadForm');
    }

    public function showModal()
    {
        $this->_reset();
        $this->emit('showModal');
    }

    public function _reset()
    {
        $this->emit('closeModal');
        $this->emit('refreshTable');
        $this->tbl_form_jadwal_id = null;
        $this->alasan_perubahan = null;
        $this->hari_perubahan = null;
        $this->jam_perubahan = null;
        $this->status = null;
        $this->keterangan = null;
        $this->data_kelas_id = null;
        $this->data_dosen_id = null;
        $this->data_jadwal_id = null;
        $this->form = false;
        $this->form_active = false;
        $this->update_mode = false;
        $this->modal = true;
    }
}
