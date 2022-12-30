<?php

namespace App\Http\Livewire\Master;

use App\Models\DataKelas;
use App\Models\DataProdi;
use App\Models\DataSemester;
use Livewire\Component;


class DataKelasController extends Component
{

    public $tbl_data_kelas_id;
    public $kode_kelas;
    public $nama_kelas;
    public $data_prodi_id;
    public $data_semester_id;



    public $form_active = false;
    public $form = false;
    public $update_mode = false;
    public $modal = true;

    protected $listeners = ['getDataDataKelasById', 'getDataKelasId'];

    public function render()
    {
        return view('livewire.master.tbl-data-kelas', [
            'items' => DataKelas::all(),
            'prodies' => DataProdi::all(),
            'semesters' => DataSemester::all(),
        ]);
    }

    public function store()
    {
        $this->_validate();

        $data = [
            'kode_kelas'  => $this->kode_kelas,
            'nama_kelas'  => $this->nama_kelas,
            'data_prodi_id'  => $this->data_prodi_id,
            'data_semester_id'  => $this->data_semester_id,
        ];

        DataKelas::create($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Disimpan']);
    }

    public function update()
    {
        $this->_validate();

        $data = [
            'kode_kelas'  => $this->kode_kelas,
            'nama_kelas'  => $this->nama_kelas,
            'data_prodi_id'  => $this->data_prodi_id,
            'data_semester_id'  => $this->data_semester_id,
        ];
        $row = DataKelas::find($this->tbl_data_kelas_id);



        $row->update($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Diupdate']);
    }

    public function delete()
    {
        DataKelas::find($this->tbl_data_kelas_id)->delete();

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Dihapus']);
    }

    public function _validate()
    {
        $rule = [
            'kode_kelas'  => 'required',
            'nama_kelas'  => 'required',
            'data_prodi_id'  => 'required',
            'data_semester_id'  => 'required',
        ];

        return $this->validate($rule);
    }

    public function getDataDataKelasById($tbl_data_kelas_id)
    {
        $this->_reset();
        $tbl_data_kelas = DataKelas::find($tbl_data_kelas_id);
        $this->tbl_data_kelas_id = $tbl_data_kelas->id;
        $this->kode_kelas = $tbl_data_kelas->kode_kelas;
        $this->nama_kelas = $tbl_data_kelas->nama_kelas;
        $this->data_prodi_id = $tbl_data_kelas->data_prodi_id;
        $this->data_semester_id = $tbl_data_kelas->data_semester_id;
        if ($this->form) {
            $this->form_active = true;
            $this->emit('loadForm');
        }
        if ($this->modal) {
            $this->emit('showModal');
        }
        $this->update_mode = true;
    }

    public function getDataKelasId($tbl_data_kelas_id)
    {
        $tbl_data_kelas = DataKelas::find($tbl_data_kelas_id);
        $this->tbl_data_kelas_id = $tbl_data_kelas->id;
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
        $this->tbl_data_kelas_id = null;
        $this->kode_kelas = null;
        $this->nama_kelas = null;
        $this->data_prodi_id = null;
        $this->data_semester_id = null;
        $this->form = false;
        $this->form_active = false;
        $this->update_mode = false;
        $this->modal = true;
    }
}
