<?php

namespace App\Http\Livewire;

use App\Models\DataDosen;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;


class DataDosenController extends Component
{

    public $tbl_data_dosen_id;
    public $kode_dosen;
    public $nama_dosen;
    public $email_dosen;
    public $telepon_dosen;
    public $alamat_dosen;
    public $jabatan_dosen;



    public $form_active = false;
    public $form = false;
    public $update_mode = false;
    public $modal = true;

    protected $listeners = ['getDataDataDosenById', 'getDataDosenId'];

    public function render()
    {
        return view('livewire..tbl-data-dosen', [
            'items' => DataDosen::all()
        ]);
    }

    public function store()
    {
        $this->_validate();

        try {
            DB::beginTransaction();
            $role_dosen = Role::where('role_type', 'dosen')->first();

            $user = User::create([
                'name' => $this->nama_dosen,
                'email' => strtolower(str_replace(' ', '', $this->nama_dosen)) . rand(111, 999) . '@gmail.com',
                'username' => $this->kode_dosen,
                'password' => Hash::make('dosen123'),
                'current_team_id' => 1,
            ]);

            $data = [
                'kode_dosen'  => $this->kode_dosen,
                'nama_dosen'  => $this->nama_dosen,
                'email_dosen'  => $this->email_dosen,
                'telepon_dosen'  => $this->telepon_dosen,
                'alamat_dosen'  => $this->alamat_dosen,
                'jabatan_dosen'  => $this->jabatan_dosen,
                'user_id' => $user->id
            ];

            DataDosen::create($data);
            $user->roles()->attach($role_dosen->id);
            $user->teams()->attach(1, ['role' => $role_dosen->role_type]);
            DB::commit();
            $this->_reset();
            return $this->emit('showAlert', ['msg' => 'Data Berhasil Disimpan']);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->emit('showAlertError', ['msg' => 'Data Gagal Disimpan']);
        }
    }

    public function update()
    {
        $this->_validate();

        $data = [
            'kode_dosen'  => $this->kode_dosen,
            'nama_dosen'  => $this->nama_dosen,
            'email_dosen'  => $this->email_dosen,
            'telepon_dosen'  => $this->telepon_dosen,
            'alamat_dosen'  => $this->alamat_dosen,
            'jabatan_dosen'  => $this->jabatan_dosen
        ];
        $row = DataDosen::find($this->tbl_data_dosen_id);
        $row->user()->update([
            'name' => $this->nama_dosen,
            'username' => $this->kode_dosen,
        ]);
        $row->update($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Diupdate']);
    }

    public function delete()
    {
        DataDosen::find($this->tbl_data_dosen_id)->delete();

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Dihapus']);
    }

    public function _validate()
    {
        $rule = [
            'kode_dosen'  => 'required',
            'nama_dosen'  => 'required',
            'telepon_dosen'  => 'required',
            'alamat_dosen'  => 'required',
            'jabatan_dosen'  => 'required'
        ];

        return $this->validate($rule);
    }

    public function getDataDataDosenById($tbl_data_dosen_id)
    {
        $this->_reset();
        $tbl_data_dosen = DataDosen::find($tbl_data_dosen_id);
        $this->tbl_data_dosen_id = $tbl_data_dosen->id;
        $this->kode_dosen = $tbl_data_dosen->kode_dosen;
        $this->nama_dosen = $tbl_data_dosen->nama_dosen;
        $this->email_dosen = $tbl_data_dosen->email_dosen;
        $this->telepon_dosen = $tbl_data_dosen->telepon_dosen;
        $this->alamat_dosen = $tbl_data_dosen->alamat_dosen;
        $this->jabatan_dosen = $tbl_data_dosen->jabatan_dosen;
        if ($this->form) {
            $this->form_active = true;
            $this->emit('loadForm');
        }
        if ($this->modal) {
            $this->emit('showModal');
        }
        $this->update_mode = true;
    }

    public function getDataDosenId($tbl_data_dosen_id)
    {
        $tbl_data_dosen = DataDosen::find($tbl_data_dosen_id);
        $this->tbl_data_dosen_id = $tbl_data_dosen->id;
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
        $this->tbl_data_dosen_id = null;
        $this->kode_dosen = null;
        $this->nama_dosen = null;
        $this->email_dosen = null;
        $this->telepon_dosen = null;
        $this->alamat_dosen = null;
        $this->jabatan_dosen = null;
        $this->form = false;
        $this->form_active = false;
        $this->update_mode = false;
        $this->modal = true;
    }
}
