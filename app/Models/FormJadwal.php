<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormJadwal extends Model
{
    //use Uuid;
    use HasFactory;
    protected $table = 'form_jadwal';

    //public $incrementing = false;

    protected $fillable = ['alasan_perubahan', 'hari_perubahan', 'jam_perubahan', 'status', 'keterangan', 'data_kelas_id', 'data_dosen_id', 'data_jadwal_id'];

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
     * Get the dosen that owns the DataJadwal
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dosen()
    {
        return $this->belongsTo(DataDosen::class, 'data_dosen_id');
    }

    /**
     * Get the jadwal that owns the DataJadwal
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function jadwal()
    {
        return $this->belongsTo(DataJadwal::class, 'data_jadwal_id');
    }
}
