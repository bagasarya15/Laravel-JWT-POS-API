<?php

namespace Tests\Feature;

use App\Models\Employee;
use App\Repositories\Master\EmployeeRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;
use App\Http\Requests\Employee\StoreRequest;
use Mockery;

class EmployeeRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected $employeeRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->employeeRepository = new EmployeeRepository();
    }

    public function testStoreCreatesEmployee()
    {
        $request = Mockery::mock(StoreRequest::class);
        $request->shouldReceive('validated')->andReturn([
            'firstname' => 'John',
            'lastname' => 'Doe',
            'last_education' => 's1',
        ]);

        $response = $this->employeeRepository->store($request);

        $responseData = $response->getData(true);

        $this->assertEquals(201, $responseData['status']);
        $this->assertEquals('Data berhasil ditambah', $responseData['message']);
        $this->assertDatabaseHas('employees', [
            'firstname' => 'John',
            'lastname' => 'Doe',
            'last_education' => 's1',
        ]);
    }


    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
