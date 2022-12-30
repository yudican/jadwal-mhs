<?php

namespace App\Http\Livewire\Master;

use App\Models\DataMatakuliah;
use App\Models\DataProdi;
use Livewire\Component;


class DataMatakuliahController extends Component
{

    public $tbl_data_matakuliah_id;
    public $kode_matakuliah;
    public $nama_matakuliah;
    public $jumlah_sks;
    public $data_prodi_id;

    public $form_active = false;
    public $form = false;
    public $update_mode = false;
    public $modal = true;

    protected $listeners = ['getDataDataMatakuliahById', 'getDataMatakuliahId'];

    public function render()
    {
        return view('livewire.master.tbl-data-matakuliah', [
            'items' => DataMatakuliah::all(),
            'prodies' => DataProdi::all()
        ]);
    }

    public function store()
    {
        $this->_validate();

        $data = [
            'kode_matakuliah'  => $this->kode_matakuliah,
            'nama_matakuliah'  => $this->nama_matakuliah,
            'jumlah_sks'  => $this->jumlah_sks,
            'data_prodi_id'  => $this->data_prodi_id
        ];

        DataMatakuliah::create($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Disimpan']);
    }

    public function update()
    {
        $this->_validate();

        $data = [
            'kode_matakuliah'  => $this->kode_matakuliah,
            'nama_matakuliah'  => $this->nama_matakuliah,
            'jumlah_sks'  => $this->jumlah_sks,
            'data_prodi_id'  => $this->data_prodi_id
        ];
        $row = DataMatakuliah::find($this->tbl_data_matakuliah_id);



        $row->update($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Diupdate']);
    }

    public function delete()
    {
        DataMatakuliah::find($this->tbl_data_matakuliah_id)->delete();

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Dihapus']);
    }

    public function _validate()
    {
        $rule = [
            'kode_matakuliah'  => 'required',
            'nama_matakuliah'  => 'required',
            'jumlah_sks'  => 'required',
            'data_prodi_id'  => 'required'
        ];

        return $this->validate($rule);
    }

    public function getDataDataMatakuliahById($tbl_data_matakuliah_id)
    {
        $this->_reset();
        $tbl_data_matakuliah = DataMatakuliah::find($tbl_data_matakuliah_id);
        $this->tbl_data_matakuliah_id = $tbl_data_matakuliah->id;
        $this->kode_matakuliah = $tbl_data_matakuliah->kode_matakuliah;
        $this->nama_matakuliah = $tbl_data_matakuliah->nama_matakuliah;
        $this->jumlah_sks = $tbl_data_matakuliah->jumlah_sks;
        $this->data_prodi_id = $tbl_data_matakuliah->data_prodi_id;
        if ($this->form) {
            $this->form_active = true;
            $this->emit('loadForm');
        }
        if ($this->modal) {
            $this->emit('showModal');
        }
        $this->update_mode = true;
    }

    public function getDataMatakuliahId($tbl_data_matakuliah_id)
    {
        $tbl_data_matakuliah = DataMatakuliah::find($tbl_data_matakuliah_id);
        $this->tbl_data_matakuliah_id = $tbl_data_matakuliah->id;
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
        $this->tbl_data_matakuliah_id = null;
        $this->kode_matakuliah = null;
        $this->nama_matakuliah = null;
        $this->jumlah_sks = null;
        $this->data_prodi_id = null;
        $this->form = false;
        $this->form_active = false;
        $this->update_mode = false;
        $this->modal = true;
    }
}
