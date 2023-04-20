<?php

namespace App\Models;

use App\Support\HasAdvancedFilter;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teacher extends Model
{
    use HasAdvancedFilter;
    use SoftDeletes;
    use HasFactory;

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $orderable = [
        'id',
        'name',
        'phone',
        'address',
        'details',
        'user.name',
    ];

    protected $filterable = [
        'id',
        'name',
        'phone',
        'address',
        'details',
        'user.name',
    ];

    protected $fillable = [
        'name',
        'phone',
        'address',
        'details',
        'user_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where($field ?? 'id', $value)->withTrashed()->firstOrFail();
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
    }



    public function materials()
    {
        return $this->BelongsToMany(Material::class, 'teacher_material_levels', 'teacher_id', 'material_id')->distinct();
    }

    public function levels()
    {
        return $this->BelongsToMany(Teacher::class, 'teacher_material_levels', 'teacher_id', 'level_id')->distinct();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
