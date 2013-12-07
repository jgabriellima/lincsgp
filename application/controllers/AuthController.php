<?php

class AuthController extends Zend_Controller_Action {

    public function init() {
        $this->_helper->layout->disableLayout();
        $this->_session = new Zend_Session_Namespace('session_sgp');
    }

    public function indexAction() {
        $this->view->message = $this->_session->message;
    }

    public function loginAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $dados = array();
        if ($this->getRequest()->isPost()) {
            $login = $_POST['username'];
            $senha = $_POST['password'];

            $usuario = new Application_Model_DbTable_Usuarios();
            $select = $usuario->select()->where("email = ?", $login);
            $row = $usuario->fetchRow($select);

            if ($row != null) {
                if ($row->status == 0) {
                    $dados['status'] = 'erro';
                    $dados['result'] = 'Você ainda não possui acesso ao sistema. Tente novamente mais tarde ou contate o administrador pra mais informações: jgabriel.ufpa@gmail.com';
                    $dados['url'] = './auth/index';
                } else {
                    $dbAdapter = Zend_Db_Table::getDefaultAdapter();
                    //Inicia o adaptador Zend_Auth para banco de dados
                    $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);
                    $authAdapter->setTableName('usuarios')
                            ->setIdentityColumn('email')
                            ->setCredentialColumn('senha')
                            ->setCredentialTreatment('MD5(?)');
                    $select = $authAdapter->getDbSelect();
                    $select->where("status = ?", "1");
                    //Define os dados para processar o login
                    $authAdapter->setIdentity($login)
                            ->setCredential($senha);
                    //Efetua o login
                    $auth = Zend_Auth::getInstance();
                    $result = $auth->authenticate($authAdapter);
                    //     
                    if ($result->isValid()) {
                        //Armazena os dados do usuário em sessão, apenas desconsiderando
                        //a senha do usuário
                        $info = $authAdapter->getResultRowObject(null, 'senha');
                        $storage = $auth->getStorage();
                        $storage->write($info);
                        //Redireciona para o Controller protegido
                        $this->_session->usuario = $info;
                        $this->view->currentPage = $this->_session->currentPage = 'index';
                        $this->view->message = $this->_session->message = "";
//		$this -> _session -> usuario -> update($data, "idusuario = " . intval($this -> _session -> usuario -> idusuario));
//              $this->_redirect('/index');
                        //
                $dados['status'] = 'sucesso';
                        $dados['result'] = '';
                        $dados['url'] = './' . $this->view->currentPage;
                        //Dados inválidos
                    } else {
                        $this->view->message = $this->_session->message = 'Usuário ou senha inválidos!';
                        $dados['status'] = 'erro';
                        $dados['result'] = 'Usuário ou senha inválidos!';
                        $dados['url'] = './auth/index';
                    }
//            } else {
//                $this->view->message = $this->_session->message = 'Usuário ou senha inválidos!';
////                $this->_redirect('/auth');
//            }
                }
            } else {
                $this->view->message = $this->_session->message = 'Usuário ou senha inválidos!';
                $dados['status'] = 'erro';
                $dados['result'] = 'Usuário ou senha inválidos!';
                $dados['url'] = './auth/index';
            }
        }
        echo Zend_Json::encode($dados);
    }

    public function loginfbAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();

        $retorno = array();
        if ($_POST) {

            $data = array();
            $data['email'] = $_POST['email'];
            $data['first_name'] = $_POST['first_name'];
            $data['last_name'] = $_POST['last_name'];
            $data['nome'] = $_POST['name'];
            $data['gender'] = $_POST['gender'];
            $data['idfacebook'] = $_POST['id'];
            $data['senha'] = md5($_POST['id']);
            $data['facebook'] = $_POST['link'];
            $data['updated_time'] = $_POST['updated_time'];
            $data['username'] = $_POST['username'];
            $data['perfil'] = 'Membro';

            $usuario = new Application_Model_DbTable_Usuarios();
            $select = $usuario->select()->where("email = ?", $data['email'])->orWhere("nome = ?", $data['nome']);
            $row = $usuario->fetchRow($select);
            // verifica se o usuario ja esta cadastrado no sistema
            if ($row == null) {
                $idusuario = $usuario->insert($data);

                $retorno['status'] = 'erro';
                $retorno['email'] = 1; //mandar email
                $retorno['tipo'] = 0; // email de cadastro
                $retorno['user'] = $idusuario;
                $retorno['result'] = 'Você ainda não possui acesso ao sistema. Tente novamente mais tarde ou contate o administrador pra mais informações: jgabriel.ufpa@gmail.com';
                $retorno['url'] = './auth/index';
            } else {
                if ($row->status == 0) {
                    if ($row->email == null || empty($row->email) || $row->email == '') {
                        $where = $usuario->getAdapter()->quoteInto("idusuarios = ?", $row->idusuarios);
                        $usuario->update($data, $where);
                    }
                    $retorno['status'] = 'erro';
                    $retorno['email'] = 0;
                    $retorno['result'] = 'Você ainda não possui acesso ao sistema. Tente novamente mais tarde ou contate o administrador pra mais informações: jgabriel.ufpa@gmail.com';
                    $retorno['url'] = './auth/index';
                } else {
                    $dbAdapter = Zend_Db_Table::getDefaultAdapter();
                    //Inicia o adaptador Zend_Auth para banco de dados
                    $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);
                    $authAdapter->setTableName('usuarios')
                            ->setIdentityColumn('email')
                            ->setCredentialColumn('senha')
                            ->setCredentialTreatment('MD5(?)');

                    $select = $authAdapter->getDbSelect();
                    $select->where("status = ?", "1");
                    //Define os dados para processar o login
                    $authAdapter->setIdentity($data['email'])
                            ->setCredential($data['idfacebook']);
                    //Efetua o login
                    $auth = Zend_Auth::getInstance();
                    $result = $auth->authenticate($authAdapter);
                    //                
                    if ($result->isValid()) {
                        //Armazena os dados do usuário em sessão, apenas desconsiderando
                        //a senha do usuário
                        $info = $authAdapter->getResultRowObject(null, 'senha');
                        $storage = $auth->getStorage();
                        $storage->write($info);
                        //Redireciona para o Controller protegido
                        $this->_session->usuario = $info;
                        $this->view->currentPage = $this->_session->currentPage = 'index';
                        $this->view->message = $this->_session->message = "";
                        //
                        $retorno['status'] = 'sucesso';
                        $retorno['email'] = 0;
                        $retorno['result'] = '';
                        $retorno['url'] = './' . $this->view->currentPage;
                        //Dados inválidos
                    } else {
                        $this->view->message = $this->_session->message = 'Usuário ou senha inválidos!';
                        $retorno['status'] = 'erro';
                        $retorno['email'] = 0;
                        $retorno['result'] = 'Usuário ou senha inválidos!';
                        $retorno['url'] = './auth/index';
                    }
                }
            }
        }
        echo Zend_Json::encode($retorno);
    }

    public function sendmailAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();

        if ($_POST) {
            try {

                $usuario = new Application_Model_DbTable_Usuarios();
                $select = $usuario->select()->where("idusuarios = ?", $_POST['user']);
                $user = $usuario->fetchRow($select);

                $msg = str_replace("FULANO", $user->nome, Abstract_Email::$MSG_CADASTRO);

                Abstract_Email::send($user->email, $user->nome, Abstract_Email::$ASSUNTO_CADASTRO, $msg);
            } catch (Exception $e) {
                echo $e;
            }
        }
    }

    public function logoutAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $auth = Zend_Auth::getInstance();
        $auth->clearIdentity();
        Zend_Session::destroy();
        //return $this->_helper->redirector->goToRoute(array('controller' => 'auth'), null, true);
        $this->_redirect('/auth');
    }

    public function recuperarsenhaviewAction() {
        $this->_helper->layout->disableLayout();
    }

    public function recuperarsenhaAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        //
        if ($this->getRequest()->isPost()) {
            $daousuario = new Application_Model_DbTable_Usuario();
            $cpf = $_POST['cpf'];
            $email = $_POST['email'];
            //
            $select = $daousuario->select()->where("cpf = ?", $cpf)->where("email = ?", $email);
            $usuario = $daousuario->fetchRow($select);
            if ($usuario != null) {
                //
                $dados = array();
                $dados['senha'] = md5($_POST['senha']);
                //
                $daousuario->update($dados, "idusuario = " . $usuario->idusuario);
                $this->view->message = $this->_session->message = "Sua senha foi alterada com sucesso. Entre com seu e-mail e senha abaixo.";
                echo 'sucesso';
            } else {
                echo 'erro';
            }
        }
    }

}

