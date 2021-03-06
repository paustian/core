<?php

declare(strict_types=1);

/*
 * This file is part of the Zikula package.
 *
 * Copyright Zikula - https://ziku.la/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zikula\Bundle\CoreBundle\Twig\Extension;

use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Zikula\Bundle\CoreBundle\Event\GenericEvent;

class EventDispatcherExtension extends AbstractExtension
{
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    public function __construct(
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('dispatchEvent', [$this, 'dispatchEvent']),
            new TwigFunction('dispatchGenericEvent', [$this, 'dispatchGenericEvent'])
        ];
    }

    /**
     * @param string $name
     * @param array $arguments the arguments, MUST be values only and in the correct order
     */
    public function dispatchEvent(string $name, $arguments = [])
    {
        if (class_exists($name)) {
            $event = new $name(...$arguments);
            $this->eventDispatcher->dispatch($event);

            return $event;
        }

        return null;
    }

    public function dispatchGenericEvent(string $name, GenericEvent $providedEvent = null, $subject = null, array $arguments = [], $data = null)
    {
        $event = $providedEvent ?? new GenericEvent($subject, $arguments, $data);
        $this->eventDispatcher->dispatch($event, $name);

        return $event->getData();
    }
}
