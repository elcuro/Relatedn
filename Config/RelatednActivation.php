<?php

/**
 * Relatedn activation
 *
 * Activation class for plugin.
 * This is optional, and is required only if you want to perform tasks when your plugin is activated/deactivated.
 *
 * @package  Croogo
 * @author   Juraj Jancuska <jjancuska at gmail.org>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.croogo.org
 */
class RelatednActivation {

       /**
        * onActivate will be called if this returns true
        *
        * @param  object $controller Controller
        * @return boolean
        */
       public function beforeActivation(Controller $controller) {
              return true;
       }

       /**
        * Called after activating the plugin in ExtensionsPluginsController::admin_toggle()
        *
        * @param object $controller Controller
        * @return void
        */
       public function onActivation(Controller $controller) {
              // ACL: set ACOs with permissions
              $controller->Croogo->addAco('Relatedn'); // ExampleController

       }

       /**
        * onDeactivate will be called if this returns true
        *
        * @param  object $controller Controller
        * @return boolean
        */
       public function beforeDeactivation(Controller $controller) {
              return true;
       }

       /**
        * Called after deactivating the plugin in ExtensionsPluginsController::admin_toggle()
        *
        * @param object $controller Controller
        * @return void
        */
       public function onDeactivation(Controller $controller) {
              // ACL: remove ACOs with permissions
              $controller->Croogo->removeAco('Relatedn'); // ExampleController ACO and it's actions will be removed

       }

}
