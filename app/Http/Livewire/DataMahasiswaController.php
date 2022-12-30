<?php

namespace App\Http\Livewire;

use App\Models\DataKelas;
use App\Models\DataMahasiswa;
use App\Models\DataProdi;
use App\Models\DataSemester;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;


class DataMahasiswaController extends Component
{
    public $tbl_data_mahasiswa_id;
    public $kode_mahasiswa;
    public $nama_mahasiswa;
    public $email_mahasiswa;
    public $telepon_mahasiswa;
    public $alamat_mahasiswa;
    public $data_prodi_id;
    public $kelas_id;
    public $data_semester_id;

    public $form_active = false;
    public $form = false;
    public $update_mode = false;
    public $modal = true;

    protected $listeners = ['getDataDataMahasiswaById', 'getDataMahasiswaId'];

    public function render()
    {
        return view('livewire..tbl-data-mahasiswa', [
            'items' => DataMahasiswa::all(),
            'prodies' => DataProdi::all(),
            'kelass' => DataKelas::where('data_prodi_id', $this->data_prodi_id)->get(),
            'semesters' => DataSemester::all(),
        ]);
    }

    public function store()
    {
        $this->_validate();
        try {
            DB::beginTransaction();
            $role_mhs = Role::where('role_type', 'mahasiswa')->first();

            $user = User::create([
                'name' => $this->nama_mahasiswa,
                'email' => strtolower(str_replace(' ', '', $this->nama_mahasiswa)) . rand(111, 999) . '@gmail.com',
                'username' => $this->kode_mahasiswa,
                'password' => Hash::make('mahasiswa123'),
                'current_team_id' => 1,
            ]);

            $data = [
                'kode_mahasiswa'  => $this->kode_mahasiswa,
                'nama_mahasiswa'  => $this->nama_mahasiswa,
                'email_mahasiswa'  => $this->email_mahasiswa,
                'telepon_mahasiswa'  => $this->telepon_mahasiswa,
                'alamat_mahasiswa'  => $this->alamat_mahasiswa,
                'data_prodi_id'  => $this->data_prodi_id,
                'data_semester_id'  => $this->data_semester_id,
                'user_id' => $user->id
            ];

            $mahasiswa = DataMahasiswa::create($data);
            $user->roles()->attach($role_mhs->id);
            $user->teams()->attach(1, ['role' => $role_mhs->role_type]);
            $mahasiswa->kelas()->sync($this->kelas_id);
            DB::commit();
            $this->_reset();
            return $this->emit('showAlert', ['msg' => 'Data Berhasil Disimpan']);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->emit('showAlertError', ['msg' => 'Data Gagal Disimpan ' . $th->getMessage()]);
        }
    }

    public function update()
    {
        $this->_validate();

        $data = [
            'kode_mahasiswa'  => $this->kode_mahasiswa,
            'nama_mahasiswa'  => $this->nama_mahasiswa,
            'email_mahasiswa'  => $this->email_mahasiswa,
            'telepon_mahasiswa'  => $this->telepon_mahasiswa,
            'alamat_mahasiswa'  => $this->alamat_mahasiswa,
            'data_prodi_id'  => $this->data_prodi_id,
            'data_semester_id'  => $this->data_semester_id,
        ];
        $row = DataMahasiswa::find($this->tbl_data_mahasiswa_id);
        $row->user()->update([
            'name' => $this->nama_mahasiswa,
            'username' => $this->kode_mahasiswa,
        ]);
        $row->update($data);
        $row->kelas()->sync($this->kelas_id);
        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Diupdate']);
    }

    public function delete()
    {
        DataMahasiswa::find($this->tbl_data_mahasiswa_id)->delete();

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Dihapus']);
    }

    public function _validate()
    {
        $rule = [
            'kode_mahasiswa'  => 'required',
            'nama_mahasiswa'  => 'required',
            'telepon_mahasiswa'  => 'required|numeric',
            'alamat_mahasiswa'  => 'required',
            'data_prodi_id'  => 'required',
            'kelas_id'  => 'required',
            'data_semester_id'  => 'required',
        ];

        return $this->validate($rule);
    }

    public function getDataDataMahasiswaById($tbl_data_mahasiswa_id)
    {
        $this->_reset();
        $tbl_data_mahasiswa = DataMahasiswa::find($tbl_data_mahasiswa_id);
        $this->tbl_data_mahasiswa_id = $tbl_data_mahasiswa->id;
        $this->kode_mahasiswa = $tbl_data_mahasiswa->kode_mahasiswa;
        $this->nama_mahasiswa = $tbl_data_mahasiswa->nama_mahasiswa;
        $this->email_mahasiswa = $tbl_data_mahasiswa->email_mahasiswa;
        $this->telepon_mahasiswa = $tbl_data_mahasiswa->telepon_mahasiswa;
        $this->alamat_mahasiswa = $tbl_data_mahasiswa->alamat_mahasiswa;
        $this->data_prodi_id = $tbl_data_mahasiswa->data_prodi_id;
        $this->data_semester_id = $tbl_data_mahasiswa->data_semester_id;
        $this->kelas_id = $tbl_data_mahasiswa->kelas()->first()->id;
        if ($this->form) {
            $this->form_active = true;
            $this->emit('loadForm');
        }
        if ($this->modal) {
            $this->emit('showModal');
        }
        $this->update_mode = true;
    }

    public function getDataMahasiswaId($tbl_data_mahasiswa_id)
    {
        $tbl_data_mahasiswa = DataMahasiswa::find($tbl_data_mahasiswa_id);
        $this->tbl_data_mahasiswa_id = $tbl_data_mahasiswa->id;
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
        $this->tbl_data_mahasiswa_id = null;
        $this->kode_mahasiswa = null;
        $this->nama_mahasiswa = null;
        $this->email_mahasiswa = null;
        $this->telepon_mahasiswa = null;
        $this->alamat_mahasiswa = null;
        $this->data_prodi_id = null;
        $this->data_semester_id = null;
        $this->form = false;
        $this->form_active = false;
        $this->update_mode = false;
        $this->modal = true;
    }
}
