<?php

namespace App\Repositories;

use App\Services\FirebaseService;
use Kreait\Firebase\Exception\FirebaseException;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Ramsey\Uuid\Uuid;

class EmployeeRepo
{
	protected $db;
	public function __construct(FirebaseService $firebaseService)
	{
		$this->db = $firebaseService->db();
	}

	public function getAll()
	{
		try {
			$getAll = $this->db->getReference('employee')->getValue();
		} catch (FirebaseException $e) {
			throw $e;
		}

		return $getAll;
	}

	public function getById($employee_key)
	{
		try {
			$getOne = $this->db->getReference('employee/' . $employee_key)->getValue();
		} catch (FirebaseException $e) {
			throw $e;
		}

		return $getOne;
	}

	public function insert($request)
	{
		try {

			$create = $this->db->getReference('employee')
				->push([
					'_id' => Uuid::uuid4()->toString(),
					'name' => $request['name'],
					'age' => $request['age'],
					'address' => $request['address']
				]);

			return $create->getValue();
		} catch (FirebaseException $e) {
			throw $e;
		}
	}

	public function update($request, $employee_key)
	{
		try {

			$update = $this->db->getReference('employee/' . $employee_key)
				->update([
					'name' => $request['name'],
					'age' => $request['age'],
					'address' => $request['address']
				]);

			return $update->getValue();
		} catch (FirebaseException $e) {
			throw $e;
		}
	}

	public function destroy($employee_key)
	{
		try {
			$delete = $this->db->getReference('employee/' . $employee_key)->remove();
		} catch (FirebaseException $e) {
			throw $e;
		}

		return $delete;
	}
}
