<?php

namespace App\Models;

use App\Traits\MultiTenantModelTrait;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BenefitCompany extends Model
{
    use MultiTenantModelTrait, HasFactory;

    public $table = 'benefit_companies';

    protected $dates = [
        'register_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'email',
        'web_site',
        'contact',
        'contact_email',
        'phone',
        'register_date',
        'tax_number',
        'tax_office',
        'created_at',
        'address',
        'city',
        'country',
        'updated_at',
        'deleted_at',
        'team_id',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function benefitCompanyBenefits()
    {
        return $this->hasMany(Benefit::class, 'benefit_company_id', 'id');
    }

    public function getRegisterDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setRegisterDateAttribute($value)
    {
        $this->attributes['register_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }
}
