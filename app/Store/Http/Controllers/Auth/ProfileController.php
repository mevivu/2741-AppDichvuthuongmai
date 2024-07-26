<?php

namespace App\Store\Http\Controllers\Auth;

use App\Admin\Http\Controllers\BaseController;
use App\Admin\Services\File\FileService;
use App\Store\Http\Requests\Auth\ProfileRequest;
use App\Enums\Store\StoreStatus;

class ProfileController extends BaseController
{
    //
    protected $fileService;
    public function __construct(FileService $fileService)
    {
        parent::__construct();
        $this->fileService = $fileService;
    }
    public function getView(){
        return [
            'index' => 'stores.auth.profile.index'
        ];
    }
    public function index(){

        $auth = auth('store')->user()->load(['area']);

        return view($this->view['index'], [
            'auth' => $auth,
            'breadcrums' => $this->crums->add(__('profile')),
            'status' => StoreStatus::asSelectArray()
        ]);

    }

    public function update(ProfileRequest $request)
    {
        $data = $request->validated();
        $auth = auth('store')->user();

        if($request->hasFile('logo'))
        {
            $data['logo'] = $this->fileService->setFolder('stores/' . $auth->id)
            ->setFile($data['logo'])
            ->upload()
            ->getInstance();
        }

        $auth->update($data);

        return back()->with('success', __('notifySuccess'));
    }

}
