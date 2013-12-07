<?php

Class Abstract_PluginAuth extends Zend_Controller_Plugin_Abstract {

    private $_auth;
    private $_acl;
    private $_session;
    private $authenticate = true;
    private $authorizate = false;

    // metodo que inicia o objeto
    public function __construct() {
        $this->_auth = Zend_Auth::getInstance();
        $this->_acl = new Zend_Acl();
        $this->_session = new Zend_Session_Namespace('session_sgp');
        
    }

    // metodo chamado a cada requisicao
    public function preDispatch(Zend_Controller_Request_Abstract $request) {

        // pega os recursos requisitados
        $controller = strtolower($request->controller);
        $action = strtolower($request->action);
        $module = $request->module;


        // testa se o controle e acao acessados sao os de login e logout, pois nestes casos nao e necessario estar logado
        if (!($request->controller == "auth"
                && ($request->action == "index" || $request->action == "logout" || $request->action == "sendmail"||$request->action == "loginfb" || $request->action == "login" || $request->action == "recuperarsenhaview" || $request->action == "recuperarsenha"))
        ) {
            /*
             * caso nao seja login nem logout e necessario checar se o usuario esta logado
             * caso nao esteja logado (if verdadeiro), e redirecionado a pagina de login
             */
            if (!$this->_auth->hasIdentity()) {
                $controller = "auth";
                $action = "index";
                $module = "default";
                $this->_session->controller = $request->controller;
                $this->_session->action = $request->action;
                $this->_session->msgtype = "error";
                $this->_session->message = "Voc&ecirc; precisa identificar-se para utilizar o sistema";
            }
        }
        // caso nao caia nas excecoes, o usuario acessa o sistema naturalmente
        $request->setControllerName($controller);
        $request->setActionName($action);
        $request->setModuleName($module);
    }

}
