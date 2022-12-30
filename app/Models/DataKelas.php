<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataKelas extends Model
{
    //use Uuid;
    use HasFactory;
    protected $table = 'data_kelas';

    //public $incrementing = false;

    protected $fillable = ['kode_kelas', 'nama_kelas', 'data_prodi_id', 'data_semester_id'];

    protected $dates = [];

    /**
     * Get the prodi that owns the DataKelas
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function prodi()
    {
        return $this->belongsTo(DataProdi::class, 'data_prodi_id');
    }

    /**
     * The mahasiswa that belong to the DataMahasiswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function mahasiswa()
    {
        return $this->belongsToMany(DataMahasiswa::class, 'kelas_mahasiswa', 'mahasiswa_id', 'kelas_id');
    }

    /**
     * Get the semester that owns the DataKelas
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function semester()
    {
        return $this->belongsTo(DataSemester::class, 'data_semester_id');
    }
}
