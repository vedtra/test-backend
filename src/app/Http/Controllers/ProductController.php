<?php

namespace App\Http\Controllers;

use App\Repositories\ProductRepo;
use App\Transformers\ProductTransformer;
use Illuminate\Http\Request;

use Log;
use Validator;
use Cache;

class ProductController extends Controller
{
	private $product;
	public function __construct(ProductRepo $productRepo)
	{
		$this->product = $productRepo;
	}

	public function index(Request $request)
	{
		try {
			$products = $this->product->getAll();
		} catch (\Exception $e) {
			return $this->responser('Error Get Data', 400, null, $e->getMessage());
		}

		$data = fractal()->collection($products)->transformWith(new ProductTransformer)->toArray();

		return $this->responser('List Product', 200, $data['data']);
	}

	public function store(Request $request)
	{
		Log::info($request);
		$validator = Validator::make($request->all(), [
			'name'		=> 'required',
			'price'		=>	'required|numeric',
		]);

		if ($validator->fails()) {
			$validation = $this->validatorMessage($validator);

			return $this->responser('Error Validation', 400, null, $validation['data']);
		}

		try {
			$createData = $this->product->insert($request->all());
		} catch (\Exception $e) {
			return $this->responser('Error Insert Data', 400, null, $e->getMessage());
		}

		return $this->responser('Success Insert Product', 201, $createData);
	}

	public function getById($id)
	{
		try {
			$product = $this->product->getById($id);
		} catch (\Exception $e) {
			return $this->responser('Error Get Data', 400, null, $e->getMessage());
		}

		if (!$product) {
			return $this->responser('Product Not Found', 404);
		}

		$data = fractal()->item($product)->transformWith(new ProductTransformer)->toArray();

		return $this->responser('Product Detail', 200, $data['data']);
	}

	public function update(Request $request, $id)
	{
		Log::info($request);
		$validator = Validator::make($request->all(), [
			'name'		=> 'required',
			'price'		=>	'required|numeric',
		]);

		if ($validator->fails()) {
			$validation = $this->validatorMessage($validator);

			return $this->responser('Error Validation', 400, null, $validation['data']);
		}

		try {
			$update = $this->product->update($request->all(), $id);
		} catch (\Exception $e) {
			return $this->responser('Error Update Data', 400, null, $e->getMessage());
		}

		return $this->responser('Success Update Product', 201, $update);
	}

	public function delete($id)
	{
		try {
			$product = $this->product->getById($id);
		} catch (\Exception $e) {
			return $this->responser('Error Get Data', 400, null, $e->getMessage());
		}

		if (!$product) {
			return $this->responser('Product Not Found', 404);
		}

		$product->delete();
		Cache::tags('product')->flush();
		return $this->responser('Product Deleted', 200);
	}
}
