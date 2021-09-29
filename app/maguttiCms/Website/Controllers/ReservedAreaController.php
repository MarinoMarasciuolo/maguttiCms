<?php

namespace App\maguttiCms\Website\Controllers;


use App\maguttiCms\Domain\Store\Facades\StoreFeatures;
use Auth;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use Input;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

use App\Address;
use App\Country;

use App\maguttiCms\SeoTools\MaguttiCmsSeoTrait;
use App\maguttiCms\Domain\Store\Facades\StoreHelper;
use App\maguttiCms\Website\Requests\WebsiteFormRequest;
use App\maguttiCms\Website\Requests\UpdateUserProfileRequest;
use App\maguttiCms\Website\Repos\Article\ArticleRepositoryInterface;

class ReservedAreaController extends Controller
{
	use MaguttiCmsSeoTrait;
    /**
     * @string
     */
    protected  string $template;
    /**
     * @var ArticleRepositoryInterface
     */
    protected ArticleRepositoryInterface $articleRepo;


    /**
     * @param ArticleRepositoryInterface $article
     *
     */

    public function __construct(ArticleRepositoryInterface $article )
    {
        $this->articleRepo = $article;
    }

    /**
     * @return Factory|\Illuminate\View\View
     */
    public function dashboard() : View
    {
        $article =$this->articleRepo->getBySlug('dashboard');
        $this->setSeo($article);
		$user = Auth::user();
		$addresses = $user->addresses;
        if(StoreFeatures::isStoreEnabled()){
            return view('magutti_store::order.index', compact('article','addresses'));
        }
        return view('website.users.dashboard', compact('article',  'addresses'));
    }


    public function profile() :View
    {

        $article =$this->articleRepo->getBySlug('profile');
        $this->setSeo($article);
        return view('website.users.profile', compact('article'));
    }

    public function update_profile(UpdateUserProfileRequest $request) :View
    {
        $validated = $request->validated();
        auth_user()->update($validated);
        $article =$this->articleRepo->getBySlug('profile');
        $this->setSeo($article);
        session()->flash('success', trans('users.profile.update_profile_success'));
        return view('website.users.profile', compact('article'));
    }



	public function addressNew()
	{
		$previous = url()->previous();
		$countries = Country::list()->get();
		return view('website.users.address_new', compact('countries', 'previous'));
	}

	public function addressCreate(WebsiteFormRequest $request)
	{
		$user = Auth::user();

		$address = Address::create([
			'user_id'	 => $user->id,
			'street'	 => $request->street,
			'number'	 => $request->number,
			'zip_code'	 => $request->zip_code,
			'city'	     => $request->city,
			'province'	 => $request->province,
			'country_id' => $request->country_id,
			'phone'	     => $request->phone,
			'mobile'	 => $request->mobile,
			'email'	     => $request->email,
			'vat'		 => $request->vat
		]);

		if ($request->previous)
			return Redirect::to($request->previous);
		else
			return Redirect::to('/users/dashboard');
	}
}
