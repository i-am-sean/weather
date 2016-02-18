<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Temperature extends Model
{
    /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'temperature';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'temperature', 'created_at', 'updated_at',
    ];
}
