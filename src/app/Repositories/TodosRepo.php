<?php

namespace App\Repositories;

use App\Services\FirebaseService;
use Kreait\Firebase\Exception\FirebaseException;
use Ramsey\Uuid\Nonstandard\Uuid;

class TodosRepo
{

	protected $fs, $collection;

	public function __construct(FirebaseService $firebaseService)
	{
		$this->fs = $firebaseService->fs();
		$this->collection = $this->fs->collection('todos');
	}

	public function getAll()
	{
		try {
			$documents = $this->collection->documents();
		} catch (FirebaseException $e) {
			throw $e;
		}

		return $documents;
	}


	public function getOne($id)
	{
		try {
			$doc = $this->collection->document($id)->snapshot();
		} catch (FirebaseException $e) {
			throw $e;
		}

		return $doc;
	}

	public function insert($request)
	{
		try {
			$id = Uuid::uuid4()->toString();
			$doc = $this->collection->document('todo' . $id);
			$doc->set([
				'name'			=> $request['name'],
				'isComplete'	=>	$request['is_complete']
			]);

			$res = $doc->snapshot();
		} catch (FirebaseException $e) {
			throw $e;
		}

		return $res->data();
	}

	public function destroy($id)
	{
		try {
			$doc = $this->collection->document($id)->delete();
		} catch (FirebaseException $e) {
			throw $e;
		}

		return $doc;
	}
}
