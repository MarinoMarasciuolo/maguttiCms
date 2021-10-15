<?php namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

use App\maguttiCms\Domain\Store\Discounts\DiscountBuilder;
use App\maguttiCms\Domain\Store\Discounts\DiscountPresenter;


/**
 * Class Discount
 * @package App
 */
class Discount extends Model
{
    const AMOUNT  = "amount";
    const PERCENT = "percent";
    use DiscountPresenter;

	protected $fillable = [
		'code',
		'amount',
		'description',
		'date_start',
		'date_end',
		'uses',
        'type',
		'is_active',
        'is_for_newsletter'
	];
	protected array $fieldspec = [];


	/*
	|--------------------------------------------------------------------------
	|  RELATION
	|--------------------------------------------------------------------------
	*/

	public function orders()
	{
		return $this->hasMany('App\Order', 'discount_code', 'code');
	}

    public function discount_type()
    {
        return $this->belongsTo('App\Domain', 'type', 'value');
    }

    /*
    |--------------------------------------------------------------------------
    |  Builder & Repo
    |--------------------------------------------------------------------------
    */
    function newEloquentBuilder($query): DiscountBuilder
    {
        return new DiscountBuilder($query);
    }


    /*
    |--------------------------------------------------------------------------
    |  Fieldspec for admin form
    |--------------------------------------------------------------------------
    */
	function getFieldSpec(): array
    {
		$this->fieldspec['id'] = [
			'type'     => 'integer',
			'minvalue' => 0,
			'pkey'     => 1,
			'required' => 1,
			'label'    => 'id',
			'hidden'   => 1,
			'display'  => 0,
		];
		$this->fieldspec['code'] = [
			'type'     => 'string',
			'required' => 1,
			'hidden'   => 0,
			'label'    => trans('admin.label.code'),
			'display'  => 1,
		];
        $this->fieldspec['type'] = [
            'type'        => 'relation',
            'model'       => 'Domain',
            'foreign_key' => 'value',
            'label_key'   => 'title',
            'filter'      =>  ['domain' => 'discount'],
            'required'    => 0,
            'label'       => trans('admin.label.discount_type'),
            'hidden'      => 0,
            'display'     => 1,
        ];
		$this->fieldspec['amount'] = [
            'type'     => 'integer',
            'required' => 1,
            'hidden'   => 0,
            'label'    => trans('admin.label.value'),
            'display'  => 1,
			'step'     => 0.01
        ];
		$this->fieldspec['description'] = [
			'type'     => 'string',
			'required' => 0,
			'hidden'   => 0,
			'label'    => trans('admin.label.description'),
			'display'  => 1,
		];
		$this->fieldspec['date_start'] = [
			'type'            => 'string',
			'required'        => 0,
			'hidden'          => 0,
			'label'           => trans('admin.label.date_start'),
			'display'         => 1,
			'cssClass'        => 'datepicker',
		];
		$this->fieldspec['date_end'] = [
			'type'            => 'string',
			'required'        => 0,
			'hidden'          => 0,
			'label'           => trans('admin.label.date_end'),
			'display'         => 1,
			'cssClass'        => 'datepicker',
		];
		$this->fieldspec['uses'] = [
			'type'     => 'integer',
			'required' => 0,
			'label'    => trans('admin.label.max_number_of_use'),
			'hidden'   => 0,
			'display'  => 1,
		];
		$this->fieldspec['is_active'] = [
			'type'     => 'boolean',
			'required' => 0,
			'hidden'   => 0,
			'label'    => trans('admin.label.pub'),
			'display'  => 1
		];

		return $this->fieldspec;
	}

	public function available()
	{
		if ($this->uses) {
			$used = $this->orders()->count();
			return ($this->uses - $used) > 0;
		} else {
			return true;
		}
	}

	public function inPeriod($value='')
	{
		$now = Carbon::now();
		if ($this->date_start) {
			$start = Carbon::parse($this->date_start);
			if ($now->lt($start)) {
				return false;
			}
		}
		if ($this->date_end) {
			$end = Carbon::parse($this->date_end)->addDay();
			if ($now->gt($end)) {
				return false;
			}
		}
		return true;
	}

	public function getAvailableDisplayAttribute()
	{
		if ($this->uses) {
			$used = $this->orders()->count();
			return $this->uses - $used;
		} else {
			return icon('infinity');
		}
	}

    public function checkDiscount()
    {
        if (!$this->available()) {
            return false;
        }
        if (!$this->inPeriod()) {
            return false;
        }

        return true;
    }
}
