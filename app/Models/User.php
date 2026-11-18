<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    protected $primaryKey = 'id';
    public $timestamps = false; // Falls es keine created_at / updated_at gibt
    protected $table = 'ab_user';
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = ['id', 'ab_name', 'ab_password', 'ab_mail'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    /*protected $hidden = [
        'password',
        'remember_token',
    ];*/
    /**
     * Get token from User
     *
     * @return string
     */
    public static function getToken(string $string) // Such-methode
    {
        return DB::table('ab_article')
            ->where('ab_name', 'ILIKE', '%' . $string . '%') // case-insensitive Suche (ILIKE)
            ->get();
    }
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
