<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'AdtAbilityInfosModel.php';
/* [namespace]
============================================================================= */

// namespace Namespace[\Subnamespace];

/* [use: namespace classes]
============================================================================= */

use Raisch\Libs\Database\Database;
use Raisch\Libs\Logger\LoggerContainer;

/* [use: namespace interfaces]
============================================================================= */

use Raisch\Libs\Interfaces\IHasDatabase;
use Raisch\Libs\Interfaces\IHasLogger;
use Raisch\Libs\Interfaces\ILogger;
use Raisch\Libs\Interfaces\IModel;
use Raisch\Libs\Interfaces\IModelMapper;

/* [use: global classes]
============================================================================= */

// use \GlobalClass;

/* [use: global interfaces]
============================================================================= */

// use \GlobalInterface;

/**
 * In this file the AdtAbilityInfosMapper class is defined.
 */

/**
 * This class collects ability infos of the game firefall provided by my
 * addon "Ability Duration Timer":
 *  - http://forums.firefall.com/community/threads/8254722/
 *  - https://github.com/RumpelRaisch/AbilityDurationTimer.git
 *
 * @final
 * @author    Rainer Schulz <rainer@bitshifting.de>
 * @link      http://bitshifting.de
 * @copyright 2016 - bitshifting.de
 * @version   1.0.0 08/04/2016 22:10
 */
final class AdtAbilityInfosMapper implements IModelMapper, IHasDatabase, IHasLogger
{
    /* [class constants]
    ========================================================================= */

    const EOL = "\n";

    /* [class properties]
    ========================================================================= */

    private $oDatabase = null;
    private $oLogger   = null;

    /* [object properties]
    ========================================================================= */

    // none yet

    /* [Constructor and Destructor]
    ========================================================================= */

    /**
     * The Constructor.
     *
     * @access public
     * @param  object $oDatabase instance of Database class
     * @return object AdtAbilityInfosMapper
     *                returns a new object of this class
     */
    public function __construct(Database $oDatabase = null)
    {
        if (null !== $oDatabase) {
            $this->injectDatabase($oDatabase);
        }
    }

    /* [magical methods]
    ========================================================================= */

    // none yet

    /* [class methods]
    ========================================================================= */

    // none yet

    /* [object methods]
    ========================================================================= */
    /**
     * @access public
     * @param  object $oModel instance of class wich implements IModel
     * @return object AdtAbilityInfosMapper
     */
    public function insert(IModel $oModel)
    {
        if (true === $this->exists($oModel)) {
            return $this;
        }

        try {
            $oPrep = $this->oDatabase->prepare(
                "INSERT INTO
                    ability_infos
                    (
                        ability_id,
                        ability_icon_id,
                        ability_name,
                        ability_event,
                        ability_reports_duration
                    ) 
                    VALUES
                    (
                        :ability_id,
                        :ability_icon_id,
                        :ability_name,
                        :ability_event,
                        :ability_reports_duration
                    )
                ;"
            );

            $aExec                             = array();
            $aExec['ability_id']               = $oModel->getAbilityID();
            $aExec['ability_icon_id']          = $oModel->getAbilityIconID();
            $aExec['ability_name']             = $oModel->getAbilityName();
            $aExec['ability_event']            = $oModel->getAbilityEvent();
            $aExec['ability_reports_duration'] = $oModel->getAbilityReportsDuration();

            if (false !== $oPrep) {
                $oPrep->execute($aExec);
            }
        } catch (Exception $oEx) {
            if (true === $this->isInjectedILogger()) {
                $this->oLogger->log(print_r($oEx, true));
            } else {
                throw $oEx;
            }
        }

        return $this;
    }

    public function update(IModel $oModel){}

    public function delete($iId){}

    /**
     * @access private
     * @param  object    $oModel instance of AdtAbilityInfosModel
     * @return bool|null
     */
    public function exists($oModel)
    {
        try {
            if (false === ($oModel instanceof AdtAbilityInfosModel)) {
                throw new InvalidArgumentException('Argument 1 needs to be an instance of AdtAbilityInfosModel.');
            }

            $oPrep = $this->oDatabase->prepare(
                "SELECT
                    COUNT(id) as count
                FROM
                    ability_infos
                WHERE
                    ability_id               = :ability_id
                AND
                    ability_icon_id          = :ability_icon_id
                AND
                    ability_name             = :ability_name
                AND
                    ability_event            = :ability_event
                AND
                    ability_reports_duration = :ability_reports_duration
                ;"
            );

            $aExec                             = array();
            $aExec['ability_id']               = $oModel->getAbilityID();
            $aExec['ability_icon_id']          = $oModel->getAbilityIconID();
            $aExec['ability_name']             = $oModel->getAbilityName();
            $aExec['ability_event']            = $oModel->getAbilityEvent();
            $aExec['ability_reports_duration'] = $oModel->getAbilityReportsDuration();

            if (false === $oPrep
                OR false === $oPrep->execute($aExec)
                OR false === ($aResult = $oPrep->fetch())
            ) {
                return null;
            }

            return (bool) $aResult['count'];
        } catch (Exception $oEx) {
            if (true === $this->isInjectedILogger()) {
                $this->oLogger->log(print_r($oEx, true));
            } else {
                throw $oEx;
            }
        }

        return null;
    }

