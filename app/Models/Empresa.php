<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\Empresa as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Empresa extends Authenticatable
{
    use HasFactory, Notifiable;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $primaryKey = 'cnpj';
    protected $guard = 'empresa';
    protected $table = 'empresas';
    protected $fillable = [
        'cnpj', 'email', 'cpf_admin','saldo_empresa','razao','nomeFantasia', 'telefone', 'permissao', 'password',
    ];
   
    public function admin(){
        return $this->hasOne('App\Models\User');
    }
     /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
