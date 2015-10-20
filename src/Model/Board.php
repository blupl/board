<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Board extends Model {

    protected $table = 'boards';

    protected $morphClass = 'boards';

    protected $fillable = [
        'category_name',
        'designation',
        'organization'
    ];

}
