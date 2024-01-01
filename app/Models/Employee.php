<?php

namespace App\Models;

use App\Traits\MultiTenantModelTrait;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Employee extends Model implements HasMedia
{
    use MultiTenantModelTrait, InteractsWithMedia, HasFactory;

    public $table = 'employees';

    protected $appends = [
        'picture',
    ];

    public const STATUS_RADIO = [
        'Active'  => 'Active',
        'Passive' => 'Passive',
    ];

    protected $dates = [
        'birthday',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public static $searchable = [
        'name',
        'sur_name',
        'personel',
        'identity_number',
    ];

    public const GENDER_SELECT = [
        'Male'   => 'Male',
        'Female' => 'Female',
        'Other'  => 'Other',
    ];

    public const WORKING_TYPE_SELECT = [
        'FullTime'   => 'Full Time',
        'Intern'     => 'Intern',
        'PartTime'   => 'Part Time',
        'Freelancer' => 'Freelancer',
        'Contractor' => 'Contractor',
    ];

    protected $fillable = [
        'team_id',
        'name',
        'sur_name',
        'personel',
        'identity_number',
        'working_type',
        'job_title',
        'department',
        'yearly_credit',
        'mobile_phone',
        'phone',
        'email',
        'birthday',
        'gender',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    public function getPictureAttribute()
    {
        $file = $this->getMedia('picture')->last();
        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }

        return $file;
    }

    public function getBirthdayAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setBirthdayAttribute($value)
    {
        $this->attributes['birthday'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function benfitvariants()
    {
        return $this->belongsToMany(BenefitVariant::class);
    }

    public function benefit_packages()
    {
        return $this->belongsToMany(BenefitPackage::class);
    }
}
