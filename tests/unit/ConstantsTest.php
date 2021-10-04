<?php

use HeadlessPlugin\Constants;

final class ConstantsTest extends \WP_Mock\Tools\TestCase {
	public function setUp(): void {
		\WP_Mock::setUp();
	}

	public function tearDown(): void {
		\WP_Mock::tearDown();
	}

	public function testHasExpectedMembers() {
		$this->assertTrue(Constants::FILTER_MODIFY_DATA !== null);
	}
}