    public function fetch($iId){}

    /**
     * @access private
     * @return array   array of AdtAbilityInfosModel's
     */
    public function fetchAll()
    {
        try {
            $oPrep = $this->oDatabase->prepare(
                "SELECT
                    id,
                    ability_id,
                    ability_icon_id,
                    ability_name,
                    ability_event,
                    ability_reports_duration
                FROM
                    ability_infos
                ORDER BY
                    ability_name ASC,
                    ability_event ASC
                ;"
            );

            if (false === $oPrep
                OR false === $oPrep->execute()
            ) {
                return array();
            }

            $aResponse = array();

            while (false !== ($aRow = $oPrep->fetch())) {
                $aResponse[] = new AdtAbilityInfosModel($aRow);
            }

            return $aResponse;
        } catch (Exception $oEx) {
            if (true === $this->isInjectedILogger()) {
                $this->oLogger->log(print_r($oEx, true));
            } else {
                throw $oEx;
            }
        }

        return array();
    }

    /**
     * @access private
     * @return object AdtAbilityInfosMapper
     */
    private function createTable()
    {
        try {
            $this->oDatabase->exec(
                "CREATE TABLE IF NOT EXISTS ability_infos(
                    id INTEGER PRIMARY KEY ASC,
                    ability_id INTEGER,
                    ability_icon_id INTEGER,
                    ability_name TEXT,
                    ability_event TEXT,
                    ability_reports_duration INTEGER
                )"
            );
        } catch (Exception $oEx) {
            if (true === $this->isInjectedILogger()) {
                $this->oLogger->log(print_r($oEx, true));
            } else {
                throw $oEx;
            }
        }

        return $this;
    }

    public function getLuaAbilityInfos()
    {
        $sResponse = '';
        $aInfos    = $this->fetchAll();

        $sResponse .= '-- automatically generated by http://php.bitshifting.de/api/firefall.adt.lua (Rumpel: http://forums.firefall.com/community/members/11711321/)' . self::EOL;
        $sResponse .= 'local ABILITY_INFOS = {};' . self::EOL;

        foreach ($aInfos as $oAbility) {
            // if (1 > $oAbility->getAbilityIconId()) {
            //     continue;
            // }

            $sDur = (1 == $oAbility->getAbilityReportsDuration()) ? 'true' : 'false';

            $sResponse .= "ABILITY_INFOS[{$oAbility->getAbilityId()}] = {icon_id = {$oAbility->getAbilityIconId()}, ability_name = \"{$oAbility->getAbilityName()}\", reports_duration = {$sDur}, event = \"{$oAbility->getAbilityEvent()}\"};" . self::EOL;
        }

        return $sResponse;
    }

    /* [Getter and Setter]
    ========================================================================= */

    /**
     * @access public
     * @return object Raisch\Libs\Logger\Logger
     */
    public function getILogger()
    {
        return $this->oLogger;
    }

    /**
     * @access public
     * @return object Raisch\Libs\Database\Database
     */
    public function getDatabase()
    {
        return $this->oDatabase;
    }

    /* [Dependency Injection - (Setter Injection)]
    ========================================================================= */

    /**
     * @access public
     * @return object AdtAbilityInfosMapper
     */
    public function injectDatabase(Database $oDatabase)
    {
        $this->oDatabase = $oDatabase;

        if (true === $this->isInjectedILogger()) {
            if (false === $this->oDatabase->isInjectedILoggerContainer()) {
                $oLoggerContainer = new LoggerContainer();
                $oLoggerContainer->injectAddILogger($this->oLogger);

                $this
                    ->oDatabase
                    ->injectILoggerContainer($oLoggerContainer);
            }
        }

        $this->createTable();

        return $this;
    }

    /**
     * @access public
     * @return bool
     */
    public function isInjectedDatabase()
    {
        return null !== $this->oDatabase;
    }

    /**
     * @access public
     * @return object AdtAbilityInfosMapper
     */
    public function injectILogger(ILogger $oLogger)
    {
        $this->oLogger = $oLogger;

        if (true === $this->isInjectedDatabase()) {
            if (false === $this->oDatabase->isInjectedILoggerContainer()) {
                $oLoggerContainer = new LoggerContainer();

                $this
                    ->oDatabase
                    ->injectILoggerContainer($oLoggerContainer);
            }

            $this->oDatabase->getILoggerContainer()->injectAddILogger($this->oLogger);
        }

        return $this;
    }

    /**
     * @access public
     * @return bool
     */
    public function isInjectedILogger()
    {
        return null !== $this->oLogger;
    }
}
