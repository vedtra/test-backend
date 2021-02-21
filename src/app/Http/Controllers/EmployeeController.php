<?php

namespace App\Http\Controllers;

use App\Repositories\EmployeeRepo;
use Illuminate\Http\Request;
use Kreait\Firebase\Exception\FirebaseException;

use Validator;
use Log;

class EmployeeController extends Controller
{
	private $employee;
	public function __construct(EmployeeRepo $employeeRepo)
	{
		$this->employee = $employeeRepo;
	}

	public function getAll()
	{
		try {
			$employees =  $this->employee->getAll();
		} catch (\Exception $e) {
			return $this->responser('Error Get Data', 400, null, $e->getMessage());
		}

		return $this->responser('List Employee', 200, $employees);
	}

	public function getById($employee_id)
	{
		try {
			$employee =  $this->employee->getById($employee_id);
		} catch (\Exception $e) {
			return $this->responser('Error Get Data', 400, null, $e->getMessage());
		}

		if (!$employee) {
			return $this->responser('Employee with unique id: ' . $employee_id . 'Not Found', 404);
		}
		return $this->responser('Employee with unique id: ' . $employee_id, 200, $employee);
	}

	public function store(Request $request)
	{
		Log::info($request);
		$validator = Validator::make($request->all(), [
			'name'		=> 'required',
			'age'			=>	'required|numeric',
			'address'	=>	'required|string|min:5'
		]);

		if ($validator->fails()) {
			$validation = $this->validatorMessage($validator);

			return $this->responser('Error Validation', 400, null, $validation['data']);
		}

		try {
			$createData = $this->employee->insert($request->all());
		} catch (\Exception $e) {
			return $this->responser('Error Insert Data', 400, null, $e->getMessage());
		}

		return $this->responser('Success Insert Data', 201, $createData);
	}


	public function update(Request $request, $employee_id)
	{
		Log::info($request);
		$validator = Validator::make($request->all(), [
			'name'		=> 'required',
			'age'			=>	'required|numeric',
			'address'	=>	'required|string|min:5'
		]);

		if ($validator->fails()) {
			$validation = $this->validatorMessage($validator);

			return $this->responser('Error Validation', 400, null, $validation['data']);
		}

		try {
			$createData = $this->employee->update($request->all(), $employee_id);
		} catch (\Exception $e) {
			return $this->responser('Error Insert Data', 400, null, $e->getMessage());
		}

		return $this->responser('Success Update Data', 201, $createData);
	}

	public function delete($employee_id)
	{
		try {
			$this->employee->destroy($employee_id);
		} catch (\Exception $e) {
			return $this->responser('Error Get Data', 400, null, $e->getMessage());
		}


		return $this->responser('Employee with unique id: ' . $employee_id . ' Deleted', 200);
	}
}
