<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TipoUsers
 * @package App\Models
 * @version November 12, 2020, 6:13 am UTC
 *
 * @property string $tipo
 */
class TipoUsers extends Model
{
    use SoftDeletes;

    public $table = 'tipo_usuarios';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'tipo'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'tipo' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
