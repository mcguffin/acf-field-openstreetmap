<?php

namespace ACFFieldOpenstreetmap\Model;

use ACFFieldOpenstreetmap\Core;

/**
 *	Represents a map Layer
 */
class MapLayer implements MapItemInterface {

	/** @var Array type to class mapping */
	protected static $types = [];
	
	/** @var String 'leaflet', 'markers' */
	private $type;
	
	/** @var Mixed Layer configuration */
	private $config;
	
	public static function registerType( $class ) {
		self::$types[ $class::TYPE ] = $class;
	}
	
	/**
	 *	@param Array $array [
	 *		'type' => String,
	 *		'config' => Mixed,
	 *	]
	 *	@return MapLayer instance
	 */
	public static function fromArray( $array ) {

		$array = wp_parse_args($array,[
			'type' => '',
			'config' => null,
		]);

		if ( isset( MapLayer::$types[ $array['type'] ] ) ) {
			$class = MapLayer::$types[ $array['type'] ];
		} else {
			$class = get_called_class();
		}

		$inst = new $class( $array['type'], $array['config'] );
		return $inst;
	}

	/**
	 *	@param String $type
	 *	@param Mixed $config
	 */
	public function __construct( $type, $config ) {
		$this->type = $type;
		$this->config = $config;
	}

	/**
	 *	Magic getter
	 *
	 *	@param String $what
	 *	@return Mixed
	 */
	public function __get( $what ) {
		if ( 'type' === $what ) {
			return $this->type;
		} else if ( 'config' === $what ) {
			return $this->config;
		}
	}

	/**
	 *	@return Array [
	 *		'type' => String,
	 *		'config' => Mixed,
	 * ]
	 */
	public function toArray() {
		return [
			'type' => $this->type,
			'config' => $this->config,
		];
	}


}