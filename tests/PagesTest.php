<?php

namespace Tests\App;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PageTest extends WebTestCase
{
	/**
	 * @dataProvider urlProvider
	 */
	public function testPageIsSuccessful($url)
	{
		$client = static::createClient(array(), array(
			'PHP_AUTH_USER' => 'admin',
			'PHP_AUTH_PW'   => '0000',
		));
		$client->request('GET', $url);

		$this->assertTrue($client->getResponse()->isSuccessful());
	}

	public function urlProvider()
	{
		yield ['/'];
		yield ['/login'];
		yield ['/message'];
	}
}