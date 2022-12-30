<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataSemester extends Model
{
    //use Uuid;
    use HasFactory;
    protected $table = 'data_semester';

    //public $incrementing = false;

    protected $fillable = ['kode_semester', 'nama_semester'];

    protected $dates = [];

    /**
     * Get all of the kelas for the DataSemester
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function kelas()
    {
        return $this->hasMany(DataKelas::class, 'data_semester_id');
    }
    /**
     * Get all of the mahasiswa for the DataSemester
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mahasiswa()
    {
        return $this->hasMany(DataMahasiswa::class, 'data_semester_id');
    }

    /**
     * Get all of the jadwal for the DataSemester
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function jadwal()
    {
        return $this->hasMany(DataJadwal::class, 'data_semester_id');
    }
}
