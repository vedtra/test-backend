<?php

namespace App\Http\Controllers;

use App\Repositories\TodosRepo;
use Illuminate\Http\Request;

use Validator;
use Log;

class TodoController extends Controller
{
	private $todos;
	public function __construct(TodosRepo $todos)
	{
		$this->todos = $todos;
	}

	public function index()
	{
		try {
			$todos =  $this->todos->getAll();
		} catch (\Exception $e) {
			return $this->responser('Error Get Data', 400, null, $e->getMessage());
		}

		$data = [];
		if (!$todos->isEmpty()) {
			foreach ($todos as $todo) {
				array_push($data, [
					'_id'	=>	$todo->id(),
					'data'	=>	$todo->data()
				]);
			}
		}

		return $this->responser('List Todos', 200, $data);
	}

	public function getById($id)
	{
		try {
			$todo =  $this->todos->getOne($id);
		} catch (\Exception $e) {
			return $this->responser('Error Get Data', 400, null, $e->getMessage());
		}

		if (!$todo->exists()) {
			return $this->responser('Todo Not Found', 404);
		}
		return $this->responser('Todo with unique id: ' . $id, 200, $todo->data());
	}

	public function store(Request $request)
	{
		Log::info($request);
		$validator = Validator::make($request->all(), [
			'name'			=> 'required',
			'is_complete'	=>	'required|boolean'
		]);

		if ($validator->fails()) {
			$validation = $this->validatorMessage($validator);

			return $this->responser('Error Validation', 400, null, $validation['data']);
		}

		try {
			$createData = $this->todos->insert($request->all());
		} catch (\Exception $e) {
			return $this->responser('Error Insert Data', 400, null, $e->getMessage());
		}

		return $this->responser('Success Insert Data', 201, $createData);
	}

	public function delete($id)
	{
		try {
			$this->todos->destroy($id);
		} catch (\Exception $e) {
			return $this->responser('Error Delete Data', 400, null, $e->getMessage());
		}

		return $this->responser('Todo Deleted', 200);
	}
}
