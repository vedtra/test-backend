<?php

$router->get('/', function () use ($router) {
	return response()->json(['version' => $router->app->version()]);
});

// use MongoDB Atlas to manage data
$router->group(['prefix' => 'product'], function () use ($router) {
	$router->get('/', 'ProductController@index');
	$router->get('/{id}', 'ProductController@getById');
	$router->post('/', 'ProductController@store');
	$router->put('/{id}', 'ProductController@update');
	$router->delete('/{id}', 'ProductController@delete');
});

// use Firebase Firestore to manage data
$router->group(['prefix' => 'todo'], function () use ($router) {
	$router->get('/', 'TodoController@index');
	$router->get('/{id}', 'TodoController@getById');
	$router->post('/', 'TodoController@store');
	$router->put('/{id}', 'TodoController@update');
	$router->delete('/{id}', 'TodoController@delete');
});

// use Firebase Real-Time Database to manage data
$router->group(['prefix' => 'employee'], function () use ($router) {
	$router->get('/', 'EmployeeController@getAll');
	$router->get('/{employee_id}', 'EmployeeController@getById');
	$router->post('/', 'EmployeeController@store');
	$router->put('/{employee_id}', 'EmployeeController@update');
	$router->delete('/{employee_id}', 'EmployeeController@delete');
});


// read file sample_json.json
$router->get('/denom', function () {

	$json = file_get_contents(base_path('sample_data.json'));
	$json = json_decode($json);
	$jsonData = $json->data->response->billdetails;

	$data = collect($jsonData)->map(function ($q) {
		return [
			'denom'	=> (int) explode(':', $q->body[0])[1]
		];
	})->where('denom', '>=', 100000);

	$data_sort = array_values($data->toArray());
	return response()->json($data_sort);
});
