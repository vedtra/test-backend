<?php

namespace App\Services;

use Kreait\Laravel\Firebase\Facades\Firebase;

class FirebaseService
{

	protected $firebase;

	public function __construct(Firebase $firebase)
	{
		$this->firebase = $firebase::project();
	}

	public function db()
	{
		return $this->firebase->database();
	}

	public function fs()
	{
		return $this->firebase->firestore()->database();
	}
}
