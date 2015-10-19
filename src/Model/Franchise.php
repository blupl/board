<?php namespace Blupl\Franchises\Model;

use Illuminate\Database\Eloquent\Model;

class Franchise extends Model {

    protected $table = 'franchises';

    protected $morphClass = 'franchises';

//    protected $guarded = [
//        '_token',
//        '_method'
//    ];

    protected $fillable = [
        'accredit_category',
        'name_franchise',
        'name_applicant',
        'designation',
        'gender',
        'mail',
        'phone',
        'address',
        'passport_nid',
        'photo',
        'attachment'
    ];
}