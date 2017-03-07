<?php
/**
 * Created by PhpStorm.
 * User: andy
 * Date: 2/23/17
 * Time: 10:04 PM
 */


defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );

//global $wco_settings;

/**
 * Class WCO_Settings
 *
 * @package WooImageOverlay
 */
class WCO_Worker {
	/**
	 * @var array
	 */
	private $product_attr = array();
	/**
	 * @var array
	 */
	private $product_cats = array();
	/**
	 * @var array
	 */
	private $products = array();
	/**
	 * @var array
	 */
	private $cache = array();
	/**
	 * @var string
	 */
	private $key = 'wco_cache';
	/**
	 * @var array
	 */
	private $product_data = array();


	public function __construct() {

	}

	/**
	 *
	 */
	public function flush_cache() {
		wp_cache_delete( $this->key );
	}

	/**
	 * @return array|bool|mixed
	 */
	public function get_cache() {

		if ( wp_cache_get( $this->key ) ) {
			$this->cache = wp_cache_get( $this->key );
		} else {
			wp_cache_set( $this->key, $this->get_product_data() );
			$this->cache = wp_cache_get( $this->key );
		}

		return $this->cache;
	}

	/**
	 * @return array
	 */
	public function get_product_data() {

		$this->product_data = array(
			'attr' => $this->get_product_attr(),
			'cat' => $this->get_product_cats(),
			'prod' => $this->get_products(),
		);

		return $this->product_data;
	}

	/**
	 * @return array|int|\WP_Error
	 */
	public function get_product_cats() {

		$args = array(
			'taxonomy'   => 'product_cat',
			'orderby'    => 'name',
			//'hide_empty' => true,
		);

		$this->product_cats = get_terms( 'product_cat', $args );
		//array_unshift($this->product_cats, 'disabled');

		return $this->product_cats;
	}

	/**
	 * @return array
	 */
	public function get_products() {
		$args           = array(
			'posts_per_page'   => - 1,
			'orderby'          => 'title',
			'post_type'        => 'product',
			'post_status'      => 'publish',
			'suppress_filters' => true,
		);
		$this->products = query_posts( $args );

		//array_unshift($this->products, 'disabled');

		return $this->products;
	}

	/**
	 * @return array
	 */
	public function get_product_attr() {

		$this->product_attr = array(
			'has-post-thumbnail',
			'downloadable',
			'virtual',
			'shipping-taxable',
			'purchasable',
			'product-type-variable',
			'product-type-simple',
			'has-children',
			'instock',
			'outofstock',
		);

		sort( $this->product_attr );
		array_unshift( $this->product_attr, 'none');

		return $this->product_attr;
	}




}