<?php

/**
 * IndexController - The default controller class
 * 
 * @author
 * @version 
 */

require_once 'Zend/Controller/Action.php';

class Admin_AgentsController extends Zend_Controller_Action 
{

    public function addAction() 
    {
        $this->_helper->layout->setLayout('agents');
        
        $form = new Form_Agent();
        
        $this->view->form = $form;
        
    } 
}
