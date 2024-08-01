<?php

namespace App\Admin\Services\Post;

use App\Admin\Services\Post\PostServiceInterface;
use  App\Admin\Repositories\Post\PostRepositoryInterface;
use App\Enums\Post\PostType;
use App\Enums\PriorityStatus;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class PostService implements PostServiceInterface
{
    /**
     * Current Object instance
     *
     * @var array
     */
    protected array $data;

    protected PostRepositoryInterface $repository;

    public function __construct(PostRepositoryInterface $repository){
        $this->repository = $repository;
    }

    public function store(Request $request){

        $data = $request->validated();
        $data['post_type'] = PostType::Default;
        $data['posted_at'] = now();
        $data['priority'] = PriorityStatus::NotPriority;
        $categoriesId = $data['categories_id'] ?? null;
        unset($data['categories_id']);
        DB::beginTransaction();
        try {
            $post = $this->repository->create($data);
            if ($categoriesId) {
                $this->repository->attachCategories($post, $categoriesId);
            }
            DB::commit();
            return $post;
        } catch (Throwable $th) {
            DB::rollBack();
            return false;
        }
    }

    public function update(Request $request): object|bool
    {

        $this->data = $request->validated();
        if(isset($this->data['categories_id'])){
            $categoriesId = $this->data['categories_id'];
        }
        DB::beginTransaction();
        try {
            $post = $this->repository->update($this->data['id'], $this->data);

            $this->repository->syncCategories($post, $categoriesId ?? []);
            DB::commit();
            return $post;
        } catch (Throwable $th) {
            DB::rollBack();
            return false;
        }

    }

    /**
     * @throws Exception
     */
    public function delete($id): object|bool
    {
        return $this->repository->delete($id);

    }

}
