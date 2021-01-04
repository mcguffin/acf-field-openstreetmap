<?php
/**
 *	Map Template Name: Admin
 *	Private: 1
 */

/** @var Array $args [
 *		'input_id'		=> String,
 *		'input_name'	=> String,
 *		'map' 			=> Array @see Model\Map::toArray(),
 *		'controls' 		=> Array [
 *			[ 'type' => String, 'config' => Mixed ],
 *			...
 *		],
 *		'field'			=> [
 *			'height' => Integer,
 *		]
 *	]
 */
$map = $args['map'];
$controls = $args['controls'];
$field = $args['field'];

$has_providers = (boolean) count( array_filter( $controls, function( $control ) {
	return 'providers' === $control['type'];
} ) );

$controls = array_map( function( $control ) {
	if ( 'providers' === $control['type'] ) {
		$control = wp_parse_args( $control, [
			'config' => array_values( acf_osm_get_leaflet_providers() ),
		]);
	}
	return $control;
}, $controls );

$attr = [
	'class'				=> 'leaflet-map',
	'data-height'		=> $field['height'],
	'data-map'			=> 'leaflet',
	'data-map-lng'		=> $map['lng'],
	'data-map-lat'		=> $map['lat'],
	'data-map-zoom'		=> $map['zoom'],
	'data-map-layers'	=> $map['layers'],
	'data-map-controls'	=> $controls,
//	'data-map-markers'	=> $map['markers'],
];

?>

<div class="leaflet-parent">
	<input <?php echo acf_osm_esc_attr( [
		'id'	=> $args['input_id'],
		'name'	=> $args['input_name'],
		'type'	=> 'hidden',
		'class' => 'osm-json',
		'value'	=> $map,
	] ) ?> />
	<div data-map-admin <?php echo acf_osm_esc_attr( $attr ) ?>></div>
</div>
<?php