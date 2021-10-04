<?php

use HeadlessPlugin\Template;

final class TemplateTest extends \WP_Mock\Tools\TestCase {
	public function setUp(): void {
		\WP_Mock::setUp();
	}

	public function tearDown(): void {
		\WP_Mock::tearDown();
	}

	public function testCanCreateInstanceOfClass() {
		$this->assertInstanceOf(Template::class, new Template());
	}

	public function testAddHooksMethod() {
		$class = new Template();

		\WP_Mock::expectFilterAdded( 'template_redirect', array( $class, 'override_template_with_json' ) );
		\WP_Mock::expectFilterAdded( 'application_password_is_api_request', '__return_true' );

		$class->add_hooks();
		$this->assertHooksAdded();
	}

	/**
	 * @runInSeparateProcess
	 */
	public function testOverrideTemplateWithJsonMethodWhileAuthValidationFails() {
		\WP_Mock::userFunction( 'wp_validate_application_password', array(
			'return' => null
		));

		$class = new Template();
		ob_start();
		$class->override_template_with_json();
		$result = ob_get_clean();

		$this->assertEquals($result, "");
	}

	/**
	 * @runInSeparateProcess
	 */
	public function testOverrideTemplateWithJsonMethodWhileAuthValidationSucceeds() {
		\WP_Mock::userFunction( 'wp_validate_application_password', array(
			'return' => 1
		));

		\WP_Mock::userFunction( 'user_can', array(
			'return' => true
		));

		\WP_Mock::userFunction( 'get_queried_object', array(
			'return' => function() {
				$post = new WP_Post();
				$post->ID = 1;
				$post->post_title = "my title";
				return $post;
			}
		));
		
		$class = new Template();

		$calls_exit = false;
		ob_start();
		try {
			$class->override_template_with_json();
		} catch (Exception $e) {
			$calls_exit = true;
		}
		$result = ob_get_clean();

		$this->assertEquals($result, '{"data":{"ID":1,"post_title":"my title"}}');
		$this->assertTrue($calls_exit);
	}

	/**
	 * @runInSeparateProcess
	 */
	public function testOverrideTemplateWithJsonMethodWhileAuthValidationSucceedsButUserHasNoCapabilities() {
		\WP_Mock::userFunction( 'wp_validate_application_password', array(
			'return' => 13
		));

		\WP_Mock::userFunction( 'user_can', array(
			'return' => false
		));

		$class = new Template();

		ob_start();
		$class->override_template_with_json();
		$result = ob_get_clean();

		$this->assertEquals($result, '');
	}
}