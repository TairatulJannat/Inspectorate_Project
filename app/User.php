<?php

namespace App;

use App\Models\AcademicQualificationModel;
use App\Models\ChildrenDetailsModel;
use App\Models\ChildrenVisaDetailsModel;
use App\Models\EducationModel;
use App\Models\EducationServicesModel;
use App\Models\EmergencyContactAddressAtHome;
use App\Models\EmploymentModel;
use App\Models\FoodHabitModel;
use App\Models\HobbiesModel;
use App\Models\InternationalApplicantBasicInfoModel;
use App\Models\LocalContactInfoInBD;
use App\Models\MaritalStatusModel;
use App\Models\MiscellaneousModel;
use App\Models\OtherFileModel;
use App\Models\ParentsInfoModel;
use App\Models\Passport_Employment;
use App\Models\PassportChildrenModel;
use App\Models\PassportDetailsModel;
use App\Models\PassportSpouseModel;
use App\Models\PermanentAddressModel;
use App\Models\PersonalContactDetailsModel;
use App\Models\PersonalProfileModel;
use App\Models\PlaceVisitDuringVisitInBDModel;
use App\Models\PostingPlaceLastfiveYearBeforeCommingBD;
use App\Models\PresentAddressModel;
use App\Models\PreviousVisitedPlaceInBd;
use App\Models\ProfessionalCourcesModel;
use App\Models\PublicationDetailsModel;
use App\Models\Service_previous_visited_countryModel;
use App\Models\ServiceModel;
use App\Models\SiblingsModel;
use App\Models\SpousePurposeToVisitInBD;
use App\Models\SpouseVisaDetailsModel;
use App\Models\UniversityDegreeModel;
use App\Models\VisaDetailsModel;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $guard = 'user';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



    public function other_file()
    {
        return $this->hasOne(OtherFileModel::class,'user_id');
    }

    public function basic_info()
    {
        return $this->hasOne(InternationalApplicantBasicInfoModel::class,'user_id');
    }

    public function marital_detail()
    {
        return $this->hasOne(MaritalStatusModel::class,'user_id');
    }

    public function passport_detail()
    {
        return $this->hasMany(PassportDetailsModel::class,'user_id');
    }

    public function passport_detail_first()
    {
        return $this->hasOne(PassportDetailsModel::class,'user_id');
    }

    public function visa_detail()
    {
        return $this->hasMany(VisaDetailsModel::class,'user_id');
    }

    public function spouse_visa_detail()
    {
        return $this->hasMany(SpouseVisaDetailsModel::class,'user_id');
    }

    public function children_visa_detail()
    {
        return $this->hasMany(ChildrenVisaDetailsModel::class,'user_id');
    }

    public function passport_employment()
    {
        return $this->hasOne(Passport_Employment::class,'user_id');
    }

    public function local_contact_info_in_bd()
    {
        return $this->hasMany(LocalContactInfoInBD::class,'user_id');
    }

    public function place_visit_during_stay_in_bd()
    {
        return $this->hasMany(PlaceVisitDuringVisitInBDModel::class,'user_id');
    }

    public function academic_qualification()
    {
        return $this->hasMany(AcademicQualificationModel::class,'user_id');
    }

    public function previous_place_visit_in_bd()
    {
        return $this->hasMany(PreviousVisitedPlaceInBd::class,'user_id');
    }

    public function service_job()
    {
        return $this->hasOne(ServiceModel::class,'user_id');
    }

    public function posting_place_last_5_year_bef_comming_to_bd()
    {
        return $this->hasMany(PostingPlaceLastfiveYearBeforeCommingBD::class,'user_id');
    }

    public function service_job_previous_visited_country()
    {
        return $this->hasMany(Service_previous_visited_countryModel::class,'user_id');
    }

    public function EmergencyContactAddressAtHome()
    {
        return $this->hasOne(EmergencyContactAddressAtHome::class,'user_id');
    }

    public function personal_profile()
    {
        return $this->hasOne(PersonalProfileModel::class,'user_id');
    }

    public function permanent_address()
    {
        return $this->hasOne(PermanentAddressModel::class,'user_id');
    }
    public function present_address()
    {
        return $this->hasOne(PresentAddressModel::class,'user_id');
    }

    public function food_habit()
    {
        return $this->hasMany(FoodHabitModel::class,'user_id');
    }

    public function education_service()
    {
        return $this->hasMany(EducationServicesModel::class,'user_id');
    }

    public function hobbies()
    {
        return $this->hasMany(HobbiesModel::class,'user_id');
    }

    public function education()
    {
        return $this->hasOne(EducationModel::class,'user_id');
    }

    public function university_degree()
    {
        return $this->hasMany(UniversityDegreeModel::class,'user_id');
    }

    public function professional_cources()
    {
        return $this->hasMany(ProfessionalCourcesModel::class,'user_id');
    }

    public function employment()
    {
        return $this->hasMany(EmploymentModel::class,'user_id');
    }

    public function passport_spouse()
    {
        return $this->hasMany(PassportSpouseModel::class,'user_id');
    }

    public function passport_children()
    {
        return $this->hasMany(PassportChildrenModel::class,'user_id');
    }

    public function children_details()
    {
        return $this->hasMany(ChildrenDetailsModel::class,'user_id');
    }

    public function spouse_previous_visit()
    {
        return $this->hasMany(SpousePurposeToVisitInBD::class,'user_id');
    }

    public function siblings()
    {
        return $this->hasMany(SiblingsModel::class,'user_id');
    }

    public function miscellaneous()
    {
        return $this->hasMany(MiscellaneousModel::class,'user_id');
    }

    public function parents_info()
    {
        return $this->hasOne(ParentsInfoModel::class,'user_id');
    }

    public function publication_details()
    {
        return $this->hasMany(PublicationDetailsModel::class,'user_id');
    }

    public function international_personal_contact_details()
    {
        return $this->hasOne(PersonalContactDetailsModel::class,'user_id');
    }
}
