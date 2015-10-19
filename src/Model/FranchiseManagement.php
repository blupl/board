<?php namespace Blupl\Franchises\Model;

use Illuminate\Database\Eloquent\Model;

class FranchiseManagement extends Model {

    protected $table = 'franchise_management';

    // protected $morphClass = 'franchises';

    protected $fillable = [
        'accredit_category',
        'name_franchise',
        'name_applicant',
        'nationality',
        'passport_nid',
        'role',
        'date_of_birth',
        'country_of_birth',
        'phone',
        'passport_expire_date',
        'noc',
        'mail',
        'photo',
        'attachment'
    ];
}