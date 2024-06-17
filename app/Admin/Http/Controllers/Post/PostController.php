<?php

namespace App\Admin\Http\Controllers\Post;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\Post\PostRequest;
use App\Admin\Repositories\Post\PostRepositoryInterface;
use App\Admin\Repositories\PostCategory\PostCategoryRepositoryInterface;
use App\Admin\Services\Post\PostServiceInterface;
use App\Admin\DataTables\Post\PostDataTable;
use App\Enums\Post\PostStatus;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class PostController extends Controller
{
    protected $repositoryPostCategory;
    public function __construct(
        PostRepositoryInterface $repository,
        PostCategoryRepositoryInterface $repositoryPostCategory,
        PostServiceInterface $service
    ){

        parent::__construct();

        $this->repository = $repository;
        $this->repositoryPostCategory = $repositoryPostCategory;

        $this->service = $service;

    }

    public function getView(): array
    {
        return [
            'index' => 'admin.posts.index',
            'create' => 'admin.posts.create',
            'edit' => 'admin.posts.edit'
        ];
    }

    public function getRoute(): array
    {
        return [
            'index' => 'admin.post.index',
            'create' => 'admin.post.create',
            'edit' => 'admin.post.edit',
            'delete' => 'admin.post.delete'
        ];
    }
    public function index(PostDataTable $dataTable){
        return $dataTable->render($this->view['index'], [
            'status' => PostStatus::asSelectArray(),
            'is_featured' => [
                0 => __('Không'),
                1 => __('Có')
            ]
        ]);
    }

    public function create(): Factory|View|Application
    {
        $categories = $this->repositoryPostCategory->getFlatTree();
        return view($this->view['create'], [
            'categories' => $categories,
            'status' => PostStatus::asSelectArray()
        ]);
    }

    public function store(PostRequest $request): RedirectResponse
    {

        $response = $this->service->store($request);

        if($response){
            return $request->input('submitter') == 'save'
                ? to_route($this->route['edit'], $response->id)->with('success', __('notifySuccess'))
                : to_route($this->route['index'])->with('success', __('notifySuccess'));
        }

        return back()->with('error', __('notifyFail'))->withInput();

    }

    public function edit($id): Factory|View|Application
    {
        $categories = $this->repositoryPostCategory->getFlatTree();

        $post = $this->repository->findOrFailWithRelations($id);
        return view(
            $this->view['edit'],
            [
                'categories' => $categories,
                'post' => $post,
                'status' => PostStatus::asSelectArray()
            ],
        );

    }

    public function update(PostRequest $request): RedirectResponse
    {

        $respone = $this->service->update($request);
        if($respone){
            return back()->with('success', __('notifySuccess'));
        }
        return back()->with('error', __('notifyFail'));
    }

    public function delete($id): RedirectResponse
    {

        $this->service->delete($id);

        return to_route($this->route['index'])->with('success', __('notifySuccess'));

    }

}
