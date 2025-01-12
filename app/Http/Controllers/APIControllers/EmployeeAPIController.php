<?php
namespace App\Http\Controllers\APIControllers;

use App\Http\Resource\EmployeeResource;
use App\Models\Employee;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeAPIController extends BaseController{

    public function index(Request $request){

        $employees = Employee::get();

        return EmployeeResource::collection($employees);
    }

    public function store(Request $request){

        $rules = [
            'name' => 'nullable',
            'email' => 'required|email|unique:employees,emp_email',
            'code' => 'nullable',
            'phone' => 'nullable',
            'address' => 'nullable',
            'designation' => 'nullable',
            'joining_date' => 'nullable',
        ];

        $messages = [
            'email.required' => 'email is a required field',
            'email.email' => 'provided email is not a valid email',
            'email.unique' => 'employee already exists with provived email'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()){

            return response()->json(['errors' => $validator->errors()], 400);
        }

        $employee = Employee::create([
            'emp_name' => $request->name,
            'emp_email' => $request->email,
            'emp_code' => $request->code,
            'emp_phone' => $request->phone,
            'address' => $request->address,
            'designation' => $request->designation,
            'emp_joining_date' => $request->joining_date,
            'password' => 'Welcome@123#'
        ]);

        return new EmployeeResource($employee);
    }

    public function delete(Request $request){

        $rules = [
            'id' => 'required|exists:employees,id'
        ];
        
        $messages = [
            'id.required' => 'id is a required field',
            'id.exists' => 'employee with given id do not exists'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()){

            return response()->json(['errors' => $validator->errors()], 400);
        }

        Employee::where('id', $request->id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'employee deleted successfully'
        ], 200);
    }

    public function update(Request $request){

      $rules = [
        'id' => 'required|exists:employees,id',
        'email' => 'required|email',
        'name' => 'nullable'
      ];

      $messages = [
        'id.required' => 'id is a required field',
        'id.exists' => 'employee does not exists with provided id',
        'email.required' => 'email is a required field'
      ];

      $validator = Validator::make($request->all(), $rules, $messages);

      if($validator->fails()){

        return response()->json(['errors' => $validator->errors()], 400);
      }

      $employee = Employee::where('id', $request->id)
                    ->first();

      $employee->update([
        'emp_name' => isset($request->name) ? $request->name : $employee->emp_name,
        'emp_email' => $request->email
      ]);

      return new EmployeeResource($employee);
    }
}