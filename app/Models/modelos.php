<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class modelos
 * @package App\Models
 * @version November 11, 2020, 9:28 pm UTC
 *
 */
class modelos extends Model
{

    public $table = 'Model';
    



    public $fillable = [
        
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
