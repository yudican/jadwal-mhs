<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataProdi extends Model
{
    //use Uuid;
    use HasFactory;
    protected $table = 'data_prodi';

    //public $incrementing = false;

    protected $fillable = ['kode_prodi', 'nama_prodi'];

    protected $dates = [];

    /**
     * Get all of the kelas for the DataProdi
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function kelas()
    {
        return $this->hasMany(DataKelas::class, 'data_prodi_id');
    }

    /**
     * Get all of the matakuliah for the DataProdi
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function matakuliah()
    {
        return $this->hasMany(DataMatakuliah::class, 'data_prodi_id');
    }

    /**
     * Get all of the mahasiswa for the DataProdi
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mahasiswa()
    {
        return $this->hasMany(DataMahasiswa::class, 'data_prodi_id');
    }

    /**
     * Get all of the jadwal for the DataProdi
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function jadwal()
    {
        return $this->hasMany(DataJadwal::class, 'data_prodi_id');
    }
}
