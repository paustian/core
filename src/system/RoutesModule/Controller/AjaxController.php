<?php
/**
 * Routes.
 *
 * @copyright Zikula contributors (Zikula)
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @author Zikula contributors <support@zikula.org>.
 * @link http://www.zikula.org
 * @link http://zikula.org
 * @version Generated by ModuleStudio 0.7.0 (http://modulestudio.de).
 */

namespace Zikula\RoutesModule\Controller;

use Zikula\RoutesModule\Controller\Base\AjaxController as BaseAjaxController;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Zikula\Core\Response\Ajax\AjaxResponse;

/**
 * Ajax controller class providing navigation and interaction functionality.
 *
 * @Route("/ajax")
 */
class AjaxController extends BaseAjaxController
{
    /**
     * This method is the default function handling the main area called without defining arguments.
     *
     * @Route("/ajax",
     *        methods = {"GET"}
     * )
     *
     * @param Request  $request      Current request instance
     * @param string  $ot           Treated object type.
     *
     * @return mixed Output.
     *
     * @throws AccessDeniedException Thrown if the user doesn't have required permissions.
     */
    public function indexAction(Request $request)
    {
        return parent::indexAction($request);
    }

    // feel free to add your own controller methods here


    public function sort(Request $request)
    {
        if (!$this->hasPermission($this->name . '::Ajax', '::', ACCESS_EDIT)) {
            return true;
        }

        $objectType = $request->request->getAlnum('ot', 'route');
        $sort = $request->request->get('sort', []);

        foreach ($sort as $position => $id) {
            $id = substr($id, 4);
            $object = $this->entityManager->find($this->name . ':' . ucfirst($objectType) . 'Entity', $id);
            $object->setSort($position);
            $this->entityManager->persist($object);
        }

        $this->entityManager->flush();

        $cacheClearer = $this->get('zikula.cache_clearer');
        $cacheClearer->clear('symfony.routing');

        return new AjaxResponse([]);
    }
}
