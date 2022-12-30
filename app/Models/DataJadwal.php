<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataJadwal extends Model
{
    //use Uuid;
    use HasFactory;
    protected $table = 'data_jadwal';

    //public $incrementing = false;

    protected $fillable = ['kode_jadwal', 'waktu_jadwal', 'hari_jadwal', 'data_matakuliah_id', 'data_kelas_id', 'data_dosen_id', 'data_prodi_id', 'data_semester_id'];

    protected $dates = [];

    /**
     * Get the kelas that owns the DataJadwal
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kelas()
    {
        return $this->belongsTo(DataKelas::class, 'data_kelas_id');
    }

    /**
     * Get the prodi that owns the DataJadwal
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function prodi()
    {
        return $this->belongsTo(DataProdi::class, 'data_prodi_id');
    }

    /**
     * Get the matakuliah that owns the DataJadwal
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function matakuliah()
    {
        return $this->belongsTo(DataMatakuliah::class, 'data_matakuliah_id');
    }

    /**
     * Get the dosen that owns the DataJadwal
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dosen()
    {
        return $this->belongsTo(DataDosen::class, 'data_dosen_id');
    }

    /**
     * Get the semester that owns the DataJadwal
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function semester()
    {
        return $this->belongsTo(DataSemester::class, 'data_semester_id');
    }
}
