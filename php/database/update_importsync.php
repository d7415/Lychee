<?php

/**
 * Update to version 3.2.x
 */

use Lychee\Modules\Database;
use Lychee\Modules\Response;

// Add license to settings
$query  = Database::prepare($connection, "SELECT `key` FROM `?` WHERE `key` = 'deleteImported' LIMIT 1", array(LYCHEE_TABLE_SETTINGS));
$result = Database::execute($connection, $query, 'update_03020x', __LINE__);

if ($result===false) Response::error('Could not load settings from database!');

if ($result->num_rows===0) {

	$query  = Database::prepare($connection, "INSERT INTO `?` (`key`, `value`) VALUES ('deleteImported', 1)", array(LYCHEE_TABLE_SETTINGS));
	$result = Database::execute($connection, $query, 'update_03020x', __LINE__);

	if ($result===false) Response::error('Could not add new setting to database!');
	// Set version if successful
	elseif (Database::setVersion($connection, 'update_03020x')===false) Response::error('Could not update version of database!');

}
