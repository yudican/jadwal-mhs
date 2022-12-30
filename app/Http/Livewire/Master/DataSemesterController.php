<?php

namespace App\Http\Livewire\Master;

use App\Models\DataSemester;
use Livewire\Component;


class DataSemesterController extends Component
{

    public $tbl_data_semester_id;
    public $kode_semester;
    public $nama_semester;



    public $form_active = false;
    public $form = false;
    public $update_mode = false;
    public $modal = true;

    protected $listeners = ['getDataDataSemesterById', 'getDataSemesterId'];

    public function render()
    {
        return view('livewire.master.tbl-data-semester', [
            'items' => DataSemester::all()
        ]);
    }

    public function store()
    {
        $this->_validate();

        $data = [
            'kode_semester'  => $this->kode_semester,
            'nama_semester'  => $this->nama_semester
        ];

        DataSemester::create($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Disimpan']);
    }

    public function update()
    {
        $this->_validate();

        $data = [
            'kode_semester'  => $this->kode_semester,
            'nama_semester'  => $this->nama_semester
        ];
        $row = DataSemester::find($this->tbl_data_semester_id);



        $row->update($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Diupdate']);
    }

    public function delete()
    {
        DataSemester::find($this->tbl_data_semester_id)->delete();

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Dihapus']);
    }

    public function _validate()
    {
        $rule = [
            'kode_semester'  => 'required',
            'nama_semester'  => 'required'
        ];

        return $this->validate($rule);
    }

    public function getDataDataSemesterById($tbl_data_semester_id)
    {
        $this->_reset();
        $tbl_data_semester = DataSemester::find($tbl_data_semester_id);
        $this->tbl_data_semester_id = $tbl_data_semester->id;
        $this->kode_semester = $tbl_data_semester->kode_semester;
        $this->nama_semester = $tbl_data_semester->nama_semester;
        if ($this->form) {
            $this->form_active = true;
            $this->emit('loadForm');
        }
        if ($this->modal) {
            $this->emit('showModal');
        }
        $this->update_mode = true;
    }

    public function getDataSemesterId($tbl_data_semester_id)
    {
        $tbl_data_semester = DataSemester::find($tbl_data_semester_id);
        $this->tbl_data_semester_id = $tbl_data_semester->id;
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
        $this->tbl_data_semester_id = null;
        $this->kode_semester = null;
        $this->nama_semester = null;
        $this->form = false;
        $this->form_active = false;
        $this->update_mode = false;
        $this->modal = true;
    }
}
