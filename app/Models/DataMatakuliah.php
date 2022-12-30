<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataMatakuliah extends Model
{
    //use Uuid;
    use HasFactory;
    protected $table = 'data_matakuliah';

    //public $incrementing = false;

    protected $fillable = ['kode_matakuliah', 'nama_matakuliah', 'jumlah_sks', 'data_prodi_id'];

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
}
