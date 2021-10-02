<?php

namespace App;


use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\maguttiCms\Notifications\UserResetPasswordNotification as UserResetPasswordNotification;

use App\maguttiCms\Permission\GFEntrustUserTrait;
use App\maguttiCms\Domain\User\UserPresenter;

/**
 * @method static firstWhere(string $string, $getEmail)
 */
class User extends Authenticatable
{
    use Notifiable;

    use UserPresenter;

    // user role trait
    use GFEntrustUserTrait;
    protected string $role_user_table = "role_user";
    protected string $user_foreign_key = "user_id";


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'company',
        'email',
        'password',
        'gender',
		'list_code',
        'is_active',
        'is_guest',
        'dob',
        'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected array $fieldspec = [];

    /*
    |--------------------------------------------------------------------------
    |  RELATION
    |--------------------------------------------------------------------------
    */
    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    public function carts(): HasMany
    {
        return $this->hasMany('App\Cart');
    }

    public function addresses()
    {
        return $this->hasMany('App\Address');
    }

    public function identities() {
        return $this->hasMany('App\SocialAccount');
    }

    /**
     * @param $roles
     */
    public function saveRoles($roles)
    {
        if (!empty($roles)) {
            $this->roles()->sync($roles);
        }
         $this->roles()->detach();
    }

    /**
     * @param $password
     */
    public function setPasswordAttribute($password)
    {
        if ($password != '') {
            $this->attributes['password'] = bcrypt($password);
        }
    }


    /*
    |--------------------------------------------------------------------------
    |  Fieldspec for admin form
    |--------------------------------------------------------------------------
    */
    function getFieldSpec():array
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
        $this->fieldspec['firstname'] = [
            'type'     => 'string',
            'required' => 1,
            'hidden'   => 0,
            'label'    => __('website.name'),
            'display'  => 1,
        ];

        $this->fieldspec['lastname'] = [
            'type'     => 'string',
            'required' => 1,
            'hidden'   => 0,
            'label'    => __('website.lastname'),
            'display'  => 1,
        ];
        $this->fieldspec['company'] = [
            'type'     => 'string',
            'required' => 0,
            'hidden'   => 0,
            'label'    => __('website.company'),
            'display'  => 1,
        ];
        $this->fieldspec['email'] = [
            'type'     => 'string',
            'required' => 1,
            'hidden'   => 0,
            'label'    => 'Email',
            'display'  => 1,
        ];
        $this->fieldspec['role'] = [
            'type'          => 'relation',
            'model'         => 'Role',
            'relation_name' => 'roles',
            'foreign_key'   => 'id',
            'label_key'     => 'display_name',
            'required'      => 1,
            'label'         => 'Role',
            'hidden'        => 0,
            'display'       => 1,
            'multiple'      => 1,
        ];
        $this->fieldspec['gender'] = [
            'type'        => 'select',
            'required'    => 1,
            'hidden'      => 0,
            'label'       => 'Gender',
            'display'     => 1,
            'select_data' => [
                'M' => 'Male',
                'F' => 'Female',
                'N' => 'None'
            ]
        ];
		$this->fieldspec['list_code'] = [
            'type'     => 'string',
            'required' => 0,
            'hidden'   => 0,
            'label'    => 'Price List Code',
            'display'  => 1,
        ];
        $this->fieldspec['password'] = [
            'type'     => 'password',
            'is_full_component'=> 1,
            'required' => 1,
            'hidden'   => 0,
            'label'    => 'Password',
            'display'  => 1,
            'template' => 'password',
            'validation' => 'nullable|min:10|confirmed|regex:'.config('maguttiCms.security.password_regex'),
        ];
        $this->fieldspec['is_active'] = [
            'type'     => 'boolean',
            'required' => 0,
            'hidden'   => 0,
            'label'    => trans('admin.label.publish'),
            'display'  => 1
        ];
        return $this->fieldspec;
    }

    /**
     * create a new  user
     *
     * @param array $data
     *
     * @return mixed
     */
    static public function register(array $data)
    {
        $user = static::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => $data['password'],
        ]);

        event(new UserRegistered($user));

        return $user;
    }

    /*
    |--------------------------------------------------------------------------
    | NOTIFIABLE OVERRIDE THE SEND PASSWORD RESET NOTIFICATION
    |--------------------------------------------------------------------------
    |
    */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new UserResetPasswordNotification($token));
    }

    /**
     * This method is used to check whether the user is active or not.
     *
     * @return bool
     */
    public function isActive():bool
    {
        return $this->is_active == 1;
    }



}
