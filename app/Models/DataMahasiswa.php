<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataMahasiswa extends Model
{
    //use Uuid;
    use HasFactory;
    protected $table = 'data_mahasiswa';

    //public $incrementing = false;

    protected $fillable = ['kode_mahasiswa', 'nama_mahasiswa', 'email_mahasiswa', 'telepon_mahasiswa', 'alamat_mahasiswa', 'data_prodi_id', 'user_id', 'data_semester_id'];

    protected $dates = [];

    /**
     * Get the prodi that owns the DataMatakuliah
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function prodi()
    {
        return $this->belongsTo(DataProdi::class, 'data_prodi_id');
    }

    /**
     * The kelas that belong to the DataMahasiswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function kelas()
    {
        return $this->belongsToMany(DataKelas::class, 'kelas_mahasiswa', 'mahasiswa_id', 'kelas_id');
    }

    /**
     * Get the user that owns the DataMahasiswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the semester that owns the DataMahasiswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function semester()
    {
        return $this->belongsTo(DataSemester::class, 'data_semester_id');
    }
}
