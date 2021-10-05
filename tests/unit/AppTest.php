<?php

use HeadlessConverter\App;
use HeadlessConverter\Template;

final class AppTest extends \WP_Mock\Tools\TestCase {
	public function setUp(): void {
		\WP_Mock::setUp();
	}

	public function tearDown(): void {
		\WP_Mock::tearDown();
	}

	public function testCanCreateInstanceOfClass() {
		$this->assertInstanceOf(App::class, new App());
	}

	public function testHasExpectedMembers() {
		$app = new App();
		$this->assertInstanceOf(Template::class, $app->template);
	}
}