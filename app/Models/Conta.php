<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conta extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $primaryKey = 'num_conta';

    protected $fillable = [
        'num_conta',
        'proprietario',
        'saldo',    
        'verificada',    
    ];  
}
