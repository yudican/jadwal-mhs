<?php

namespace App\Http\Livewire\Table;

use App\Models\HideableColumn;
use App\Models\FormJadwal;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use App\Http\Livewire\Table\LivewireDatatable;

class PerubahanJadwalTable extends LivewireDatatable
{
  protected $listeners = ['refreshTable'];
  public $table_name = 'tbl_form_jadwal';


  public function builder()
  {
    $user = auth()->user();
    if ($user->role->role_type == 'mahasiswa') {
      return FormJadwal::query()->where('form_jadwal.data_kelas_id', $user->mahasiswa->kelas()->first()->id)->where('status', 1);
    }

    if ($user->role->role_type == 'dosen') {
      return FormJadwal::query()->where('form_jadwal.data_dosen_id', $user->dosen->id)->where('status', 1);
    }

    return FormJadwal::query();
  }

  public function columns()
  {
    $this->hide = HideableColumn::where(['table_name' => $this->table_name, 'user_id' => auth()->user()->id])->pluck('column_name')->toArray();
    return [
      Column::name('jadwal.kode_jadwal')->label('Kode Jadwal'),
      Column::name('hari_perubahan')->label('Hari'),
      Column::name('jam_perubahan')->label('Waktu'),
      Column::name('jadwal.matakuliah.nama_matakuliah')->label('Mata Kuliah'),
      Column::name('kelas.kode_kelas')->label('Kelas'),
      Column::name('dosen.nama_dosen')->label('Dosen'),
      Column::name('jadwal.prodi.nama_prodi')->label('Prodi'),
      Column::name('alasan_perubahan')->label('Alasan Perubahan'),
    ];
  }

  public function getDataById($id)
  {
    $this->emit('getDataFormJadwalById', $id);
  }

  public function getId($id)
  {
    $this->emit('getFormJadwalId', $id);
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
