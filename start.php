<?php

function elgg_default_plugin_order(){
	elgg_default_plugin_order_reorder();
	elgg_default_plugin_order_set_status();
	if(is_plugin_enabled('elgg_default_plugin_order')){
		disable_plugin('elgg_default_plugin_order');
	}

}

function elgg_default_plugin_order_load_config(){
	$config_settings = array();
	$config_file = dirname(__FILE__)."/config.ini";
	if(file_exists($config_file)){
	   //TODO Add sussport for sections to handle diferent environments
	   $config_settings = parse_ini_file($config_file);
	}
	// TODO Hash configurations for execute this only when necessary
	return $config_settings;	
}
function elgg_default_plugin_order_reorder(){
	$final_order = array();
	$secuence = 10;
	$config_settings = elgg_default_plugin_order_load_config();
	foreach($config_settings as $plugin => $status){
		$final_order[$sequence] = $plugin;
		$secuence+=10;
	}	
	regenerate_plugin_list($final_order);
	elgg_filepath_cache_reset();
	
}
function elgg_default_plugin_order_set_status(){
	$config_settings = elgg_default_plugin_order_load_config();
	foreach($config_settings as $plugin => $status){
		switch($status){
			case 'enabled':
				if(!is_plugin_enabled($plugin)){
					enable_plugin($plugin);
				}
			break;
			case 'disabled':
				if(is_plugin_enabled($plugin)){
					disable_plugin($plugin);
				}
			break;
		}
	}
	elgg_filepath_cache_reset();
}


register_elgg_event_handler('init','system','elgg_default_plugin_order');

?>
