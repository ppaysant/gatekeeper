<?php
/**
 * ownCloud - 
 *
 * @author Marc DeXeT
 * @copyright 2014 DSI CNRS https://www.dsi.cnrs.fr
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE
 * License as published by the Free Software Foundation; either
 * version 3 of the License, or any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU AFFERO GENERAL PUBLIC LICENSE for more details.
 *
 * You should have received a copy of the GNU Affero General Public
 * License along with this library.  If not, see <http://www.gnu.org/licenses/>.
 *
 */
namespace OCA\GateKeeper\AppInfo;

class GKConstants {
	
	const UID_KIND 		= 1;
	const GROUP_KIND 	= 2;
	const WHITELIST_MODE_INT= 1;
	const BLACKLIST_MODE_INT= 2;
	const MANAGER_MODE_INT	= 9;
	const WHITELIST_MODE = 'whitelist';
	const BLACKLIST_MODE = 'blacklist';
	const OPENED_GATE_MODE = 'opened';


	public static function checkMode($mode) {
		if ($mode == GKConstants::WHITELIST_MODE 
			|| $mode == GKConstants::BLACKLIST_MODE 
			|| $mode == GKConstants::OPENED_GATE_MODE ) { 
			return true;
		}
		return false;
	}
}