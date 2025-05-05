<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Notification;

class Internship extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_magang', 'nama', 'no_telepon', 'email', 'instansi', 'jenis_kelamin',
        'tanggal_mulai', 'tanggal_berakhir', 'departemen_id','area_kerja', 'pas_foto',
        'surat_rekomendasi', 'status'
    ];

    public function departemen()
    {
        return $this->belongsTo(Departemen::class, 'departemen_id', 'id_departemen');
    }

    public function attendances()
{
    return $this->hasMany(Security::class);
}

protected static function booted()
{
    static::created(function ($internship) {
        Notification::create([
            'title' => 'Pendaftaran Baru',
            'message' => 'Anak magang bernama ' . $internship->nama . ' telah mendaftar.',
            'is_read' => false
        ]);
    });
}
}
