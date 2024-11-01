<?php

namespace App\Repositories\Master;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Role\StoreRequest;
use App\Interfaces\Master\RoleInterface;
use App\Http\Requests\Role\UpdateRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\Master\RoleResource;

class RoleRepository implements RoleInterface
{
    use ResponseTrait;

    public function index(Request $request)
    {
        try {
            $collection = Role::with(['createdBy' => ['employee']])->latest();
            $keyword = str($request->query("search"));
            $isNotPaginate = $request->query("not-paginate");

            if ($keyword) {
                $collection->where('role', 'LIKE', "%$keyword%");
            }

            if ($isNotPaginate) {
                $collection = $collection->get();
            } else {
                $collection = $collection
                    ->paginate($request->recordsPerPage)
                    ->appends(request()->query());
            }

            $result = RoleResource::collection($collection)
                ->response()
                ->getData(true);

            return $this->wrapResponse(Response::HTTP_OK, 'Data berhasil dimuat', $result);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function store(StoreRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $validatedData['created_by'] = auth()->user()->id;
            if ($resource = Role::create($validatedData)) {
                $resource = (new RoleResource($resource))
                    ->response()
                    ->getData(true);

                return $this->wrapResponse(Response::HTTP_CREATED, 'Data berhasil ditambah', $resource);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update(UpdateRequest $request, $id)
    {
        try {
            $resource = Role::findOrFail($id);
            $validatedData = $request->validated();
            $validatedData['updated_by'] = auth()->user()->id;

            if ($resource->update($validatedData)) {
                $resource = (new RoleResource($resource))
                    ->response()
                    ->getData(true);

                return $this->wrapResponse(Response::HTTP_OK, 'Data berhasil diperbarui', $resource);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy($id)
    {
        try {
            $resource = Role::findOrFail($id);

            if ($resource) {
                $resource->delete();

                return $this->wrapResponse(Response::HTTP_OK, 'Data berhasil dihapus');
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
