<?php

/*
    Copyright (c) 2012, Open Source Solutions Limited, Dublin, Ireland
    All rights reserved.

    Contact: Barry O'Donovan - barry (at) opensolutions (dot) ie
             http://www.opensolutions.ie/

    This file is part of the OSS_SNMP package.

        Redistribution and use in source and binary forms, with or without
    modification, are permitted provided that the following conditions are met:

        * Redistributions of source code must retain the above copyright
          notice, this list of conditions and the following disclaimer.
        * Redistributions in binary form must reproduce the above copyright
          notice, this list of conditions and the following disclaimer in the
          documentation and/or other materials provided with the distribution.
        * Neither the name of Open Source Solutions Limited nor the
          names of its contributors may be used to endorse or promote products
          derived from this software without specific prior written permission.

    THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
    ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
    WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
    DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY
    DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
    (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
    LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
    ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
    (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
    SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*/

namespace OSS_SNMP\MIBS;

/**
 * A class for performing SNMP V2 queries on Cisco devices
 *
 * @copyright Copyright (c) 2012, Open Source Solutions Limited, Dublin, Ireland
 * @author Sergio Gómez <sergio@uco.es>
 */
class EtherLike extends \OSS_SNMP\MIB
{
    const OID_ETHERLIKE_DUPLEX_STATUS = '.1.3.6.1.2.1.10.7.2.1.19';

    /**
     * Constant for possible value of interface duplex status.
     * @see duplexStatus()
     */
    const ETHERLIKE_DUPLEX_STATUS_UNKNOWN = 1;
    /**
     * Constant for possible value of interface duplex status.
     * @see duplexStatus()
     */
    const ETHERLIKE_DUPLEX_STATUS_HALF_DUPLEX = 2;
    /**
     * Constant for possible value of interface duplex status.
     * @see duplexStatus()
     */
    const ETHERLIKE_DUPLEX_STATUS_FULL_DUPLEX = 3;

    /**
     * Text representation of interface duplex status.
     *
     * @see duplexStatus()
     * @var array Text representations of interface duplex status.
     */
    public static $ETHERLIKE_DUPLEX_STATUS = [
        self::ETHERLIKE_DUPLEX_STATUS_UNKNOWN => 'unknown',
        self::ETHERLIKE_DUPLEX_STATUS_HALF_DUPLEX => 'halfDuplex',
        self::ETHERLIKE_DUPLEX_STATUS_FULL_DUPLEX => 'fullDuplex',
    ];

    /**
     * Get an array of device interface duplex status (half / full)
     *
     * E.g. the follow SNMP output yields the shown array:
     *
     * .1.3.6.1.2.1.10.7.2.1.19.10128 = INTEGER: unknown(1)
     * .1.3.6.1.2.1.10.7.2.1.19.10129 = INTEGER: halfDuplex(2)
     * ...
     *
     *      [10128] => 1
     *      [10129] => 2
     *
     * @see IF_OPER_STATES
     * @param boolean $translate If true, return the string representation
     * @return array An array of interface duplex status
     */
    public function duplexStatus($translate = false)
    {
        $states = $this->getSNMP()->walk1d( self::OID_ETHERLIKE_DUPLEX_STATUS );

        if( !$translate ) {
            return $states;
        }

        return $this->getSNMP()->translate( $states, self::$ETHERLIKE_DUPLEX_STATUS );
    }
}