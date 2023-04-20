<?php

namespace App\Models;

use App\Support\HasAdvancedFilter;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Level extends Model
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
        'details'
    ];

    protected $filterable = [
        'id',
        'name',
        'details'
    ];

    protected $fillable = [
        'name',
        'details',
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

    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

    public function materials()
    {
        return $this->BelongsToMany(Material::class, 'teacher_material_levels', 'level_id', 'material_id')->distinct();
    }

    public function teachers()
    {
        return $this->BelongsToMany(Teacher::class, 'teacher_material_levels', 'level_id', 'teacher_id')->distinct();
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
