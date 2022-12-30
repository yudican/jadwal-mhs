<?php

namespace App\Http\Livewire\Table;

use App\Models\HideableColumn;
use App\Models\DataMahasiswa;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use App\Http\Livewire\Table\LivewireDatatable;

class DataMahasiswaTable extends LivewireDatatable
{
    protected $listeners = ['refreshTable'];
    public $hideable = 'select';
    public $table_name = 'tbl_data_mahasiswa';
    public $hide = [];


    public function builder()
    {
        return DataMahasiswa::query();
    }

    public function columns()
    {
        $this->hide = HideableColumn::where(['table_name' => $this->table_name, 'user_id' => auth()->user()->id])->pluck('column_name')->toArray();
        return [
            Column::name('kode_mahasiswa')->label('NIM')->searchable(),
            Column::name('nama_mahasiswa')->label('Nama Mahasiswa')->searchable(),
            // Column::name('email_mahasiswa')->label('Email Mahasiswa')->searchable(),
            Column::name('telepon_mahasiswa')->label('Telepon Mahasiswa')->searchable(),
            Column::name('alamat_mahasiswa')->label('Alamat Mahasiswa')->searchable(),
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
        $this->emit('getDataDataMahasiswaById', $id);
    }

    public function getId($id)
    {
        $this->emit('getDataMahasiswaId', $id);
    }

    public function refreshTable()
    {
        $this->emit('refreshLivewireDatatable');
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
