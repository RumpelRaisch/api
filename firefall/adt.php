<?php
use Raisch\Libs\Database\Database;
use Raisch\Libs\Debug;
use Raisch\Libs\Logger\Logger;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

error_reporting(E_ALL | E_STRICT);

header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
header('Pragma: no-cache');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');

$sHandle = null;
$sDir    = dirname(dirname(dirname(__DIR__)));

if (true === isset($_GET['handle'])) {
    $sHandle = $_GET['handle'];
}

// see: https://github.com/RumpelRaisch/Raisch.git
require_once $sDir . DIRECTORY_SEPARATOR . 'lib'
                   . DIRECTORY_SEPARATOR . 'Raisch'
                   . DIRECTORY_SEPARATOR . 'Raisch.php';

require_once $sDir . DIRECTORY_SEPARATOR . 'configs'
                   . DIRECTORY_SEPARATOR . 'api-firefall-adt.conf.php';

require_once __DIR__ . DIRECTORY_SEPARATOR . 'php' . DIRECTORY_SEPARATOR . 'AdtAbilityInfosMapper.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'php' . DIRECTORY_SEPARATOR . 'AdtAbilityInfosModel.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'php' . DIRECTORY_SEPARATOR . 'AdtRoute.php';

$oDatabase = new Database(SQL_DNS, SQL_USER, SQL_PASSWORD);
$oLogger   = new Logger(__DIR__ . DIRECTORY_SEPARATOR . 'log' . DIRECTORY_SEPARATOR . 'adt.' . date('Y\_W', time()) . '.txt');
$oRoute    = new AdtRoute();

if (true === isset($_GET['route'])) {
    $oRoute->set($_GET['route']);
}

try {
    $oAbilityMapper = new AdtAbilityInfosMapper($oDatabase);
    $oAbilityMapper->injectILogger($oLogger);

    switch ($sHandle) {
        case 'json':
            header('Content-type: application/json; charset=utf-8');

            $sRawData = file_get_contents('php://input');
            $aRawData = json_decode($sRawData, true);
            $bCheck   = isset(
                $aRawData['ability_id'],
                $aRawData['ability_icon_id'],
                $aRawData['ability_name'],
                $aRawData['ability_event'],
                $aRawData['ability_reports_duration']
            );

            if ($bCheck and 5 === count($aRawData)) {
                $oAbilityMapper->insert(new AdtAbilityInfosModel($aRawData));

                print '{}';
            } else {
                if (true === $oRoute->exists('addon')) {
                    $oAbilityMapper->addWhere(array('ability_used_by_addon', '=', '1'));
                }

                $aAbilities = $oAbilityMapper->fetchAll();
                $sJson      = '';

                foreach ($aAbilities as $oAbility) {
                    $sJson .= $oAbility->getJson() . ',';
                }

                print '[' . substr($sJson, 0, -1) . ']';
            }
            break;

        case 'html':
            if (true === $oRoute->exists('order')) {
                $oAbilityMapper->setOrder(array('id' => 'ASC'));
            }

            $aAbilities = $oAbilityMapper->fetchAll();

            include __DIR__ . DIRECTORY_SEPARATOR . 'tpl' . DIRECTORY_SEPARATOR . 'table.php';
            break;

        case 'lua':
            Debug::getInstance()->echoPrintRInPre($oAbilityMapper->getLuaAbilityInfos());
            break;

        case 'test':
            $aRoute = array();

            while (false !== $oRoute->next()) {
                $aRoute[] = $oRoute->current();
            }

            Debug::getInstance()->echoPrintRInPre($aRoute);
            break;

        default:
            print '{}';
    }
} catch (Exception $oEx) {
    $oLogger->log(print_r($oEx, true));

    print '{}';
}
