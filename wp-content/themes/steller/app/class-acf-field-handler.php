<?php

namespace Theme\Steller;

/**
 * Class for use acf.
 *
 * Class AcfFieldHandler
 * @package Theme\Steller
 */
define( 'TEMPLATE_PATH', untrailingslashit( get_template_directory() ) );
class AcfFieldHandler{
	public function __construct() {
		add_filter('acf/settings/save_json', [ $this, 'steller_acf_json_save_point' ]);
		add_filter('acf/settings/load_json', [ $this, 'steller_acf_json_load_point' ]);
	}

	function steller_acf_json_save_point( $path ) {
		// Оновити шлях
		$path = TEMPLATE_PATH . '/app/acf-json';
		// Повернути шлях
		return $path;
	}
	function steller_acf_json_load_point( $paths ) {
		// Remove original path
		unset( $paths[0] );// Append our new path
		$paths[] = TEMPLATE_PATH . '/app/acf-json';   return $paths;
	}
}