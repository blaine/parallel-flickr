<?php

	loadlib("flickr_api");

	#################################################################

	$GLOBALS['flickr_places_cache'] = array();

	#################################################################

	function flickr_places_valid_placetypes(){

		return array(
			'neighbourhood',
			'locality',
			'county',
			'region',
			'country',
		);
	}

	#################################################################

	function flickr_places_is_valid_placetype($type){

		$valid = flickr_places_valid_placetypes();
		return (in_array($type, $valid)) ? 1 : 0;
	}

	#################################################################

	function flickr_places_get_by_woeid($woeid){

		# sudo memcache me...

		if (isset($GLOBALS['flickr_places_cache'][$woeid])){
			return $GLOBALS['flickr_places_cache'][$woeid];
		}

		$method = "flickr.places.getInfo";
		$args = array('woe_id' => $woeid);

		$rsp = flickr_api_call($method, $args);

		if (! $rsp['ok']){
			return null;
		}

		$place = $rsp['rsp']['place'];
		$GLOBALS['flickr_places_cache'][$woeid] = $place;

		return $place;
	}

	#################################################################
?>
