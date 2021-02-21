<?php

namespace App\Transformers;

use App\Models\Product;
use League\Fractal\TransformerAbstract;

class ProductTransformer extends TransformerAbstract
{
	public function transform(Product $product)
	{
		return [
			'id' => $product->_id,
			'name'	=>	$product->name,
			'price'	=>	rupiah($product->price),
			'createdAt' => $product->created_at->toDateTimeString()
		];
	}
}
