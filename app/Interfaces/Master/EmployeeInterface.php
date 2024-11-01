<?php

namespace App\Interfaces\Master;

use Illuminate\Http\Request;
use App\Http\Requests\Employee\StoreRequest;
use App\Http\Requests\Employee\UpdateRequest;

interface EmployeeInterface
{
    public function index(Request $request);

    public function store(StoreRequest $request);

    public function update(UpdateRequest $request, $id);

    public function destroy($id);
}
