<?php

namespace App\Models;

use App\constants\Roles;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $phone
 * @property string|null $birth_date
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Appointment> $appointments
 * @property-read int|null $appointments_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereBirthDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereUserId($value)
 * @mixin \Eloquent
 */
class Patient extends Model
{
    protected $fillable = [
        'name',
        'user_id',
        'phone',
        'birth_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function scopeForCurrentUser($query)
    {
        if (auth()->check() && auth()->user()->role_id === Roles::PATIENT) {
            return $query->where('user_id', auth()->id());
        }

        return $query;
    }

    public function scopeFilterByName($query, $name)
    {
        return $name ? $query->where('name', 'like', "%$name%") : $query;
    }

    public function scopeFilterByPhone($query, $phone)
    {
        return $phone ? $query->where('phone', 'like', "%$phone%") : $query;
    }

}
