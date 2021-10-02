<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Country
 * @package App
 */

class City extends Model
{
    protected $fillable  = [];
    protected array $fieldspec = [];

	public function province()
	{
		return $this->belongsTo('App/Province', 'province_code', 'code');
	}
}
