<?php

/**
 * Routes.
 *
 * @copyright Zikula contributors (Zikula)
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @author Zikula contributors <info@ziku.la>.
 * @see https://ziku.la
 * @version Generated by ModuleStudio 1.4.0 (https://modulestudio.de).
 */

declare(strict_types=1);

namespace Zikula\RoutesModule\Menu\Base;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Zikula\Common\Translator\TranslatorInterface;
use Zikula\Common\Translator\TranslatorTrait;
use Zikula\UsersModule\Constant as UsersConstant;
use Zikula\RoutesModule\Entity\RouteEntity;
use Zikula\RoutesModule\RoutesEvents;
use Zikula\RoutesModule\Event\ConfigureItemActionsMenuEvent;
use Zikula\RoutesModule\Helper\EntityDisplayHelper;
use Zikula\RoutesModule\Helper\PermissionHelper;
use Zikula\UsersModule\Api\ApiInterface\CurrentUserApiInterface;

/**
 * Menu builder base class.
 */
class AbstractMenuBuilder
{
    use TranslatorTrait;

    /**
     * @var FactoryInterface
     */
    protected $factory;

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * @var PermissionHelper
     */
    protected $permissionHelper;

    /**
     * @var EntityDisplayHelper
     */
    protected $entityDisplayHelper;

    /**
     * @var CurrentUserApiInterface
     */
    protected $currentUserApi;

    public function __construct(
        TranslatorInterface $translator,
        FactoryInterface $factory,
        EventDispatcherInterface $eventDispatcher,
        RequestStack $requestStack,
        PermissionHelper $permissionHelper,
        EntityDisplayHelper $entityDisplayHelper,
        CurrentUserApiInterface $currentUserApi
    ) {
        $this->setTranslator($translator);
        $this->factory = $factory;
        $this->eventDispatcher = $eventDispatcher;
        $this->requestStack = $requestStack;
        $this->permissionHelper = $permissionHelper;
        $this->entityDisplayHelper = $entityDisplayHelper;
        $this->currentUserApi = $currentUserApi;
    }

    public function setTranslator(TranslatorInterface $translator): void
    {
        $this->translator = $translator;
    }

    /**
     * Builds the item actions menu.
     */
    public function createItemActionsMenu(array $options = []): ItemInterface
    {
        $menu = $this->factory->createItem('itemActions');
        if (!isset($options['entity'], $options['area'], $options['context'])) {
            return $menu;
        }

        $entity = $options['entity'];
        $routeArea = $options['area'];
        $context = $options['context'];
        $menu->setChildrenAttribute('class', 'list-inline item-actions');

        $this->eventDispatcher->dispatch(
            new ConfigureItemActionsMenuEvent($this->factory, $menu, $options),
            RoutesEvents::MENU_ITEMACTIONS_PRE_CONFIGURE
        );

        if ($entity instanceof RouteEntity) {
            $routePrefix = 'zikularoutesmodule_route_';
        
            if ('admin' === $routeArea) {
                $title = $this->__('Preview', 'zikularoutesmodule');
                $previewRouteParameters = $entity->createUrlArgs();
                $previewRouteParameters['preview'] = 1;
                $menu->addChild($title, [
                    'route' => $routePrefix . 'display',
                    'routeParameters' => $previewRouteParameters
                ]);
                $menu[$title]->setLinkAttribute('target', '_blank');
                $menu[$title]->setLinkAttribute(
                    'title',
                    $this->__('Open preview page', 'zikularoutesmodule')
                );
                $menu[$title]->setAttribute('icon', 'fa fa-search-plus');
            }
            if ('display' !== $context) {
                $title = $this->__('Details', 'zikularoutesmodule');
                $menu->addChild($title, [
                    'route' => $routePrefix . $routeArea . 'display',
                    'routeParameters' => $entity->createUrlArgs()
                ]);
                $entityTitle = $this->entityDisplayHelper->getFormattedTitle($entity);
                $menu[$title]->setLinkAttribute(
                    'title',
                    str_replace('"', '', $entityTitle)
                );
                $menu[$title]->setAttribute('icon', 'fa fa-eye');
            }
            if ($this->permissionHelper->mayEdit($entity)) {
                $title = $this->__('Edit', 'zikularoutesmodule');
                $menu->addChild($title, [
                    'route' => $routePrefix . $routeArea . 'edit',
                    'routeParameters' => $entity->createUrlArgs()
                ]);
                $menu[$title]->setLinkAttribute(
                    'title',
                    $this->__('Edit this route', 'zikularoutesmodule')
                );
                $menu[$title]->setAttribute('icon', 'fa fa-pencil-square-o');
                $title = $this->__('Reuse', 'zikularoutesmodule');
                $menu->addChild($title, [
                    'route' => $routePrefix . $routeArea . 'edit',
                    'routeParameters' => ['astemplate' => $entity->getKey()]
                ]);
                $menu[$title]->setLinkAttribute(
                    'title',
                    $this->__('Reuse for new route', 'zikularoutesmodule')
                );
                $menu[$title]->setAttribute('icon', 'fa fa-files-o');
            }
            if ('display' === $context) {
                $title = $this->__('Routes list', 'zikularoutesmodule');
                $menu->addChild($title, [
                    'route' => $routePrefix . $routeArea . 'view'
                ]);
                $menu[$title]->setLinkAttribute('title', $title);
                $menu[$title]->setAttribute('icon', 'fa fa-reply');
            }
        }

        $this->eventDispatcher->dispatch(
            new ConfigureItemActionsMenuEvent($this->factory, $menu, $options),
            RoutesEvents::MENU_ITEMACTIONS_POST_CONFIGURE
        );

        return $menu;
    }
}
