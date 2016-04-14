<?php
/* [namespace]
============================================================================= */

// namespace Namespace[\Subnamespace];

/* [use: namespace classes]
============================================================================= */

// use Namespace[\Subnamespace]\Class;

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
 * In this file the AdtRoute class is defined.
 */

/**
 * Short class description ...
 *
 * @author    Rainer Schulz <rainer@bitshifting.de>
 * @link      http://bitshifting.de
 * @copyright 2016 - bitshifting.de
 * @license   CC BY-NC-SA 3.0
 *            - http://creativecommons.org/licenses/by-nc-sa/3.0/
 * @version   1.0.0 09/04/2016 17:43
 */
class AdtRoute
{
    /* [class constants]
    ========================================================================= */

    // none yet

    /* [class properties]
    ========================================================================= */

    // none yet

    /* [object properties]
    ========================================================================= */

    private $aRoute   = array();
    private $iCurrent = -1;
    private $iCount   = 0;

    /* [Constructor and Destructor]
    ========================================================================= */

    /**
     * The Constructor.
     *
     * @access public
     * @return object AdtRoute
     *                returns a new object of this class
     */
    public function __construct($sRoute = null)
    {
        if (null !== $sRoute) {
            $this->set($sRoute);
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

    public function next()
    {
        $this->iCurrent++;

        if (false === isset($this->aRoute[$this->iCurrent])) {
            $this->reset();

            return false;
        }

        return true;
    }

    public function current()
    {
        return $this->aRoute[$this->iCurrent];
    }

    private function reset()
    {
        $this->iCurrent = -1;

        return $this;
    }

    public function count()
    {
        return $this->iCount;
    }

    public function exists($sKey)
    {
        return in_array($sKey, $this->aRoute);
    }

    private function add($sKey)
    {
        $this->aRoute[] = $sKey;
        $this->iCount++;

        return $this;
    }

    /* [Getter and Setter]
    ========================================================================= */

    public function set($sRoute)
    {
        $aTmp = explode('/', trim($sRoute, '/'));

        foreach ($aTmp as $sQuery) {
            $this->add($sQuery);
        }

        return $this;
    }

    /* [Dependency Injection - (Setter Injection)]
    ========================================================================= */

    // none yet
}
