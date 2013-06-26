<?php

class ErrorController extends Zend_Controller_Action
{
    public function init ()
    {
        $this->view->layout()->disableLayout();
    }

    public function errorAction()
    {
        $errors = $this->getRequest()->getParam('error_handler');
        $this->view->errors = $errors;
        $this->view->exception = $errors->exception;
    }
}

