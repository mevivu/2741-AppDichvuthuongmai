<?php

namespace App\Admin\Http\Controllers\Notification;

use App\Admin\DataTables\Notification\NotificationDataTable;
use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\Notification\NotificationRequest;
use App\Admin\Repositories\Notification\NotificationRepositoryInterface;
use App\Admin\Services\Notification\NotificationServiceInterface;
use App\Enums\Notification\NotificationStatus;
// use App\Admin\DataTables\Page\PageDataTable;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function __construct(
        NotificationRepositoryInterface $repository,
        NotificationServiceInterface    $service
    )
    {

        parent::__construct();

        $this->repository = $repository;
        $this->service = $service;
    }

    public function getView(): array
    {

        return [
            'index' => 'admin.notifications.index',
            'create' => 'admin.notifications.create',
            'edit' => 'admin.notifications.edit'
        ];
    }

    public function getRoute(): array
    {

        return [
            'index' => 'admin.notification.index',
            'create' => 'admin.notification.create',
            'edit' => 'admin.notification.edit',
            'delete' => 'admin.page.delete'
        ];
    }

    public function index(NotificationDataTable $dataTable)
    {
        $actionMultiple = [

            'draftStatus' => NotificationStatus::NOT_READ->description(),
        ];
        return $dataTable->render($this->view['index'], [
            'breadcrums' => $this->crums->add(__('page'))
        ]);
    }


    public function updateDeviceToken(Request $request)
    {
        return $this->service->updateDeviceToken($request);
    }

    public function updateStatus(NotificationRequest $request)

    {
        return $this->service->updateStatus($request);
    }

    public function getNotifications(NotificationRequest $request): JsonResponse
    {
        $notifications = $this->service->getNotifications($request);

        if ($notifications) {
            return response()->json([
                'notifications' => $notifications
            ]);
        }
        return response()->json([
            'notifications' => []
        ]);
    }

    public function create(): View|Application
    {

        return view($this->view['create'], [
            'status' => NotificationStatus::asSelectArray(),
            'breadcrums' => $this->crums->add(__('notifications'), route($this->route['index']))->add(__('add'))
        ]);
    }

    public function store(NotificationRequest $request): RedirectResponse
    {

        $instance = $this->service->store($request);

        if ($instance == 1) {
            return to_route($this->route['index'])->with('success', __('Thêm thành công'))->withInput();
        }
        return back()->with('error', __('notifyFail'))->withInput();
    }

    public function edit($id): View|Application
    {

        $response = $this->repository->findOrFail($id);

        return view(
            $this->view['edit'],
            [
                'status' => NotificationStatus::asSelectArray(),
                'notification' => $response,
                'breadcrums' => $this->crums->add(__('notification'), route($this->route['index']))->add(__('edit'))
            ],
        );
    }

    public function update(NotificationRequest $request): RedirectResponse
    {

        $response = $this->service->update($request);

        if ($response) {
            return $request->input('submitter') == 'save'
                ? back()->with('success', __('notifySuccess'))
                : to_route($this->route['index'])->with('success', __('notifySuccess'));
        }

        return back()->with('error', __('notifyFail'));
    }

    public function delete($id): RedirectResponse
    {
        $this->service->delete($id);

        return to_route($this->route['index'])->with('success', __('notifySuccess'));
    }
}
