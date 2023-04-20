<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherMaterialLevel extends Model
{
    use HasFactory;


    public function levelMaterials()
    {
        return $this->BelongsToMany(Material::class, 'teacher_material_levels', 'level_id', 'material_id')
        ->as('materials');
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
