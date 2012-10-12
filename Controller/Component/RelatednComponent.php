<?php

/**
 * Relatedn Component
 *
 *
 * @category Component
 * @package  Croogo
 * @author   Juraj Jancuska <jjancuska at gmail.org>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.croogo.org
 */
class RelatednComponent extends Component {

       /**
        * Called after the Controller::beforeFilter() and before the controller action
        *
        * @param object $controller Controller with components to startup
        * @return void
        */
       public function startup(Controller $controller) {
              
       }

       /**
        * Called after the Controller::beforeRender(), after the view class is loaded, and before the
        * Controller::render()
        *
        * @param object $controller Controller with components to beforeRender
        * @return void
        */
       public function beforeRender(Controller $controller) {

              $this->_actionFallback($controller, __FUNCTION__);
       }

       /**
        * Before callback for view action
        *
        * @param controller controller
        * @return void
        */
       public function beforeRender_view(Controller $controller) {

              $term_nodes = array();
              
              if (isset($controller->viewVars['node']['Taxonomy'])) {
                     $term_slugs = array();
                     $params = array();
                     $term_conditions = array();
                     
                     $params['order'] = array('Node.created DESC');
                     $params['limit'] = 20;

                     $term_slugs = Set::extract('/Term/slug', $controller->viewVars['node']['Taxonomy']);

                     if (count($term_slugs > 0)) {

                            /*$params['cache'] = array(
                                   'prefix' => 'term_related_nodes_' . $controller->viewVars['node']['Node']['slug'],
                                   'config' => 'croogo_nodes',
                            );*/                               
                            foreach ($term_slugs as $slug) {
                                   $term_conditions['OR'][] = array('Node.terms LIKE' => '%"' . $slug . '"%');
                            }                                                                                                            
                            $params['conditions'] = array(
                                   'Node.status' => 1,
                                   'Node.type LIKE' => '%',
                                   $term_conditions,
                                   array('OR' => array(
                                          'Node.visibility_roles' => '',
                                          'Node.visibility_roles LIKE' => '%"' . $controller->Croogo->roleId . '"%'
                                   ))
                            );
                            $controller->Node->type = false; // bypas beforeFind in Node model
                            $term_nodes = $controller->Node->find('all', $params);                            
                     }                            
              }       
              $controller->set('term_related_nodes_for_layout', $term_nodes);       
       }

       /**
        * Called after Controller::render() and before the output is printed to the browser.
        *
        * @param object $controller Controller with components to shutdown
        * @return void
        */
       public function shutdown(Controller $controller) {
              
       }

       /**
        * Custom method by controller action
        * syntax for creation fallback methods e.g. beforeRender_index($controller)
        *
        * @param controller controller
        * @param parentMethod string name of parent component method
        * @return void
        */
       public function _actionFallback(Controller $controller, $parent_method) {

              $method_name = $parent_method . '_' . $controller->request->params['action'];
              if (method_exists(__CLASS__, $method_name)) {
                     $this->$method_name($controller);
              }
       }

}
