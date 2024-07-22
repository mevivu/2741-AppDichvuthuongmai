<?php

namespace App\Store\Http\Controllers\Auth;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Repositories\Area\AreaRepositoryInterface;
use App\Admin\Repositories\StoreCategory\StoreCategoryRepositoryInterface;
use App\Admin\Services\Store\StoreServiceInterface;
use App\Enums\DefaultStatus;
use App\Store\Http\Requests\Auth\RegisterRequest;
use App\Repositories\Setting\SettingRepositoryInterface;

class RegisterController extends Controller
{
    //
    protected $repoSetting;
    protected $repoStoreCategory;
    protected $repoArea;
    protected $serviceStore;

    public function __construct(
        SettingRepositoryInterface $repoSetting,
        StoreCategoryRepositoryInterface $repoStoreCategory,
        AreaRepositoryInterface $repoArea,
        StoreServiceInterface $serviceStore
    )
    {
        parent::__construct();
        $this->repoSetting = $repoSetting;
        $this->repoStoreCategory = $repoStoreCategory;
        $this->repoArea = $repoArea;
        $this->serviceStore = $serviceStore;
    }

    public function getView(){
        return [
            'index' => 'stores.auth.register'
        ];
    }

    public function getRoute(){
        return [
            'login' => 'store.login.index'
        ];
    }

    public function index(){

        $logo = $this->repoSetting->getValueByKey('site_logo') ?? config('custom.images.logo');

        $storeCategories = $this->repoStoreCategory->getByOrder(
            ['status' => DefaultStatus::Published],
            [],
            ['position', 'asc']
        );

        $areas = $this->repoArea->getByOrder(
            ['status' => DefaultStatus::Published],
            [],
            ['position', 'asc']
        );

        return view($this->view['index'], [
            'logo' => $logo,
            'store_categories' => $storeCategories,
            'areas' => $areas
        ]);
    }

    public function register(RegisterRequest $request){

        $response = $this->serviceStore->store($request);

        if($response){
            return to_route($this->route['login'])->with('success', __('registerSuccess'));
        }

        return back()->with('error', __('LoginFail'))->withInput($request->all());
    }
}
