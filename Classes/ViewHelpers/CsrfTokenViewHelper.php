<?php
declare(strict_types = 1);

namespace LMS\Routes\ViewHelpers;

/* * *************************************************************
 *
 *  Copyright notice
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 * ************************************************************* */

use LMS\Facade\Assist\Str;
use LMS\Facade\Extbase\Registry;
use LMS\Facade\Extbase\User;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\FormProtection\FormProtectionFactory;

/**
 * @author Borulko Sergey <borulkosergey@icloud.com>
 */
class CsrfTokenViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper
{
    public function render(): string
    {
        $user = (string)User::currentUid();
        $action = $this->getActionBasedOnEnv();

        Registry::set('tx_routes', $user, $action);

        return FormProtectionFactory::get()
            ->generateToken('routes', $action, $user);
    }

    private function getActionBasedOnEnv(): string
    {
        if (Environment::getContext()->isProduction()) {
            return Str::random();
        }

        return 'api';
    }
}
