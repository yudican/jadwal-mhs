<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataDosen extends Model
{
    //use Uuid;
    use HasFactory;
    protected $table = 'data_dosen';


    //public $incrementing = false;

    protected $fillable = ['kode_dosen', 'nama_dosen', 'email_dosen', 'telepon_dosen', 'alamat_dosen', 'jabatan_dosen', 'user_id'];

    protected $dates = [];

    /**
     * Get the user that owns the DataMahasiswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
