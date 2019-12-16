<?php

declare(strict_types=1);

/*
 * This file is part of the Zikula package.
 *
 * Copyright Zikula Foundation - https://ziku.la/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zikula\Core\Exception;

use Symfony\Component\ErrorHandler\Error\FatalError as SymfonyFatalErrorException;

/**
 * Class FatalErrorException
 */
class FatalErrorException extends SymfonyFatalErrorException
{
}
