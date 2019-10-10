<?php declare(strict_types = 1);

namespace System\Helpers;

defined('BASEPATH') || exit('Direct access is forbidden');

\System\Core\third_party('Whip');

use Exception;

final class IP extends \Vectorface\Whip\Whip{

    /**
     *
     * @return mixed
     */
    final public function generate_new(){

        if(($clientAddress = $this->getValidIpAddress()) === false){
            return '::1';
        }

        return $this->getValidIpAddress();

    }

}