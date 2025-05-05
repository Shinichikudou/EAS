<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departemen extends Model
{
    use HasFactory;

    protected $table = 'departemens';
    protected $primaryKey = 'id_departemen';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = ['nama_departemen'];
}
