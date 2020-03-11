<?php
namespace WebAppick\AppServices;
use stdClass;
if( ! defined( 'ABSPATH' ) ) die();
/**
 * WebAppick Updater
 *
 * This class will show new updates project
 */
class Updater {
	
	/**
	 * WebAppick\AppServices\Client
	 *
	 * @var Client
	 */
	protected $client;
	
	/**
	 * Flag for checking if the init method is already called.
	 * @var bool
	 */
	private $didInit = false;
	
	/**
	 * WebAppick\AppServices\License
	 *
	 * @var License
	 */
	protected $license;
	
	/**
	 * Cache Key for current App
	 * @var string
	 */
	private $cache_key;
	
	/**
	 * Initialize the class
	 *
	 * @param Client $client
	 * @param License $license
	 */
	public function __construct( Client $client, License $license ) {
		$this->client    = $client;
		$this->license   = $license;
		$this->cache_key = 'WebAppick_' . md5( $this->client->getSlug() ) . '_version_info';
	}
	
	/**
	 * Initialize Updater
	 *
	 * @return void
	 */
	public function init() {
		// Run hooks.
		if ( $this->client->getType() == 'plugin' ) {
			$this->run_plugin_hooks();
		} elseif ( $this->client->getType() == 'theme' ) {
			$this->run_theme_hooks();
		}
		$this->didInit = true;
	}
	
	/**
	 * Set up WordPress filter to hooks to get update.
	 *
	 * @return void
	 */
	private function run_plugin_hooks() {
		add_filter( 'pre_set_site_transient_update_plugins', array( $this, 'check_plugin_update' ) );
		add_filter( 'plugins_api', array( $this, 'plugins_api_filter' ), 10, 3 );
		register_deactivation_hook( $this->client->getFile(), array( $this, 'delete_cached_version_info' ) );
	}
	
	/**
	 * Set up WordPress filter to hooks to get update.
	 *
	 * @return void
	 */
	private function run_theme_hooks() {
		add_filter( 'pre_set_site_transient_update_themes', array( $this, 'check_theme_update' ) );
		add_action( 'switch_theme', array( $this, 'delete_cached_version_info' ) );
	}
	
	/**
	 * Check for Update for this specific project
	 * @param object $transient_data
	 * @return object
	 */
	public function check_plugin_update( $transient_data ) {
		global $pagenow;
		//delete_site_transient( 'update_plugins' );
		if ( ! isset( $transient_data->checked ) || isset( $transient_data->checked ) && empty( $transient_data->checked ) ) {
			return $transient_data;
		}
		if ( ! is_object( $transient_data ) ) $transient_data = new stdClass;
		if ( 'plugins.php' == $pagenow && is_multisite() ) return $transient_data;
		if ( ! empty( $transient_data->response ) && ! empty( $transient_data->response[ $this->client->getBasename() ] ) ) {
			return $transient_data;
		}
		$project_info = $this->get_cached_version_info();
		if ( false === $project_info ) {
			$project_info = $this->get_information();
			$this->set_cached_version_info( $project_info );
		}
		if ( false !== $project_info && is_object( $project_info ) && isset( $project_info->new_version ) ) {
			if ( version_compare( $this->client->getProjectVersion(), $project_info->new_version, '<' ) ) {
				unset( $project_info->sections );
				$transient_data->response[ $this->client->getBasename() ] = $project_info;
			}
			$transient_data->last_checked = time();
			$transient_data->checked[ $this->client->getBasename() ] = $this->client->getProjectVersion();
		}
		return $transient_data;
	}
	
	/**
	 * Get version info from database
	 *
	 * @return object|bool
	 */
	private function get_cached_version_info() {
		$info = get_transient( $this->cache_key );
		if( ! $info && ! isset( $info->name ) ) {
			return false; // Cache is expired
		}
		return $this->__children_to_array( $info, [ 'icons', 'banners', 'sections' ] );
	}
	
	/**
	 * Set version info to database
	 * @param string $value
	 * @return void
	 */
	private function set_cached_version_info( $value ) {
		if ( ! $value ) return;
		set_transient( $this->cache_key, $value, 3 * HOUR_IN_SECONDS );
	}
	
