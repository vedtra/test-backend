<?php


class VersionTest extends TestCase
{
	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	public function testExample()
	{
		$response = $this->call('GET', '/');

		$this->assertEquals(200, $response->status());
	}
}
