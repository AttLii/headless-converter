<?php

final class OutputTest extends \WP_Mock\Tools\TestCase {
	public function setUp(): void {
		\WP_Mock::setUp();
	}

	public function tearDown(): void {
		\WP_Mock::tearDown();
	}

	/**
	 * @runInSeparateProcess
	 */
  public function testOutputWithPostMockData() {
		$post = new WP_Post();
		$post->ID = 1;
		$post->post_title = "my title";

		\WP_Mock::userFunction( 'get_queried_object', array(
			'return' => $post
		));

    ob_start();
    require_once realpath( dirname( __FILE__ ) . '/../../src/output.php');
    $result = ob_get_clean();

    $this->assertEquals(
			$result,
			'{"data":{"ID":1,"post_title":"my title"}}'
		);
  }
	
	/**
	 * @runInSeparateProcess
	 */
  public function testOutputWithTermMockData() {
		$term = new WP_Term();
		$term->term_id = 1;
		$term->name = "Uncategorized";

		\WP_Mock::userFunction( 'get_queried_object', array(
			'return' => $term
		));

    ob_start();
    require_once realpath( dirname( __FILE__ ) . '/../../src/output.php');
    $result = ob_get_clean();

    $this->assertEquals(
			$result,
			'{"data":{"term_id":1,"name":"Uncategorized"}}'
		);
  }

	/**
	 * @runInSeparateProcess
	 */
  public function testOutputWithMockDataFor404Page() {
		\WP_Mock::userFunction( 'get_queried_object', array(
			'return' => null
		));

    ob_start();
    require_once realpath( dirname( __FILE__ ) . '/../../src/output.php');
    $result = ob_get_clean();

    $this->assertEquals($result, '{"data":null}');
  }

	/**
	 * @runInSeparateProcess
	 */
  public function testOutputWithMockDataAndFilter() {
		$post = new WP_Post();
		$post->ID = 1;
		$post->post_title = "my title";

		$altered_post = $post;
		$altered_post->acf = [];
		$altered_post->acf = ['custom_field' => 'hi'];

		\WP_Mock::onFilter( 'headless-plugin-modify-data' )
			->with( $post )
			->reply( $altered_post );

		\WP_Mock::userFunction( 'get_queried_object', array(
			'return' => $post
		));

    ob_start();
    require_once realpath( dirname( __FILE__ ) . '/../../src/output.php');
    $result = ob_get_clean();

    $this->assertEquals(
			$result,
			json_encode([
				"data" => $altered_post
			])
		);
  }
}