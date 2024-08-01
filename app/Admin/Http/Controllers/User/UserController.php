<?php

namespace App\Admin\Http\Controllers\User;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\User\UserRequest;
use App\Admin\Repositories\User\UserRepositoryInterface;
use App\Admin\Services\User\UserServiceInterface;
use App\Admin\DataTables\User\UserDataTable;
use App\Traits\ResponseController;
use Exception;
use App\Enums\User\{Gender};
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    use ResponseController;

    public function __construct(
        UserRepositoryInterface $repository,
        UserServiceInterface    $service
    )
    {

        parent::__construct();

        $this->repository = $repository;

        $this->service = $service;

    }

    public function getView(): array
    {
        return [
            'index' => 'admin.users.index',
            'create' => 'admin.users.create',
            'edit' => 'admin.users.edit'
        ];
    }

    public function getRoute(): array
    {
        return [
            'index' => 'admin.user.index',
            'create' => 'admin.user.create',
            'edit' => 'admin.user.edit',
            'delete' => 'admin.user.delete'
        ];
    }

    public function index(UserDataTable $dataTable)
    {
        return $dataTable->render($this->view['index'], [
            'gender' => Gender::asSelectArray()
        ]);
    }

    public function create(): Factory|View|Application
    {
        $roles = $this->repository->getAllRolesByGuardName('web');

        return view($this->view['create'], [
            'gender' => Gender::asSelectArray(),
            'roles' => $roles,
        ]);
    }

    public function store(UserRequest $request): RedirectResponse
    {

        $response = $this->service->store($request);

        return $this->handleResponse($response, $request, $this->route['index'], $this->route['edit']);


    }

    /**
     * @throws Exception
     */
    public function edit($id): Factory|View|Application
    {

        $instance = $this->repository->findOrFail($id);
        $roles = $this->repository->getAllRolesByGuardName('web');

        return view(
            $this->view['edit'],
            [
                'user' => $instance,
                'gender' => Gender::asSelectArray(),
                'roles' => $roles,
            ],
        );

    }

    public function update(UserRequest $request): RedirectResponse
    {

        $response = $this->service->update($request);

        return $this->handleUpdateResponse($response);


    }

    public function delete($id): RedirectResponse
    {

        $this->service->delete($id);

        return to_route($this->route['index'])->with('success', __('notifySuccess'));

    }
}
