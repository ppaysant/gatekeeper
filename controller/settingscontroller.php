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


namespace OCA\GateKeeper\Controller;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\JSONResponse;
use OCP\AppFramework\Http;
use OCA\GateKeeper\AppInfo\GKConstants as GK;
use OCA\GateKeeper\Db\AccessObject;
/**
*
*/
class SettingsController extends Controller {

	var $appConfig;
	var $accessObjectMapper;
	var $groupManager;

	public function __construct($request, $appConfig, $accessObjectMapper, $groupManager) {
		parent::__construct('gatekeeper', $request);
		$this->appConfig = $appConfig;
		$this->accessObjectMapper = $accessObjectMapper;
		$this->groupManager = $groupManager;
	}


	/**
	* @Ajax
	*/
	public function setMode() {
		\OC_Util::checkAdminUser();
		$params = $this->request->post;
		$value = isset($params['value']) ? $params['value'] : null;

		if ( is_null($value) )  {
			throw new  \Exception("mode value can not be null", 1);
		}
		if ( ! GK::checkMode($value)) {
			throw new  \Exception("mode value is incorrect", 1);	
		}
		$this->appConfig->setValue('gatekeeper','mode',$value);
		return new JSONResponse( array('status' => 'ok') );
	}

	/**
	* @Ajax
	*/
	public function searchGroup() {
		\OC_Util::checkAdminUser();
		$params = $this->request->get;
		$mode = isset($params['mode']) ? $params['mode'] : null;
		if ( is_null($mode) )  {
			return new JSONResponse( array("msg" => "criteria is not specified"), Http::STATUS_BAD_REQUEST);
		}
 		if ( ! GK::checkMode($mode) ) {
			return new JSONResponse( array("msg" => "mode is not valid"), Http::STATUS_BAD_REQUEST);
		}

		$groups = $this->accessObjectMapper->findGroupsInMode(GK::modeToInt($mode));
		$array = array();
		if ( $groups ) {
			foreach ($groups as $group) {
				$array[] = array('id' => $group->getId(), 'name' => $group->getName());
			}
		}
		return new JSONResponse( $array );
	}	


	/**
	* @Ajax
	*/
	public function manageGroup() {
		\OC_Util::checkAdminUser();
		$params = $this->request->post;
		$group = isset($params['group']) ? $params['group'] : null;
		$action = isset($params['action']) ? $params['action'] : null;
		$mode = isset($params['mode']) ? $params['mode'] : null;
		if ( is_null($group) || is_null($action) || is_null($mode)) {
			return new JSONResponse( array("msg" => "Not specified group or action or mode"), Http::STATUS_BAD_REQUEST);
		}
		switch ($action) {
			case 'rm':
				$ao = AccessObject::fromParams(array('id' => $group));
				$this->accessObjectMapper->delete($ao);
				break;
			case 'add':
				# code...
				break;				
			
			default:
				# code...
				break;
		}
		return new JSONResponse( array('id' => $group));

	}
}