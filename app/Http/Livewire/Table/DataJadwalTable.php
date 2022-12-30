<?php

namespace App\Http\Livewire\Table;

use App\Models\HideableColumn;
use App\Models\DataJadwal;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use App\Http\Livewire\Table\LivewireDatatable;

class DataJadwalTable extends LivewireDatatable
{
    protected $listeners = ['refreshTable', 'setFilterJadwal'];
    public $hideable = 'select';
    public $table_name = 'tbl_data_jadwal';
    public $hide = [];
    public $semester_id = null;


    public function builder()
    {
        $user = auth()->user();
        $role = $user->role->role_type;
        if (in_array($role, ['admin', 'superadmin'])) {
            if ($this->semester_id) {
                return DataJadwal::query()->where('data_jadwal.data_semester_id', $this->semester_id);
            }
            return DataJadwal::query();
        } else if ($role == 'dosen') {
            if ($this->semester_id) {
                return DataJadwal::query()->where('user_id', $user->id)->where('data_jadwal.data_semester_id', $this->semester_id);
            }
            return DataJadwal::query()->where('user_id', $user->id);
        } else {
            $kelas = $user->mahasiswa->kelas->first();
            if ($this->semester_id) {
                return DataJadwal::query()->where('data_kelas_id', $kelas->id)->where('data_jadwal.data_semester_id', $this->semester_id);
            }
            return DataJadwal::query()->where('data_kelas_id', $kelas->id);
        }
    }

    public function columns()
    {
        $this->hide = HideableColumn::where(['table_name' => $this->table_name, 'user_id' => auth()->user()->id])->pluck('column_name')->toArray();
        return [
            Column::name('kode_jadwal')->label('Kode Jadwal')->searchable(),
            Column::name('hari_jadwal')->label('Hari')->searchable(),
            Column::name('waktu_jadwal')->label('Waktu')->searchable(),
            Column::name('matakuliah.nama_matakuliah')->label('Matakuliah')->searchable(),
            Column::name('kelas.kode_kelas')->label('Kelas')->searchable(),
            Column::name('dosen.nama_dosen')->label('Dosen')->searchable(),
            Column::name('prodi.nama_prodi')->label('Prodi')->searchable(),
            Column::name('semester.kode_semester')->label('Semester')->searchable(),

            Column::callback(['id'], function ($id) {
                return view('livewire.components.action-button', [
                    'id' => $id,
                    'segment' => $this->params
                ]);
            })->label(__('Aksi')),
        ];
    }

    public function getDataById($id)
    {
        $this->emit('getDataDataJadwalById', $id);
    }

    public function getId($id)
    {
        $this->emit('getDataJadwalId', $id);
    }

    public function refreshTable()
    {
        $this->emit('refreshLivewireDatatable');
    }
    public function setFilterJadwal($semester_id)
    {
        $this->semester_id = $semester_id;
    }

    public function toggle($index)
    {
        if ($this->sort == $index) {
            $this->initialiseSort();
        }

        $column = HideableColumn::where([
            'table_name' => $this->table_name,
            'column_name' => $this->columns[$index]['name'],
            'index' => $index,
            'user_id' => auth()->user()->id
        ])->first();

        if (!$this->columns[$index]['hidden']) {
            unset($this->activeSelectFilters[$index]);
        }

        $this->columns[$index]['hidden'] = !$this->columns[$index]['hidden'];

        if (!$column) {
            HideableColumn::updateOrCreate([
                'table_name' => $this->table_name,
                'column_name' => $this->columns[$index]['name'],
                'index' => $index,
                'user_id' => auth()->user()->id
            ]);
        } else {
            $column->delete();
        }
    }
}
