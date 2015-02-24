<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use App\Interfaces\SimpleTableInterface;

/**
 * UnosGorditos\User
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\UnosGorditos\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\UnosGorditos\User whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\UnosGorditos\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\UnosGorditos\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\UnosGorditos\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\UnosGorditos\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\UnosGorditos\User whereUpdatedAt($value)
 * @property-read mixed $estatus_display 
 */
class User extends BaseModel implements AuthenticatableContract, CanResetPasswordContract, SimpleTableInterface {

    use Authenticatable,
        CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function getPrettyFields(){
        return [
            'name'=>'Nombre',
            'email'=>'Correo',
            'password'=>'Contraseña',
        ];
    }

    public function getPrettyName(){
        return "Usuario";
    }

    public function getTableFields(){
        return ['name','email'];
    }

    public function setPasswordAttribute($password){
        $this->attributes['password'] = \Hash::make($password);
    }

    public function getRules(){
        return [
            'name'=>'required',
            'email'=>'required|email',
            'password'=>'min:6',
        ];
    }
}
