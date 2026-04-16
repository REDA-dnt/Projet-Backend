<?php
namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory;
    protected $fillable = ['name', 'email', 'password', 'role'];
    protected $hidden   = ['password'];

    public function getJWTIdentifier()       { return $this->getKey(); }
    public function getJWTCustomClaims()     { return ['role' => $this->role]; }

    public function profil()  { return $this->hasOne(Profil::class); }
    public function offres()  { return $this->hasMany(Offre::class); }
}
