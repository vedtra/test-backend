<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Database\QueryException;

use Cache;

class ProductRepo
{

	// implementing redis

	public function getAll()
	{
		try {

			$cacheName = cacheName(app('request')->url(), app('request')->query());

			$result = Cache::tags('product')->remember($cacheName, 2, function () {
				return  Product::orderBy('created_at', 'DESC')->get();
			});
		} catch (QueryException $e) {
			throw $e;
		}

		return $result;
	}

	public function getById($id)
	{
		try {
			$result = Cache::tags('product')->remember('product_' . $id, 2, function () use ($id) {
				return Product::where('_id', $id)->first();
			});
		} catch (QueryException $e) {
			throw $e;
		}

		return $result;
	}

	public function insert($request)
	{
		$payloads = [
			'name'	=> $request['name'],
			'price'	=>	$request['price']
		];

		try {
			$insertProduct = Product::create($payloads);
		} catch (QueryException $e) {
			throw $e;
		}

		Cache::tags('product')->flush();

		return $insertProduct;
	}

	public function update($request, $id)
	{
		$payloads = [
			'name'	=> $request['name'],
			'price'	=>	$request['price']
		];

		try {
			$update = Product::where('_id', $id)->update($payloads);
		} catch (QueryException $e) {
			throw $e;
		}

		Cache::tags('product')->flush();

		return $update;
	}
}
