<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\EmployeeRepository\employeeinterface;
use Exception;

class EmployeeApiController extends Controller
{
    protected $repositoryInterface;
    /**
     * Display a listing of the resource.
     */

     public function __construct(EmployeeInterface $repositoryInterface)
    {
        $this->repositoryInterface = $repositoryInterface;
    }

    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'employeename' => 'required|string',
                'dob' => 'required|date',
                'phone' => 'required|string'
            ]);

            $createdEmployee = $this->repositoryInterface->store($data);

            return response()->json(['data' => $createdEmployee], 201);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Get single employee (like "edit" in web apps)
    public function showEmployee(Employee $id)
    {
        try {
            return response()->json(['data' => $id]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function updateEmployee(Employee $id, Request $request)
    {
        try {
            $data = $request->validate([
                'employeename' => 'required|string',
                'dob' => 'required|date',
                'phone' => 'required|string'
            ]);

            $this->repositoryInterface->updateEmployee($id, $data);

            return response()->json(['message' => "Employee updated successfully"]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Delete employee
    public function deleteEmployee(Employee $id)
    {
        try {
            $deletedEmployee = $this->repositoryInterface->deleteEmployee($id);
            return response()->json(['message' => "Employee deleted successfully"]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // get all employee
    public function getallemployee()
    {
        try{
            $getallemployee = $this->repositoryInterface-> getallemployee();
            return response()->json(['data' =>  $getallemployee]);
           }catch(Exception $e){
            return response()->json(['error' => $e->getMessage(),500]);
           }
    }
}
