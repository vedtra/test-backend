<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

trait ApiResponser
{

	protected function responser($message = '', $code = 200, $data = null, $error_message = '')
	{

		if (env('APP_ENV') == 'production') {
			$error_message = '🍰 🍰 🍰';
		}
		if ($data !== null) {
			return response()->json(['message' => $message, 'results' => $data, 'error'  => $error_message], $code);
		} else {
			return response()->json(['message' => $message, 'error'  => $error_message], $code);
		}
	}

	protected function validatorMessage($validator)
	{
		$data = array();
		foreach ($validator->messages()->getMessages() as $field_name => $values) {
			$data[$field_name] = $values[0];
		}

		$res = [
			'msg'   => reset($data),
			'data'  => $data
		];
		return $res;
	}
}
