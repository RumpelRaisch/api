<?php
/* [namespace]
============================================================================= */

// namespace Namespace[\Subnamespace];

/* [use: namespace classes]
============================================================================= */

use Raisch\Libs\Model\Model;

/* [use: namespace interfaces]
============================================================================= */

// use Namespace[\Subnamespace]\Interface;

/* [use: global classes]
============================================================================= */

// use \GlobalClass;

/* [use: global interfaces]
============================================================================= */

// use \GlobalInterface;

/**
 * In this file the AdtAbilityInfosModel class is defined.
 */

/**
 * Short class description ...
 *
 * @final
 * @author    Rainer Schulz <rainer@bitshifting.de>
 * @link      http://bitshifting.de
 * @copyright 2016 - bitshifting.de
 * @license   CC BY-NC-SA 3.0
 *            - http://creativecommons.org/licenses/by-nc-sa/3.0/
 * @version   1.0.0 09/04/2016 17:43
 */
final class AdtAbilityInfosModel extends Model
{
    /* [class constants]
    ========================================================================= */

    // none yet

    /* [class properties]
    ========================================================================= */

    private $iId                     = 0;
    private $iAbilityId              = 0;
    private $iAbilityIconId          = 0;
    private $sAbilityName            = '';
    private $sAbilityEvent           = '';
    private $iAbilityReportsDuration = 0;
    private $iAbilityUsedByAddon     = 0;

    /* [object properties]
    ========================================================================= */

    // none yet

    /* [Constructor and Destructor]
    ========================================================================= */

    // none yet

    /* [magical methods]
    ========================================================================= */

    // none yet

    /* [class methods]
    ========================================================================= */

    // none yet

    /* [object methods]
    ========================================================================= */

    public function getJson()
    {
        return json_encode(
            array(
                'id'                       => $this->iId,
                'ability_id'               => $this->iAbilityId,
                'ability_icon_id'          => $this->iAbilityIconId,
                'ability_name'             => $this->sAbilityName,
                'ability_event'            => $this->sAbilityEvent,
                'ability_reports_duration' => $this->iAbilityReportsDuration,
                'ability_used_by_addon'    => $this->iAbilityUsedByAddon
            )
        );
    }

    /* [Getter and Setter]
    ========================================================================= */

    public function getId()
    {
        return $this->iId;
    }

    public function setId($iId)
    {
        $this->iId = $iId;

        return $this;
    }

    public function getAbilityId()
    {
        return $this->iAbilityId;
    }

    public function setAbilityId($iAbilityId)
    {
        $this->iAbilityId = $iAbilityId;

        return $this;
    }

    public function getAbilityIconId()
    {
        return $this->iAbilityIconId;
    }

    public function setAbilityIconId($iAbilityIconId)
    {
        $this->iAbilityIconId = $iAbilityIconId;

        return $this;
    }

    public function getAbilityName()
    {
        return $this->sAbilityName;
    }

    public function setAbilityName($sAbilityName)
    {
        $this->sAbilityName = $sAbilityName;

        return $this;
    }

    public function getAbilityEvent()
    {
        return $this->sAbilityEvent;
    }

    public function setAbilityEvent($sAbilityEvent)
    {
        $this->sAbilityEvent = $sAbilityEvent;

        return $this;
    }

    public function getAbilityReportsDuration()
    {
        return $this->iAbilityReportsDuration;
    }

    public function setAbilityReportsDuration($iAbilityReportsDuration)
    {
        $this->iAbilityReportsDuration = $iAbilityReportsDuration;

        return $this;
    }

    public function getAbilityUsedByAddon()
    {
        return $this->iAbilityUsedByAddon;
    }

    public function setAbilityUsedByAddon($iAbilityUsedByAddon)
    {
        $this->iAbilityUsedByAddon = $iAbilityUsedByAddon;

        return $this;
    }

    public function getModelMapper()
    {
        // $this->oModelMapper is parent property
        if (null === $this->oModelMapper
            OR false === ($this->oModelMapper instanceof AdtAbilityInfosModelMapper)
        ) {
            $this->injectModelMapper(new AdtAbilityInfosModelMapper());
        }

        return $this->oModelMapper;
    }

    /* [Dependency Injection - (Setter Injection)]
    ========================================================================= */

    // none yet
}
