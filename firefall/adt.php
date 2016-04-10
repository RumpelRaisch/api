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

if (true === isset($_GET['handle'])) {
    $sHandle = $_GET['handle'];
}

// see: https://github.com/RumpelRaisch/Raisch.git
require_once dirname(dirname(dirname(__DIR__))) . DIRECTORY_SEPARATOR . 'lib'
                                                . DIRECTORY_SEPARATOR . 'Raisch'
                                                . DIRECTORY_SEPARATOR . 'Raisch.php';

require_once __DIR__ . DIRECTORY_SEPARATOR . 'php' . DIRECTORY_SEPARATOR . 'AdtAbilityInfosMapper.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'php' . DIRECTORY_SEPARATOR . 'AdtAbilityInfosModel.php';

$oDatabase = new Database('sqlite:ff_adt.sqlite3', null, null);
$oLogger   = new Logger(__DIR__ . DIRECTORY_SEPARATOR . 'log' . DIRECTORY_SEPARATOR . 'AdtAbilityInfos_exception_log.' . date('Y\_W', time()) . '.txt');

try {
    $oAdtAbilityInfos = new AdtAbilityInfosMapper($oDatabase);
    $oAdtAbilityInfos->injectILogger($oLogger);

    switch ($sHandle) {
        case 'json':
            header('Content-type: application/json; charset=utf-8');

            $sRawData = file_get_contents("php://input");
            $aRawData = json_decode($sRawData, true);
            $bCheck   = isset(
                $aRawData['ability_id'],
                $aRawData['ability_icon_id'],
                $aRawData['ability_name'],
                $aRawData['ability_event'],
                $aRawData['ability_reports_duration']
            );

            if ($bCheck and 5 === count($aRawData)) {
                $oAdtAbilityInfos->insert(new AdtAbilityInfosModel($aRawData));

                print '{}';
            } else {
                $aAbilities = $oAdtAbilityInfos->fetchAll();
                $sJson      = '';

                foreach ($aAbilities as $oAbility) {
                    $sJson .= $oAbility->getJson() . ',';
                }

                print '[' . substr($sJson, 0, -1) . ']';
            }
            break;

        case 'html':
            $aAbilities = $oAdtAbilityInfos->fetchAll();

            include __DIR__ . DIRECTORY_SEPARATOR . 'tpl' . DIRECTORY_SEPARATOR . 'table.php';
            break;

        case 'lua':
            Debug::getInstance()->echoPrintRInPre($oAdtAbilityInfos->getLuaAbilityInfos());
            break;

        default:
            print '{}';
    }
} catch (Exception $oEx) {
    $oLogger->log(print_r($oEx, true));

    print '{}';
}
