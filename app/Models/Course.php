<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Support\Facades\Storage;

class Course extends Model
{
    use HasFactory, Sluggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'course_image',
        'start_date',
        'active',
    ];

    const COURSES = [
        'teormex' => 'Теоретическая механика',
        'sopromat' => 'Сопротивление матералов',
        'mex' => 'Механика',
        'stroimex' => 'Строительная механика',
    ];

    public function teachers()
    {
        return $this->hasMany(Teacher::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function getThumbUrl()
    {
        return $this->course_image
        ? Storage::disk('thumbs')->url($this->course_image)
        : '#';
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
