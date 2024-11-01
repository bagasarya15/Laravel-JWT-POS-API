<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\StoreRequest;
use App\Interfaces\Master\EmployeeInterface;
use App\Http\Requests\Employee\UpdateRequest;

class EmployeeController extends Controller
{
    protected $interface;

    public function __construct(EmployeeInterface $interface)
    {
        $this->interface = $interface;
    }

    public function index(Request $request)
    {
        return $this->interface->index($request);
    }

    public function store(StoreRequest $request)
    {
        return $this->interface->store($request);
    }

    public function update(UpdateRequest $request, $id)
    {
        return $this->interface->update($request, $id);
    }

    public function destroy($id)
    {
        return $this->interface->destroy($id);
    }
}
