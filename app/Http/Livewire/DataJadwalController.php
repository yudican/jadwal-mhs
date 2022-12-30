<?php

namespace App\Http\Livewire;

use App\Models\DataDosen;
use App\Models\DataJadwal;
use App\Models\DataKelas;
use App\Models\DataMatakuliah;
use App\Models\DataProdi;
use App\Models\DataSemester;
use Livewire\Component;


class DataJadwalController extends Component
{

    public $tbl_data_jadwal_id;
    public $kode_jadwal;
    public $waktu_jadwal;
    public $hari_jadwal;
    public $data_matakuliah_id;
    public $data_kelas_id;
    public $data_dosen_id;
    public $data_prodi_id;
    public $data_semester_id;

    public $form_active = false;
    public $form = false;
    public $update_mode = false;
    public $modal = true;

    protected $listeners = ['getDataDataJadwalById', 'getDataJadwalId'];

    public function render()
    {
        return view('livewire..tbl-data-jadwal', [
            'items' => DataJadwal::all(),
            'prodies' => DataProdi::all(),
            'kelass' => DataKelas::where('data_prodi_id', $this->data_prodi_id)->get(),
            'dosens' => DataDosen::all(),
            'matkuls' => DataMatakuliah::where('data_prodi_id', $this->data_prodi_id)->get(),
            'semesters' => DataSemester::all(),
        ]);
    }

    public function store()
    {
        $this->_validate();

        $data = [
            'kode_jadwal'  => $this->kode_jadwal,
            'waktu_jadwal'  => $this->waktu_jadwal,
            'hari_jadwal'  => $this->hari_jadwal,
            'data_matakuliah_id'  => $this->data_matakuliah_id,
            'data_kelas_id'  => $this->data_kelas_id,
            'data_dosen_id'  => $this->data_dosen_id,
            'data_prodi_id'  => $this->data_prodi_id,
            'data_semester_id'  => $this->data_semester_id,
        ];

        DataJadwal::create($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Disimpan']);
    }

    public function update()
    {
        $this->_validate();

        $data = [
            'kode_jadwal'  => $this->kode_jadwal,
            'waktu_jadwal'  => $this->waktu_jadwal,
            'hari_jadwal'  => $this->hari_jadwal,
            'data_matakuliah_id'  => $this->data_matakuliah_id,
            'data_kelas_id'  => $this->data_kelas_id,
            'data_dosen_id'  => $this->data_dosen_id,
            'data_prodi_id'  => $this->data_prodi_id,
            'data_semester_id'  => $this->data_semester_id,
        ];
        $row = DataJadwal::find($this->tbl_data_jadwal_id);



        $row->update($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Diupdate']);
    }

    public function delete()
    {
        DataJadwal::find($this->tbl_data_jadwal_id)->delete();

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Dihapus']);
    }

    public function selectSemester($data_semester_id)
    {
        return $this->emit('setFilterJadwal', $data_semester_id);
    }

    public function _validate()
    {
        $rule = [
            'kode_jadwal'  => 'required',
            'waktu_jadwal'  => 'required',
            'hari_jadwal'  => 'required',
            'data_matakuliah_id'  => 'required',
            'data_kelas_id'  => 'required',
            'data_dosen_id'  => 'required',
            'data_prodi_id'  => 'required',
            'data_semester_id'  => 'required',
        ];

        return $this->validate($rule);
    }

    public function getDataDataJadwalById($tbl_data_jadwal_id)
    {
        $this->_reset();
        $tbl_data_jadwal = DataJadwal::find($tbl_data_jadwal_id);
        $this->tbl_data_jadwal_id = $tbl_data_jadwal->id;
        $this->kode_jadwal = $tbl_data_jadwal->kode_jadwal;
        $this->waktu_jadwal = $tbl_data_jadwal->waktu_jadwal;
        $this->hari_jadwal = $tbl_data_jadwal->hari_jadwal;
        $this->data_matakuliah_id = $tbl_data_jadwal->data_matakuliah_id;
        $this->data_kelas_id = $tbl_data_jadwal->data_kelas_id;
        $this->data_dosen_id = $tbl_data_jadwal->data_dosen_id;
        $this->data_prodi_id = $tbl_data_jadwal->data_prodi_id;
        $this->data_semester_id = $tbl_data_jadwal->data_semester_id;
        if ($this->form) {
            $this->form_active = true;
            $this->emit('loadForm');
        }
        if ($this->modal) {
            $this->emit('showModal');
        }
        $this->update_mode = true;
    }

    public function getDataJadwalId($tbl_data_jadwal_id)
    {
        $tbl_data_jadwal = DataJadwal::find($tbl_data_jadwal_id);
        $this->tbl_data_jadwal_id = $tbl_data_jadwal->id;
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
        $this->tbl_data_jadwal_id = null;
        $this->kode_jadwal = null;
        $this->waktu_jadwal = null;
        $this->hari_jadwal = null;
        $this->data_matakuliah_id = null;
        $this->data_kelas_id = null;
        $this->data_dosen_id = null;
        $this->data_prodi_id = null;
        $this->data_semester_id = null;
        $this->form = false;
        $this->form_active = false;
        $this->update_mode = false;
        $this->modal = true;
    }
}
