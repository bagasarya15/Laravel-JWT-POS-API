<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreRequest;
use App\Interfaces\Master\UserInterface;
use App\Http\Requests\User\UpdateRequest;

class UserController extends Controller
{
    protected $interface;

    public function __construct(UserInterface $interface)
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

    public function selectUserForRegistration() {
        return $this->interface->selectUserForRegistration();
    }
}
