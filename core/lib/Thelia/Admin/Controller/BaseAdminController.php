<?php
/*************************************************************************************/
/*                                                                                   */
/*      Thelia	                                                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*	    email : info@thelia.net                                                      */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      This program is free software; you can redistribute it and/or modify         */
/*      it under the terms of the GNU General Public License as published by         */
/*      the Free Software Foundation; either version 3 of the License                */
/*                                                                                   */
/*      This program is distributed in the hope that it will be useful,              */
/*      but WITHOUT ANY WARRANTY; without even the implied warranty of               */
/*      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                */
/*      GNU General Public License for more details.                                 */
/*                                                                                   */
/*      You should have received a copy of the GNU General Public License            */
/*	    along with this program. If not, see <http://www.gnu.org/licenses/>.         */
/*                                                                                   */
/*************************************************************************************/
namespace Thelia\Admin\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Thelia\Admin\Templating\Template;
use Thelia\Core\Template\SmartyParser;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\DependencyInjection\ContainerAware;

/**
 *
 * The defaut administration controller. Basically, display the login form if
 * user is not yet logged in, or back-office home page if the user is logged in.
 *
 * @author Franck Allimant <franck@cqfdev.fr>
 */

class BaseAdminController
{
    protected $parser;

    public function __construct($parser) {

        $this->parser = $parser;

        // FIXME: should be red from config
        $this->parser->setTemplate('admin/default');
    }

    protected function render($templateName, $args = array()) {

        $args = array('lang' => 'fr');

        return $this->parser->render($templateName, $args);
    }

    public function indexAction()
    {
        $resp = new Response();

        $resp->setContent($this->render('login.html'));

        return $resp;
   }
}