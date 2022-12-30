<?php

namespace App\Http\Livewire\Master;

use App\Models\DataProdi;
use Livewire\Component;


class DataProdiController extends Component
{
    
    public $tbl_data_prodi_id;
    public $kode_prodi;
public $nama_prodi;
    
   

    public $form_active = false;
    public $form = false;
    public $update_mode = false;
    public $modal = true;

    protected $listeners = ['getDataDataProdiById', 'getDataProdiId'];

    public function render()
    {
        return view('livewire.master.tbl-data-prodi', [
            'items' => DataProdi::all()
        ]);
    }

    public function store()
    {
        $this->_validate();
        
        $data = ['kode_prodi'  => $this->kode_prodi,
'nama_prodi'  => $this->nama_prodi];

        DataProdi::create($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Disimpan']);
    }

    public function update()
    {
        $this->_validate();

        $data = ['kode_prodi'  => $this->kode_prodi,
'nama_prodi'  => $this->nama_prodi];
        $row = DataProdi::find($this->tbl_data_prodi_id);

        

        $row->update($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Diupdate']);
    }

    public function delete()
    {
        DataProdi::find($this->tbl_data_prodi_id)->delete();

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Dihapus']);
    }

    public function _validate()
    {
        $rule = [
            'kode_prodi'  => 'required',
'nama_prodi'  => 'required'
        ];

        return $this->validate($rule);
    }

    public function getDataDataProdiById($tbl_data_prodi_id)
    {
        $this->_reset();
        $tbl_data_prodi = DataProdi::find($tbl_data_prodi_id);
        $this->tbl_data_prodi_id = $tbl_data_prodi->id;
        $this->kode_prodi = $tbl_data_prodi->kode_prodi;
$this->nama_prodi = $tbl_data_prodi->nama_prodi;
        if ($this->form) {
            $this->form_active = true;
            $this->emit('loadForm');
        }
        if ($this->modal) {
            $this->emit('showModal');
        }
        $this->update_mode = true;
    }

    public function getDataProdiId($tbl_data_prodi_id)
    {
        $tbl_data_prodi = DataProdi::find($tbl_data_prodi_id);
        $this->tbl_data_prodi_id = $tbl_data_prodi->id;
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
        $this->tbl_data_prodi_id = null;
        $this->kode_prodi = null;
$this->nama_prodi = null;
        $this->form = false;
        $this->form_active = false;
        $this->update_mode = false;
        $this->modal = true;
    }
}