	/**
	 * Delete cached version info
	 * @return bool
	 */
	public function delete_cached_version_info() {
		return delete_transient( $this->cache_key );
	}
	
	/**
	 * Get plugin info from WebAppick
	 * @return bool|array
	 */
	private function get_information() {
		$response = $this->license->check_update();
//		$fields = [
//			'id',
//			'name',
//			'author',
//			'author_profile',
//			'slug',
//			'plugin',
//			'new_version',
//			'url',
//			'package',
//			'icons',
//			'banners',
//			'banner_rtl',
//			'upgrade_notice',
//			'requires',
//			'requires_php',
//			'tested',
//			'compatibility',
//			'contributors',
//			'ratings',
//			'num_ratings',
//			'last_updated',
//			'homepage',
//			'author_block_count',
//			'author_block_rating',
//		];
		if( isset( $response['success'] ) && $response['success'] ) {
			$data = $response['data']['package'];
			$response = $this->license->get_information();
			if( isset( $response['success'] ) && $response['success'] ) {
				$data = array_merge( $data, $response['data']['info'] );
			}
			if( isset( $data['product_id'] ) ) unset( $data['product_id'] );
			/**
			 * Filter API Response Data
			 * @param array $data
			 */
			$data = apply_filters( 'WebAppick_' . $this->client->getSlug() . '_plugin_api_info', $data );
			return $this->__children_to_array( (object) $data, [ 'icons', 'banners', 'sections', 'compatibility', 'ratings', 'contributors', 'screenshots', 'tags' ] );
		}
		return false;
	}
	
	/**
	 * Updates information on the "View version x.x details" page with custom data.
	 *
	 * @param mixed   $data
	 * @param string  $action
	 * @param object  $args
	 *
	 * @return object $data
	 */
	public function plugins_api_filter( $data, $action = '', $args = null ) {
		if ( $action != 'plugin_information' ) return $data;
		if ( ! isset( $args->slug ) || ( $args->slug != $this->client->getSlug() ) ) return $data;
		$project_info = $this->get_cached_version_info();
		if ( false === $project_info ) {
			$project_info = $this->get_information();
			$this->set_cached_version_info( $project_info );
		}
		return $project_info;
	}
	
	/**
	 * Check theme update
	 * @param object $transient_data
	 * @return object
	 */
	public function check_theme_update( $transient_data ) {
		global $pagenow;
		if ( ! is_object( $transient_data ) ) $transient_data = new stdClass;
		if ( 'themes.php' == $pagenow && is_multisite() ) return $transient_data;
		if ( ! empty( $transient_data->response ) && ! empty( $transient_data->response[ $this->client->getSlug() ] ) ) {
			return $transient_data;
		}
		$project_info = $this->get_cached_version_info();
		if ( false === $project_info ) {
			$project_info = $this->get_information();
			$this->set_cached_version_info( $project_info );
		}
		if ( false !== $project_info && is_object( $project_info ) && isset( $project_info->new_version ) ) {
			if ( version_compare( $this->client->getProjectVersion(), $project_info->new_version, '<' ) ) {
				$transient_data->response[ $this->client->getSlug() ] = (array) $project_info;
			}
			$transient_data->last_checked = time();
			$transient_data->checked[ $this->client->getSlug() ] = $this->client->getProjectVersion();
		}
		return $transient_data;
	}
	
	/**
	 * Typecast child element to array or object
	 * Utility method
	 * @param array|object $object
	 * @param array $children
	 * @param string $castTo    optional array or object
	 *
	 * @return mixed|array|object
	 */
	private function __children_to_array( $object, $children = [], $castTo = 'array' ) {
		if( ! empty( $children ) && is_array( $children ) && ( is_object( $object ) || is_array( $object ) ) ) {
			$isObject = is_object( $object );
			$castTo = strtolower( $castTo ) == 'array' ? 'A' : 'O';
			foreach( $children as $child ) {
				if( $isObject && property_exists( $object, $child ) ) {
					$object->{$child} = $castTo === 'A' ? (array) $object->{$child} : (object) $object->{$child};
				} else if( array_key_exists( $child, $object ) ) {
					$object[$child] = $castTo === 'A' ? (array) $object[$child] : (object) $object[$child];
				}
			}
		}
		return $object;
	}
}
// End of file Updater.php
