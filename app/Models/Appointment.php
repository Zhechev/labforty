<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'appointment_datetime',
        'client_name',
        'egn',
        'description',
        'notification_method',
        'email',
        'phone',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'appointment_datetime' => 'datetime',
    ];

    /**
     * Scope a query to get appointments for a specific EGN.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $egn
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByEgn($query, $egn)
    {
        return $query->where('egn', $egn);
    }

    /**
     * Scope a query to get appointments within a date range.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $from
     * @param  string  $to
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByDateRange($query, $from, $to)
    {
        if ($from && $to) {
            return $query->whereBetween('appointment_datetime', [$from, $to]);
        }

        if ($from) {
            return $query->where('appointment_datetime', '>=', $from);
        }

        if ($to) {
            return $query->where('appointment_datetime', '<=', $to);
        }

        return $query;
    }

    /**
     * Scope a query to get future appointments.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFuture($query)
    {
        return $query->where('appointment_datetime', '>=', now());
    }
}
