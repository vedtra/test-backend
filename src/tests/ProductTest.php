<?php

class ProductTest extends TestCase
{
	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	public function testGetStatusCode()
	{
		$response = $this->call('GET', '/product');

		$this->assertEquals(200, $response->status());
	}

	public function testShouldReturnProducts()
	{
		$this->get('/product');
		$this->seeStatusCode(200);
		$this->seeJsonStructure([
			'message',
			'results' => [
				'*' =>
				[
					'id',
					'name',
					'price',
					'createdAt'
				]
			],
			'error'
		]);
	}

	public function testCreateProduct()
	{
		$bodyRequest = [
			'name'	=> 'PS 5',
			'price'	=> 18000000
		];

		$this->post('/product', $bodyRequest);
		$this->seeStatusCode(201);
		$this->seeJsonStructure([
			'message',
			'results' => [
				'name',
				'price',
				'updated_at',
				'created_at',
				'_id'
			],
			'error'
		]);
	}
}
