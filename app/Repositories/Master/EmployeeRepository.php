<?php

namespace App\Repositories\Master;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Employee\StoreRequest;
use App\Interfaces\Master\EmployeeInterface;
use App\Http\Requests\Employee\UpdateRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\Master\EmployeeResource;

class EmployeeRepository implements EmployeeInterface
{
    use ResponseTrait;

    public function index(Request $request)
    {
        try {
            $collection = Employee::latest();
            $keyword = str($request->query("search"));
            $isNotPaginate = $request->query("not-paginate");

            if ($keyword) {
                $collection->where(DB::raw("CONCAT(firstname, ' ', lastname)"), 'LIKE', "%$keyword%");
            }

            if ($isNotPaginate) {
                $collection = $collection->get();
            } else {
                $collection = $collection
                    ->paginate($request->recordsPerPage)
                    ->appends(request()->query());
            }

            $result = EmployeeResource::collection($collection)
                ->response()
                ->getData(true);

            return $this->wrapResponse(Response::HTTP_OK, 'Data berhasil dimuat', $result);
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function store(StoreRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $validatedData['created_by'] = auth()->user()->id;
            if ($resource = Employee::create($validatedData)) {
                $resource = (new EmployeeResource($resource))
                    ->response()
                    ->getData(true);

                return $this->wrapResponse(Response::HTTP_CREATED, 'Data berhasil ditambah', $resource);
            }
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function update(UpdateRequest $request, $id)
    {
        try {
            $resource = Employee::findOrFail($id);
            $validatedData = $request->validated();
            $validatedData['updated_by'] = auth()->user()->id;

            if ($resource->update($validatedData)) {
                $resource = (new EmployeeResource($resource))
                    ->response()
                    ->getData(true);

                return $this->wrapResponse(Response::HTTP_OK, 'Data berhasil diperbarui', $resource);
            }
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function destroy($id)
    {
        try {
            $resource = Employee::findOrFail($id);

            if ($resource) {
                $resource->delete();

                return $this->wrapResponse(Response::HTTP_OK, 'Data berhasil dihapus');
            }
        } catch (\Throwable $th) {
            return $th;
        }
    }
}
