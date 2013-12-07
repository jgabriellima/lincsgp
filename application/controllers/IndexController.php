<?php

class IndexController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
        $this->_session = new Zend_Session_Namespace('session_sgp');
    }

    public function indexAction() {
        // action body
    }

    public function dashboardAction() {
        // action body
        $this->_helper->layout->disableLayout();
    }

    public function projetoAction() {
        // action body
        $this->_helper->layout->disableLayout();
        $this->_session->files = array();
    }

    public function grupoAction() {
        // action body
        $this->_helper->layout->disableLayout();
        $this->_session->files = array();
    }

    public function configuracoesAction() {
        // action body
        $this->_helper->layout->disableLayout();
        $this->_session->files = array();
    }

    public function removerprojetoAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();

        $projeto = new Application_Model_DbTable_Projeto();
        $result = array();
        try {
            $where = $projeto->getAdapter()->quoteInto("idprojeto = ?", $_POST['idprojeto']);
            $projeto->delete($where);
            $result['status'] = "sucesso";
        } catch (Exception $e) {
            $result['status'] = "erro";
            $result['msg'] = $e->getMessage();
        }
        echo Zend_Json::encode($result);
    }

    public function inserirprojetoAction() {
        // action body
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $dados = array();

        $financiador = new Application_Model_DbTable_Financiador();
        $proponente = new Application_Model_DbTable_Proponente();
        $usuarios = new Application_Model_DbTable_Usuarios();
        $projeto = new Application_Model_DbTable_Projeto();
        $anexo = new Application_Model_DbTable_Anexo();


        if ($_POST) {
            $retorno = array();

            try {
                //
                $dados['titulo'] = $_POST['titulo'];
                $dados['apelido'] = $_POST['apelido'];
                $dados['processo'] = $_POST['processo'];
                $dados['edital'] = $_POST['edital'];
                $dados['url'] = $_POST['url'];
                $dados['tipoprojeto'] = $_POST['tipoprojeto'];

                $dados['inicio'] = date("Y-m-d", strtotime(implode("/", array_reverse(explode("/", $_POST['inicio'])))));
                $dados['termino'] = date("Y-m-d", strtotime(implode("/", array_reverse(explode("/", $_POST['termino'])))));

                $dados['resumo'] = $_POST['resumo'];
                $dados['valor'] = $_POST['valor'];
                $dados['proponente_idproponente'] = $_POST['proponente'];
                $dados['financiador_idfinanciador'] = $_POST['financiador'];

                if (!empty($_POST['coordenador'])) {
                    //busca o id do coordenador
                    try {
                        $select = $usuarios->select()->where("nome = ?", $_POST['coordenador']);
                        $u = $usuarios->fetchAll($select);
                        $dados['usuarios_idcoordenador'] = $u[0]["idusuarios"];
                    } catch (Exception $e) {
                        $d = array();
                        $d['nome'] = $_POST['coordenador'];
                        $iduser = $usuarios->insert($d);
                        $dados['usuarios_idcoordenador'] = $iduser;
                    }
                }
                $usuarios = new Application_Model_DbTable_Usuarios();
                //bsuca o id do coordenador tecnico
                if (!empty($_POST['coordenadortecnicos'])) {
                    try {
                        $select = $usuarios->select()->where("nome = ?", $_POST['coordenadortecnicos']);
                        $u = $usuarios->fetchAll($select);
                        $dados['usuarios_idtecnico'] = $u[0]["idusuarios"];
                    } catch (Exception $e) {
                        $d = array();
                        $d['nome'] = $_POST['coordenadortecnicos'];
                        $iduser = $usuarios->insert($d);
                        $dados['usuarios_idtecnico'] = $iduser;
                    }
                }
                //
                try {
                    $idprojeto = $projeto->insert($dados);

                    $rubrica = new Application_Model_DbTable_Rubrica();
                    $repasses = Zend_Json::decode($_POST['repasses']);
                    $planotrabalho = Zend_Json::decode($_POST['planotrabalho']);
                    //
                    $repasse = new Application_Model_DbTable_Repasses();
                    foreach ($repasses as $key => $value) {
                        $dados = array();
                        $dados['datarepasse'] = $value['datarepasse'];
                        $dados['valorrepasse'] = $value['valorrepasse'];
                        $dados['projeto_idprojeto'] = $idprojeto;
                        $repasse->insert($dados);
                    }

                    //
                    $planot = new Application_Model_DbTable_PlanoTrabalho();
                    foreach ($planotrabalho as $key => $value) {
                        $rub = $value['rubrica'];
                        $select = $rubrica->select()->where("tiporubrica = ?", $rub);
                        $rub = $rubrica->fetchAll($select);
                        //
                        $dados = array();
                        $dados['rubrica_idrubrica'] = $rub[0]["idrubrica"];
                        $dados['valor_planotrabalho'] = $value['valor'];
                        $dados['projeto_idprojeto'] = $idprojeto;
                        $planot->insert($dados);
                    }

                    foreach ($this->_session->files as $key => $value) {

                        $dados = array();
                        $dados['filename'] = $value['filename'];
                        $dados['filetype'] = $value['type'];
                        $dados['size'] = $value['size'];
                        $dados['path'] = $value['path'];
                        $dados['projeto_idprojeto'] = $idprojeto;

                        $anexo->insert($dados);
                    }
                    $this->_session->files = array();

                    $retorno['status'] = 'sucesso';
                    echo Zend_Json::encode($retorno);
                } catch (Exception $e) {
                    $retorno['status'] = 'erro';
                    $retorno['erro'] = $e->getMessage();
                    echo Zend_Json::encode($retorno);
                }
            } catch (Exception $e) {
                $retorno['status'] = 'erro';
                $retorno['erro'] = $e->getMessage();
                echo Zend_Json::encode($retorno);
            }
        }
    }

    public function atualizarprojetoAction() {
        // action body
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $dados = array();

        $financiador = new Application_Model_DbTable_Financiador();
        $proponente = new Application_Model_DbTable_Proponente();
        $usuarios = new Application_Model_DbTable_Usuarios();
        $projeto = new Application_Model_DbTable_Projeto();
        $anexo = new Application_Model_DbTable_Anexo();

        if ($_POST) {
            $retorno = array();

            try {
                //
                $dados['titulo'] = $_POST['titulo'];
                $dados['apelido'] = $_POST['apelido'];
                $dados['processo'] = $_POST['processo'];
                $dados['edital'] = $_POST['edital'];
                $dados['url'] = $_POST['url'];
                $dados['tipoprojeto'] = $_POST['tipoprojeto'];
                //
                $dados['inicio'] = date("Y-m-d", strtotime(implode("/", array_reverse(explode("/", $_POST['inicio'])))));
                $dados['termino'] = date("Y-m-d", strtotime(implode("/", array_reverse(explode("/", $_POST['termino'])))));
                //
                $dados['resumo'] = $_POST['resumo'];
                $dados['valor'] = $_POST['valor'];
                if (!empty($_POST['proponente'])) {
                    $dados['proponente_idproponente'] = $_POST['proponente'];
                }
                if (!empty($_POST['financiador'])) {
                    $dados['financiador_idfinanciador'] = $_POST['financiador'];
                }

                if (!empty($_POST['coordenador'])) {
                    //busca o id do coordenador
                    try {
                        $select = $usuarios->select()->where("nome = ?", $_POST['coordenador']);
                        $u = $usuarios->fetchAll($select);
                        $dados['usuarios_idcoordenador'] = $u[0]["idusuarios"];
                    } catch (Exception $e) {
                        $d = array();
                        $d['nome'] = $_POST['coordenador'];
                        $iduser = $usuarios->insert($d);
                        $dados['usuarios_idcoordenador'] = $iduser;
                    }
                }
                $usuarios = new Application_Model_DbTable_Usuarios();
                //bsuca o id do coordenador tecnico
                if (!empty($_POST['coordenadortecnicos'])) {
                    try {
                        $select = $usuarios->select()->where("nome = ?", $_POST['coordenadortecnicos']);
                        $u = $usuarios->fetchAll($select);
                        $dados['usuarios_idtecnico'] = $u[0]["idusuarios"];
                    } catch (Exception $e) {
                        $d = array();
                        $d['nome'] = $_POST['coordenadortecnicos'];
                        $iduser = $usuarios->insert($d);
                        $dados['usuarios_idtecnico'] = $iduser;
                    }
                }
                //
                try {
                    $where = $projeto->getAdapter()->quoteInto("idprojeto = ?", $_POST['idprojeto']);
                    $projeto->update($dados, $where);
                    //
                    $rubrica = new Application_Model_DbTable_Rubrica();
                    $repasses = Zend_Json::decode($_POST['repasses']);
                    $planotrabalho = Zend_Json::decode($_POST['planotrabalho']);
                    //
                    $repasse = new Application_Model_DbTable_Repasses();
                    //deleta todos os repasses do projeto
                    $where = $repasse->getAdapter()->quoteInto("projeto_idprojeto = ?", $_POST['idprojeto']);
                    $repasse->delete($where);
                    //adiciona os repasses do projeto
                    foreach ($repasses as $key => $value) {
                        $dados = array();
                        $dados['datarepasse'] = $value['datarepasse'];
                        $dados['valorrepasse'] = $value['valorrepasse'];
                        $dados['projeto_idprojeto'] = $_POST['idprojeto'];
                        $repasse->insert($dados);
                    }
                    //
                    $planot = new Application_Model_DbTable_PlanoTrabalho();
                    //deleta todos os planos de trabalho dos projetos
                    $where = $planot->getAdapter()->quoteInto("projeto_idprojeto = ?", $_POST['idprojeto']);
                    $planot->delete($where);
                    //adiciona os planos de trabalho do projeto
                    foreach ($planotrabalho as $key => $value) {
                        $rub = $value['rubrica'];
                        $select = $rubrica->select()->where("tiporubrica = ?", $rub);
                        $rub = $rubrica->fetchAll($select);
                        //
                        $dados = array();
                        $dados['rubrica_idrubrica'] = $rub[0]["idrubrica"];
                        $dados['valor_planotrabalho'] = $value['valor'];
                        $dados['projeto_idprojeto'] = $_POST['idprojeto'];
                        $planot->insert($dados);
                    }
//                    foreach ($this->_session->files as $key => $value) {
//
//                        $dados = array();
//                        $dados['filename'] = $value['filename'];
//                        $dados['filetype'] = $value['type'];
//                        $dados['size'] = $value['size'];
//                        $dados['path'] = $value['path'];
//                        $dados['projeto_idprojeto'] = $idprojeto;
//
//                        $anexo->insert($dados);
//                    }

                    $this->_session->files = array();

                    $retorno['status'] = 'sucesso';
                    echo Zend_Json::encode($retorno);
                } catch (Exception $e) {
                    $retorno['status'] = 'erro';
                    $retorno['erro'] = $e->getMessage();
                    echo Zend_Json::encode($retorno);
                }
            } catch (Exception $e) {
                $retorno['status'] = 'erro';
                $retorno['erro'] = $e->getMessage();
                echo Zend_Json::encode($retorno);
            }
        }
    }

    public function getorcamentoAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();

        $repasses = new Application_Model_DbTable_Repasses();
        $planotrabalho = new Application_Model_DbTable_PlanoTrabalho();
        //  
        $db = $planotrabalho->getDefaultAdapter();
        $sql = "SELECT
                planotrabalho.valor_planotrabalho AS valor,
                rubrica.tiporubrica AS rubrica
                FROM planotrabalho 
                left join rubrica on planotrabalho.rubrica_idrubrica = rubrica.idrubrica
                where projeto_idprojeto=" . $_GET['projeto'];
        $planotrabalho = $db->fetchAll($sql);
        // 
        $db = $repasses->getDefaultAdapter();
        $sql = "SELECT
                repasses.datarepasse,
                repasses.valorrepasse
                FROM
                repasses
                where repasses.projeto_idprojeto=" . $_GET['projeto'];
        $repasses = $db->fetchAll($sql);
        $data = array();
        $data['planotrabalho'] = $planotrabalho;
        $data['repasses'] = $repasses;
        echo Zend_Json::encode($data);
    }

    public function projetolistAction() {
        // action body
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        //
        $projeto = new Application_Model_DbTable_Projeto();
        $db = $projeto->getDefaultAdapter();
        //
        $data = array();
        $data["sEcho"] = (int) $_GET["sEcho"];
        $iColumns = $_GET["iColumns"];
        $iDisplayLength = $_GET["iDisplayLength"];
        $iDisplayStart = $_GET["iDisplayStart"];
        $search = $_GET["sSearch"];
        //
        $sql = 'select * from (select `proponente`.nome as `proponente`, `financiador`.nome as `financiador`,`projeto`.*,`usuarios_coordenador`.nome as `coordenador`, `usuarios_coordenadortecnico`.nome as `coordenador_tecnico` from `projeto` as `projeto` inner join `financiador` as `financiador` on financiador.idfinanciador = projeto.financiador_idfinanciador LEFT JOIN `proponente` as `proponente` on proponente.idproponente = projeto.proponente_idproponente left join `usuarios` as `usuarios_coordenador` on projeto.usuarios_idtecnico = usuarios_coordenador.idusuarios
            LEFT JOIN `usuarios` as `usuarios_coordenadortecnico` on projeto.usuarios_idtecnico = usuarios_coordenadortecnico.idusuarios ) as u';
        //
        $data["iTotalRecords"] = sizeof($db->fetchAll($sql));
        if (isset($search) && $search != "") {
            $sql.=' where ';
            for ($i = 0; $i < $iColumns; $i++) {
                $campo = $_GET["mDataProp_" . $i];
                $sql.=' ' . $campo . ' like \'%' . $search . '%\' ';
                if ($i < $iColumns - 1) {
                    $sql.=' or ';
                }
            }
            $data["iTotalDisplayRecords"] = sizeof($db->fetchAll($sql)); //->count();
        } else {
            $data["iTotalDisplayRecords"] = $data["iTotalRecords"];
        }
        $sql.=' limit ' . $iDisplayStart . ',' . $iDisplayLength;
        try {
            $data["aaData"] = $db->fetchAll($sql);
        } catch (Exception $exc) {
            $data["aaData"] = array();
        }
        echo Zend_Json::encode($data);
    }

    public function relatorioAction() {
        // action body
        $this->_helper->layout->disableLayout();
    }

    public function agendaAction() {
        // action body
        $this->_helper->layout->disableLayout();
    }

    public function faqAction() {
        // action body
        $this->_helper->layout->disableLayout();
    }

    public function atasAction() {
        // action body
        $this->_helper->layout->disableLayout();
    }

    public function inseriratasAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $atas = new Application_Model_DbTable_Atas();
        $retorno = array();

        if ($_POST) {
            try {

                $data = array();

                $data['pauta'] = $_POST['pauta'];
                $data['conteudo'] = $_POST['conteudo'];
                $data['observacao'] = $_POST['observacao'];
                //
                $data['datacriacao'] = $_POST['datacriacao'];
                $data['datafechamento'] = $data['datacriacao'];
                $data['ultimaalteracao'] = $data['datacriacao'];
                $data['assunto'] = $_POST['assunto'];
                $data['membrosexternos'] = $_POST['membrosexternos'];
                $data['palavraschaves'] = $_POST['palavraschaves'];
                $data['duracao'] = $_POST['duracao'];
                //
                $ata = $atas->insert($data);

                $user_atas = new Application_Model_DbTable_UsuariosAtas();
                $i = false;
                foreach (array_keys($_POST) as $key => $value) {
                    if (Abstract_Util::startsWith($value, '_u')) {
                        $data = array();
                        $data['usuarios_idusuarios'] = $_POST[$value];
                        $data['atas_idata'] = $ata;
                        if ($_POST[$value] == $this->_session->usuario->idusuarios) {
                            $data['criador'] = 1;
                            $i = true;
                        } else {
                            $data['criador'] = 0;
                        }
                        $user_atas->insert($data);
                    }
                }
                if (!$i) {
                    $data['usuarios_idusuarios'] = $this->_session->usuario->idusuarios;
                    $data['atas_idata'] = $ata;
                    $data['criador'] = 1;
                    $user_atas->insert($data);
                }

                $retorno['status'] = 'sucesso';
            } catch (Exception $e) {
                $retorno['status'] = 'erro';
                $retorno['erro'] = $e->getMessage();
            }
        }
        echo Zend_Json::encode($retorno);
    }

    public function atualizaratasAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $atas = new Application_Model_DbTable_Atas();
        $retorno = array();

        if ($_POST) {
            try {

                $data = array();

                $data['pauta'] = $_POST['pauta'];
                $data['conteudo'] = $_POST['conteudo'];
                $data['observacao'] = $_POST['observacao'];
                //
                $data['ultimaalteracao'] = date('Y-m-d');
                $data['assunto'] = $_POST['assunto'];
                $data['membrosexternos'] = $_POST['membrosexternos'];
                $data['palavraschaves'] = $_POST['palavraschaves'];
                $data['duracao'] = $_POST['duracao'];
                //
                $where = $atas->getAdapter()->quoteInto("idata = ?", $_POST['idata']);
                $atas->update($data, $where);

//                $user_atas = new Application_Model_DbTable_UsuariosAtas();
//                $i = false;
//                foreach (array_keys($_POST) as $key => $value) {
//                    if (Abstract_Util::startsWith($value, '_u')) {
//                        $data = array();
//                        $data['usuarios_idusuarios'] = $_POST[$value];
//                        $data['atas_idata'] = $ata;
//                        if ($_POST[$value] == $this->_session->usuario->idusuarios) {
//                            $data['criador'] = 1;
//                            $i = true;
//                        } else {
//                            $data['criador'] = 0;
//                        }
//                        $user_atas->insert($data);
//                    }
//                }
//                if (!$i) {
//                    $data['usuarios_idusuarios'] = $this->_session->usuario->idusuarios;
//                    $data['atas_idata'] = $ata;
//                    $data['criador'] = 1;
//                    $user_atas->insert($data);
//                }

                $retorno['status'] = 'sucesso';
            } catch (Exception $e) {
                $retorno['status'] = 'erro';
                $retorno['erro'] = $e->getMessage();
            }
        }
        echo Zend_Json::encode($retorno);
    }

    public function buscaratasAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();

        $atas = new Application_Model_DbTable_Atas();
        $db = $atas->getDefaultAdapter();
        $sql = "SELECT * FROM(SELECT
                usuarios.idusuarios,
                usuarios.nome,
                usuarios.email,
                usuarios.username,
                usuarios_atas.usuarios_idusuarios,
                usuarios_atas.atas_idata,
                usuarios_atas.criador,
                usuarios_atas.idusuarioatas,
                atas.idata,
                atas.datacriacao,
                atas.datafechamento,
                atas.datareabertura,
                atas.conteudo,
                atas.membrosexternos,
                atas.duracao,
                atas.palavraschaves,
                atas.observacao,
                atas.ultimaalteracao,
                atas.urlgoogledocs,
                atas.pauta,
                atas.assunto,
                usuarios.facebook
                FROM
                usuarios
                INNER JOIN usuarios_atas ON usuarios.idusuarios = usuarios_atas.usuarios_idusuarios
                INNER JOIN atas ON usuarios_atas.atas_idata = atas.idata
                where usuarios_atas.criador = 1) as u
            ";
//        $sql.=' where idata like %' . $_GET['search'] . '%';
//        $sql.=' or where datacriacao like %' . $_GET['search'] . '%';
//        $sql.=' or where datafechamento like %' . $_GET['search'] . '%';
        $sql.=' where nome like \'%' . $_GET['search'] . '%\'';
        $sql.=' or  email like \'%' . $_GET['search'] . '%\'';
        $sql.=' or  conteudo like \'%' . $_GET['search'] . '%\'';
        $sql.=' or  membrosexternos like \'%' . $_GET['search'] . '%\'';
        $sql.=' or  duracao like \'%' . $_GET['search'] . '%\'';
        $sql.=' or  palavraschaves like \'%' . $_GET['search'] . '%\'';
        $sql.=' or  observacao like \'%' . $_GET['search'] . '%\'';
        $sql.=' or  ultimaalteracao like \'%' . $_GET['search'] . '%\'';
        $sql.=' or  pauta like \'%' . $_GET['search'] . '%\'';
        $sql.=' or  assunto like \'%' . $_GET['search'] . '%\'';

        $retorno = array();
        $retorno['atas'] = $db->fetchAll($sql);

        echo Zend_Json::encode($retorno);
    }

    public function getuserbyatasAction() {
        // action body
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();

        $atas = new Application_Model_DbTable_Atas();
        $db = $atas->getDefaultAdapter();
        $sql = "SELECT
            usuarios.idusuarios,
            usuarios.nome,
            usuarios_atas.atas_idata
            FROM
            usuarios
            INNER JOIN usuarios_atas ON usuarios.idusuarios = usuarios_atas.usuarios_idusuarios
            where usuarios_atas.atas_idata = '" . $_GET['idatas'] . "'";

        echo Zend_Json::encode($db->fetchAll($sql));
    }

    public function atasjsonAction() {
        // action body
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();

        $atas = new Application_Model_DbTable_Atas();
        $db = $atas->getDefaultAdapter();
        $sql = "SELECT
                usuarios.idusuarios,
                usuarios.nome,
                usuarios.email,
                usuarios.username,
                usuarios_atas.usuarios_idusuarios,
                usuarios_atas.atas_idata,
                usuarios_atas.criador,
                usuarios_atas.idusuarioatas,
                atas.idata,
                atas.datacriacao,
                atas.datafechamento,
                atas.datareabertura,
                atas.conteudo,
                atas.membrosexternos,
                atas.duracao,
                atas.palavraschaves,
                atas.observacao,
                atas.ultimaalteracao,
                atas.urlgoogledocs,
                atas.pauta,
                atas.assunto,
                usuarios.facebook
                FROM
                usuarios
                INNER JOIN usuarios_atas ON usuarios.idusuarios = usuarios_atas.usuarios_idusuarios
                INNER JOIN atas ON usuarios_atas.atas_idata = atas.idata
                where usuarios_atas.criador = 1
            ";

        $retorno = array();
        $retorno['atas'] = $db->fetchAll($sql);

        echo Zend_Json::encode($retorno);
    }

    public function faqjsonAction() {
        // action body
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        /**
         */
        $faq = new Application_Model_DbTable_Faq();
        $data = array();
        $data['faqs'] = $faq->fetchAll()->toArray();
        echo Zend_Json::encode($data);
    }

    public function inserirfaqAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();

        $faq = new Application_Model_DbTable_Faq();
        $data = array();
        if ($_POST) {
            $dados = array();
            $dados['pergunta'] = $_POST['pergunta'];
            $dados['resposta'] = $_POST['resposta'];
            try {
                $dados['usuarios_idusuarios'] = $this->_session->usuario->idusuarios;
            } catch (Exception $e) {
                
            }
            $faq->insert($dados);
            try {
                $data['faqs'] = $faq->fetchAll()->toArray();
            } catch (Exception $e) {
                $data['faqs'] = array();
            }
            echo Zend_Json::encode($data);
        }
    }

    public function usuariosAction() {
        // action body
        $this->_helper->layout->disableLayout();
    }

    public function updateusuariosAction() {
        // action body
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();

        $usuarios = new Application_Model_DbTable_Usuarios();
        $retorno = array();
        if ($_POST) {
            try {

                $dados = array();
                if ($_POST['laboratorio_idlaboratorio'] != "") {
                    $dados['laboratorio_idlaboratorio'] = $_POST['laboratorio_idlaboratorio'];
                }
                if ($_POST['vinculo_idvinculo'] != "") {
                    $dados['vinculo_idvinculo'] = $_POST['vinculo_idvinculo'];
                }
                $dados['perfil'] = $_POST['perfil'];
                $dados['status'] = 1;
                $where = $usuarios->getAdapter()->quoteInto("idusuarios = ?", $_POST['idusuarios']);
                $usuarios->update($dados, $where);
                //
                $retorno['status'] = 'sucesso';
            } catch (Exception $e) {
                $retorno['status'] = 'erro';
                $retorno['erro'] = $e->getMessage();
            }
        }
        echo Zend_Json::encode($retorno);
    }

    public function financiadorjsonAction() {
        //        if ($this->_request->isXmlHttpRequest()) {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        /**
         */
        $financiador = new Application_Model_DbTable_Financiador();
        $select = $financiador->select();
        echo Zend_Json::encode($financiador->fetchAll()->toArray());
    }

    public function insertfinanciadorAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $financiador = new Application_Model_DbTable_Financiador();

        if ($_POST) {
            $dados = array();
            $dados['nome'] = $_POST['nome'];
            $financiador->insert($dados);
            $select = $financiador->select();
            $financiador = $financiador->fetchAll($select)->toArray();
            echo Zend_Json::encode($financiador);
        } else {
            echo "erro";
        }
    }

    public function rubricajsonAction() {
        //        if ($this->_request->isXmlHttpRequest()) {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        /**
         */
        $rubrica = new Application_Model_DbTable_Rubrica();
        echo Zend_Json::encode($rubrica->fetchAll()->toArray());
    }

    public function insertrubricaAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $rubrica = new Application_Model_DbTable_Rubrica();

        if ($_POST) {
            $dados = array();
            $dados['tiporubrica'] = $_POST['tiporubrica'];
            $rubrica->insert($dados);
            $rubrica = $rubrica->fetchAll()->toArray();
            echo Zend_Json::encode($rubrica);
        } else {
            echo Zend_Json::encode(array());
        }
    }

    public function insertproponenteAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();

        $proponente = new Application_Model_DbTable_Proponente();

        if ($_POST) {
            $dados = array();
            $dados['nome'] = $_POST['nome'];
            $proponente->insert($dados);
            $select = $proponente->select();
            $proponente = $proponente->fetchAll($select)->toArray();
            echo Zend_Json::encode($proponente);
        } else {
            echo "erro";
        }
    }

    public function proponentejsonAction() {
        //        if ($this->_request->isXmlHttpRequest()) {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        /**
         */
        $proponente = new Application_Model_DbTable_Proponente();
        echo Zend_Json::encode($proponente->fetchAll()->toArray());
    }

    public function usuariolistAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        //
        $usuarios = new Application_Model_DbTable_Usuarios();
        $db = $usuarios->getDefaultAdapter();
        //
        $data = array();
        $data["sEcho"] = (int) $_GET["sEcho"];
        $iColumns = $_GET["iColumns"];
        $iDisplayLength = $_GET["iDisplayLength"];
        $iDisplayStart = $_GET["iDisplayStart"];
        $search = $_GET["sSearch"];
        $search_0 = $_GET["sSearch_0"];
        //
        $sql = "select * from(SELECT
                vinculo.idvinculo,
                vinculo.vinculo,
                usuarios.idusuarios,
                usuarios.nome,
                usuarios.email,
                usuarios.senha,
                usuarios.perfil,
                usuarios.facebook,
                usuarios.first_name,
                usuarios.last_name,
                usuarios.gender,
                usuarios.idfacebook,
                usuarios.updated_time,
                usuarios.username,
                usuarios.`status`,
                usuarios.laboratorio_idlaboratorio,
                usuarios.vinculo_idvinculo,
                laboratorio.idlaboratorio,
                laboratorio.laboratorio,
                laboratorio.sigla,
                laboratorio.coordenador
                FROM
                usuarios
                LEFT JOIN vinculo ON usuarios.vinculo_idvinculo = vinculo.idvinculo
                LEFT JOIN laboratorio ON usuarios.laboratorio_idlaboratorio = laboratorio.idlaboratorio
                ) as u
            ";
        //
        if (isset($search_0) && $search_0 != "") {
            $sql.=' where status="' . $search_0 . '"';

            if ($search_0 == "-1") {
                $sql.=' or email is null';
            }
        }
        $data["iTotalRecords"] = sizeof($db->fetchAll($sql));
        if (isset($search) && $search != "") {
            if (isset($search_0) && $search_0 != "") {
                $sql.=' and ';
            } else {
                $sql.=' where ';
            }
            for ($i = 0; $i < $iColumns; $i++) {
                $campo = $_GET["mDataProp_" . $i];
                $sql.=' ' . $campo . ' like \'%' . $search . '%\' ';
                if ($i < $iColumns - 1) {
                    $sql.=' or ';
                }
            }
            $data["iTotalDisplayRecords"] = sizeof($db->fetchAll($sql)); //->count();
        } else {
            $data["iTotalDisplayRecords"] = $data["iTotalRecords"];
        }
        $sql.=' limit ' . $iDisplayStart . ',' . $iDisplayLength;
        try {
            $data["aaData"] = $db->fetchAll($sql);
        } catch (Exception $exc) {
            $data["aaData"] = array();
        }

        echo Zend_Json::encode($data);
    }

    public function usuariosjsonAction() {
        //        if ($this->_request->isXmlHttpRequest()) {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $usuarios = new Application_Model_DbTable_Usuarios();
        $data = array();
        $data['query'] = $_GET['query'];

        $select = $usuarios->select();
        $select->where('nome like ?', '%' . $_GET['query'] . '%');
        $nomes = array();
        foreach ($usuarios->fetchAll($select)->toArray() as $key => $value) {
            $nomes[] = $value['nome'];
        }
        $data['suggestions'] = $nomes;

        echo Zend_Json::encode($data);
    }

    public function idusuariosjsonAction() {
        //        if ($this->_request->isXmlHttpRequest()) {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $usuarios = new Application_Model_DbTable_Usuarios();
        $db = $usuarios->getDefaultAdapter();
        $sql = "SELECT
                usuarios.nome,
                usuarios.idusuarios
                FROM
                usuarios
                ";
        echo Zend_Json::encode($db->fetchAll($sql));
    }

    public function currentuserAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $user = array();
        $user['usuario'] = $this->_session->usuario->nome;
        $user['perfil'] = $this->_session->usuario->perfil;
        $user['username'] = $this->_session->usuario->username;
        echo Zend_Json::encode($user);
    }

    public function userprofileAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $user = array();
        $user['idusuarios'] = $this->_session->usuario->idusuarios;
        $user['usuario'] = $this->_session->usuario->nome;
        $user['perfil'] = $this->_session->usuario->perfil;
        $user['username'] = $this->_session->usuario->username;

        $usuario = new Application_Model_DbTable_Usuarios();
        $select = $usuario->select()->where("status = ?", "0");

        $lista = $usuario->fetchAll($select);
        $user['countuser'] = $lista->count();
        $user['usuarios'] = $lista->toArray();

        echo Zend_Json::encode($user);
    }

    public function currentprojetoAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();

        $projeto = new Application_Model_DbTable_Projeto();
        $select = $projeto->select()->where("idprojeto = ?", $_GET['idprojeto']);

        $result = $projeto->fetchRow($select)->toArray();

        $usuario = new Application_Model_DbTable_Usuarios();
        $select = $usuario->select()->where("idusuarios = ?", $result["usuarios_idcoordenador"]);

        $result["coordenador"] = $usuario->fetchRow($select)->nome;

        echo Zend_Json::encode($result);
    }

    public function rubricaslistAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();

        $rubrica = new Application_Model_DbTable_Rubrica();
        $select = $rubrica->select()->order($rubrica);
        $rubrica = $rubrica->fetchAll($select)->toArray();

        echo Zend_Json::encode($rubrica);
    }

    public function sairAction() {
        // action body
    }

    public function laboratoriojsonAction() {
        //        if ($this->_request->isXmlHttpRequest()) {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        /**
         */
        $laboratorio = new Application_Model_DbTable_Laboratorio();
        $select = $laboratorio->select()->order(array('laboratorio ASC'));
        echo Zend_Json::encode($laboratorio->fetchAll($select)->toArray());
    }

    public function insertlaboratorioAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $laboratorio = new Application_Model_DbTable_Laboratorio();

        if ($_POST) {
            $dados = array();
            $dados['laboratorio'] = $_POST['laboratorio'];
            $laboratorio->insert($dados);
            //
            $laboratorio = $laboratorio->fetchAll()->toArray();
            echo Zend_Json::encode($laboratorio);
        } else {
            echo Zend_Json::encode(array());
        }
    }

    public function vinculojsonAction() {
        //        if ($this->_request->isXmlHttpRequest()) {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        /**
         */
        $vinculo = new Application_Model_DbTable_Vinculo();
        echo Zend_Json::encode($vinculo->fetchAll()->toArray());
    }

    public function insertvinculoAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $vinculo = new Application_Model_DbTable_Vinculo();

        if ($_POST) {
            $dados = array();
            $dados['vinculo'] = $_POST['vinculo'];
            $vinculo->insert($dados);
            //
            $vinculo = $vinculo->fetchAll()->toArray();
            echo Zend_Json::encode($vinculo);
        } else {
            echo Zend_Json::encode(array());
        }
    }

    public function uploadAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $retorno = array();
        if (isset($_FILES['myfile'])) {
            try {
                $sFileName = $_FILES['myfile']['name'];
                $sFileType = $_FILES['myfile']['type'];
                $sFileSize = $this->bytesToSize1024($_FILES['myfile']['size'], 1);
                move_uploaded_file($_FILES['myfile']['tmp_name'], UPLOAD_PATH . "/" . $_FILES['myfile']['name']);
                if (!isset($this->_session->files)) {
                    $this->_session->files = array();
                }
                $d = array();
                $d['filename'] = $sFileName;
                $d['path'] = UPLOAD_PATH . "/" . $sFileName;
                $d['relativepath'] = "./public/uploads/" . $sFileName;
                $d['type'] = $sFileType;
                $d['size'] = $sFileSize;
                $this->_session->files[] = $d;
                $retorno['status'] = 'sucesso';
                $retorno['dados'] = $this->_session->files;
            } catch (Exception $e) {
                $retorno['status'] = 'erro';
                $retorno['erro'] = $e;
            }
        } else {
            $retorno['status'] = 'erro';
            $retorno['erro'] = 'dados nao enviados';
        }
        //
        echo Zend_Json::encode($retorno);
    }

    public function uploadfilesAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        if (!isset($this->_session->files)) {
            $this->_session->files = array();
        }
        $data = array();
        try {
            $data["sEcho"] = (int) $_GET["sEcho"];
            $data["iTotalRecords"] = sizeof($this->_session->files);
            $data["iTotalDisplayRecords"] = $data["iTotalRecords"];
            $data["aaData"] = $this->_session->files;
            echo Zend_Json::encode($data);
        } catch (Exception $e) {
            $data["aaData"] = array();
            echo Zend_Json::encode($data);
        }
    }

    public function listarubricasAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $rubricas = new Application_Model_DbTable_Rubrica();
        $data = array();
        try {
            $result = $rubricas->fetchAll();
            $data["sEcho"] = (int) $_GET["sEcho"];
            $data["iTotalRecords"] = $result->count();
            $data["iTotalDisplayRecords"] = $data["iTotalRecords"];
            $data["aaData"] = $result->toArray();
            echo Zend_Json::encode($data);
        } catch (Exception $e) {
            $data["aaData"] = array();
            echo Zend_Json::encode($data);
        }
    }

    public function listarubricasbyprojetoAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $planotrabalho = new Application_Model_DbTable_PlanoTrabalho();
        $data = array();
        try {
            $db = $planotrabalho->getDefaultAdapter();
            $sql = "SELECT
                    rubrica.idrubrica,
                    rubrica.tiporubrica
                    FROM
                    planotrabalho
                    INNER JOIN rubrica ON planotrabalho.rubrica_idrubrica = rubrica.idrubrica
                    where planotrabalho.projeto_idprojeto =  '" . $_GET['idprojeto'] . "'";
            $data = $db->fetchAll($sql);
            echo Zend_Json::encode($data);
        } catch (Exception $e) {
            $data = array();
            echo Zend_Json::encode($data);
        }
    }

    public function inserircampoAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();

        $campo = new Application_Model_DbTable_Campo();
        $result = array();
        try {
            $dados = array();
            $dados['label'] = $_POST['nome'];
            $dados['tipo'] = $_POST['tipo'];
            $dados['nome'] = strtolower(str_replace(" ", "", $this->trataTxt($dados['label'])));
            //
            $idcampo = $campo->insert($dados);
            $result['status'] = "sucesso";
            $result['campo'] = $idcampo;
        } catch (Exception $e) {
            $result['status'] = "erro";
            $result['msg'] = $e->getMessage();
        }
        echo Zend_Json::encode($result);
    }

    public function removercamporubricaAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $rubricacampo = new Application_Model_DbTable_RubicaCampo();
        $result = array();
        try {

            $where = $rubricacampo->getAdapter()->quoteInto("idrubricacampo = ?", $_POST['idrubricacampo']);
            $rubricacampo->delete($where);

            $result['status'] = "sucesso";
        } catch (Exception $e) {
            $result['status'] = "erro";
            $result['msg'] = $e->getMessage();
        }
        echo Zend_Json::encode($result);
    }

    public function removerrubricaAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $rubrica = new Application_Model_DbTable_Rubrica();
        $result = array();
        try {

            $where = $rubrica->getAdapter()->quoteInto("idrubrica = ?", $_POST['idrubrica']);
            $rubrica->delete($where);

            $result['status'] = "sucesso";
        } catch (Exception $e) {
            $result['status'] = "erro";
            $result['msg'] = $e->getMessage();
        }
        echo Zend_Json::encode($result);
    }

    public function inserircamporubricaAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();

        $rubricacampo = new Application_Model_DbTable_RubicaCampo();
        $result = array();
        try {
            $dados = array();
            $dados['rubrica_idrubrica'] = $_POST['idrubrica'];
            $dados['campo_idcampo'] = $_POST['idcampo'];
            $dados['obrigatorio'] = $_POST['tipo'];
            $dados['mask'] = $_POST['mask'];
            $dados['validator'] = $_POST['validator'];
            $dados['placeholder'] = $_POST['placeholder'];
            //
            $rubricacampo->insert($dados);
            $result['status'] = "sucesso";
        } catch (Exception $e) {
            $result['status'] = "erro";
            $result['msg'] = $e->getMessage();
        }
        echo Zend_Json::encode($result);
    }

    public function getcamposAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $campo = new Application_Model_DbTable_Campo();
        echo Zend_Json::encode($campo->fetchAll()->toArray());
    }

    public function listacamposrubricaAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $campo = new Application_Model_DbTable_Campo();
        $data = array();
        try {

            $data["sEcho"] = (int) $_GET["sEcho"];
            $rubrica = $_GET['rubrica'];

            if (!isset($rubrica) || empty($rubrica)) {
                $data["iTotalRecords"] = 0;
                $data["aaData"] = array();
            } else {
                $db = $campo->getDefaultAdapter();
                $sql = "SELECT
                        campo.nome,
                        campo.label,
                        campo.tipo,
                        rubrica.idrubrica,
                        campo.idcampo,
                        rubrica_campo.obrigatorio,
                        rubrica_campo.mask,
                        rubrica_campo.validator,
                        rubrica_campo.placeholder,
                        rubrica_campo.idrubricacampo
                        FROM
                        rubrica_campo
                        INNER JOIN rubrica ON rubrica.idrubrica = rubrica_campo.rubrica_idrubrica
                        INNER JOIN campo ON rubrica_campo.campo_idcampo = campo.idcampo
                        where rubrica.idrubrica = " . $rubrica;
                $result = $db->fetchAll($sql);
                $data["aaData"] = $result;
                $data["iTotalRecords"] = sizeof($result);
            }
            $data["iTotalDisplayRecords"] = $data["iTotalRecords"];
            echo Zend_Json::encode($data);
        } catch (Exception $e) {
            $data["aaData"] = array();
            echo Zend_Json::encode($data);
        }
    }

    public function listacamposrubricatemplateAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $campo = new Application_Model_DbTable_Campo();
        $data = array();
        try {
            $db = $campo->getDefaultAdapter();
            $sql = "SELECT
                        campo.label,
                        campo.tipo,
                        rubrica.idrubrica,
                        campo.idcampo,
                        rubrica_campo.idrubricacampo
                        FROM
                        rubrica_campo
                        INNER JOIN rubrica ON rubrica.idrubrica = rubrica_campo.rubrica_idrubrica
                        INNER JOIN campo ON rubrica_campo.campo_idcampo = campo.idcampo where rubrica.idrubrica = " . $_GET['rubrica'];
            $result = $db->fetchAll($sql);
            $data["campos"] = $result;
        } catch (Exception $e) {
            $data["campos"] = array();
        }
        echo Zend_Json::encode($data);
    }

    public function inserirdespesaAction() {

        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();

        $despesarubricacampo = new Application_Model_DbTable_DespesaRubricaCampo();
        $despesa = new Application_Model_DbTable_Despesa();

        $retorno = array();
        try {

            $repetir = intval($_POST['repetir']);

            for ($index = 0; $index < $repetir; $index++) {
                $dados = array();
                $dados['data_criacao'] = date('Y-m-d');
                $dados['projeto_idprojeto'] = $_POST['idprojeto'];
                $iddespesa = $despesa->insert($dados);
                //
                foreach (array_keys($_POST) as $key => $value) {
                    if ($value != 'idprojeto' && $value != 'repetir') {
                        $dados = array();
                        $dados['despesa_iddespesa'] = $iddespesa;
                        $dados['rubrica_campo_idrubricacampo'] = $value;
                        $dados['valor'] = $_POST[$value];
                        $despesarubricacampo->insert($dados);
                    }
                }
            }
            $retorno['status'] = "sucesso";
        } catch (Exception $e) {
            $retorno['status'] = "erro";
            $retorno['msg'] = $e->getMessage();
        }
        echo Zend_Json::encode($retorno);
    }

    public function deletefilesAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        if (!isset($this->_session->files)) {
            $this->_session->files = array();
        }
        try {
            if ($_POST) {
                unset($this->_session->files[$_POST['row']]);
                $dd = array();
                foreach ($this->_session->files as $key => $value) {
                    $dd[] = $value;
                }
                $this->_session->files = $dd;
            }
        } catch (Exception $e) {
            
        }
    }

    public function bytesToSize1024($bytes, $precision = 2) {
        $unit = array('B', 'KB', 'MB');
        return @round($bytes / pow(1024, ($i = floor(log($bytes, 1024)))), $precision) . ' ' . $unit[$i];
    }

    public function testeAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();

        foreach ($this->_session->files as $key => $value) {
            echo $key . ' - ' . $value['filename'] . ' | ';
        }
    }

    public function orcamentogeralAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();

        $despesa = new Application_Model_DbTable_Despesa();
        $db = $despesa->getDefaultAdapter();
        $sql = "SELECT
        Replace(
        Replace(
        Replace(
        Format(SUM(Replace(Replace(planotrabalho.valor_planotrabalho,'.',''),',','.')),2), '.', '|'), ',', '.'), '|', ',') AS planotrabalho,
        Replace(
        Replace(
        Replace(Format(SUM(Replace(Replace(despesa_rubrica_campo.valor,'.',''),',','.')),2), '.', '|'), ',', '.'), '|', ',') AS despesas,
        Replace(
        Replace(
        Replace(Format(SUM(Replace(Replace(planotrabalho.valor_planotrabalho,'.',''),',','.')) - SUM(Replace(Replace(despesa_rubrica_campo.valor,'.',''),',','.')),2), '.', '|'), ',', '.'), '|', ',') as disponivel
	FROM
	despesa
	INNER JOIN projeto ON projeto.idprojeto = despesa.projeto_idprojeto
	INNER JOIN despesa_rubrica_campo ON despesa_rubrica_campo.despesa_iddespesa = despesa.iddespesa
	INNER JOIN rubrica_campo ON rubrica_campo.idrubricacampo = despesa_rubrica_campo.rubrica_campo_idrubricacampo
	INNER JOIN rubrica ON rubrica.idrubrica = rubrica_campo.rubrica_idrubrica
	INNER JOIN campo ON campo.idcampo = rubrica_campo.campo_idcampo
	INNER JOIN planotrabalho ON rubrica_campo.rubrica_idrubrica = planotrabalho.rubrica_idrubrica AND planotrabalho.projeto_idprojeto = projeto.idprojeto
	where rubrica_campo.validator = 'money'
";
        $data = array();
        try {
            $data = $db->fetchAll($sql);
        } catch (Exception $e) {
            
        }
        echo Zend_Json::encode($data);
    }

    public function despesageralAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();

        $planotrabalho = new Application_Model_DbTable_PlanoTrabalho();

        $db = $planotrabalho->getDefaultAdapter();
        $sql = "SELECT
                rubrica.tiporubrica,
                planotrabalho.valor_planotrabalho,
                despesa_rubrica_campo.valor,
                rubrica_campo.validator,
                rubrica.idrubrica,
                planotrabalho.projeto_idprojeto
                FROM
                planotrabalho
                LEFT JOIN rubrica ON planotrabalho.rubrica_idrubrica = rubrica.idrubrica
                LEFT JOIN rubrica_campo ON planotrabalho.rubrica_idrubrica = rubrica_campo.rubrica_idrubrica
                LEFT JOIN despesa ON planotrabalho.projeto_idprojeto = despesa.projeto_idprojeto
                LEFT JOIN despesa_rubrica_campo ON despesa_rubrica_campo.despesa_iddespesa = despesa.iddespesa AND rubrica_campo.idrubricacampo = despesa_rubrica_campo.rubrica_campo_idrubricacampo
                LEFT JOIN projeto ON planotrabalho.projeto_idprojeto = projeto.idprojeto
                where projeto.idprojeto = '" . $_GET['idprojeto'] . "' order by rubrica.tiporubrica
                ";
        $result = $db->fetchAll($sql);
        $dados = array();
        foreach ($result as $key => $value) {
            $dados[$value['tiporubrica']]['rubrica'] = $value['tiporubrica'];
            $dados[$value['tiporubrica']]['total'] = $value['valor_planotrabalho'];
            $dados[$value['tiporubrica']]['idrubrica'] = $value['idrubrica'];
            $dados[$value['tiporubrica']]['projeto_idprojeto'] = $value['projeto_idprojeto'];
            //
            if ($value['validator'] == 'money') {
                $v = str_replace(".", "", $value['valor']);
                $v = str_replace(",", ".", $v);

                if (array_key_exists($value['tiporubrica'], $dados)) {
                    $valor = str_replace(".", "", $dados[$value['tiporubrica']]['gasto']);
                    $dados[$value['tiporubrica']]['gasto'] = number_format($valor + $v, 2, ",", ".");
                } else {
                    $dados[$value['tiporubrica']]['gasto'] = $v;
                }
                $total = str_replace(".", "", $dados[$value['tiporubrica']]['total']);
                $total = str_replace(",", ".", $total);
                $gasto = str_replace(".", "", $dados[$value['tiporubrica']]['gasto']);
                $gasto = str_replace(",", ".", $gasto);

                $disponivel = ($total - $gasto);
                $dados[$value['tiporubrica']]['disponivel'] = number_format($disponivel, 2, ",", ".");
            } else {
                if (!isset($dados[$value['tiporubrica']]['gasto'])) {
                    $dados[$value['tiporubrica']]['gasto'] = '0,00';
                }
                $dados[$value['tiporubrica']]['disponivel'] = $dados[$value['tiporubrica']]['total'];
            }
        }

        $resultado = array();
        foreach ($dados as $key => $value) {
            $resultado[] = $value;
        }
//        var_dump($resultado);
        $data = array();
        try {
            $data["sEcho"] = (int) $_GET["sEcho"];
            $data["iTotalRecords"] = sizeof($resultado);
            $data["iTotalDisplayRecords"] = $data["iTotalRecords"];
            $data["aaData"] = $resultado;
        } catch (Exception $e) {
            $data["aaData"] = array();
        }
        echo Zend_Json::encode($data);
//        foreach ($dados as $key => $value) {
//            echo $value[$key] .'<br/>';
//        }
    }

    public function xdespesageralAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();

        $planotrabalho = new Application_Model_DbTable_PlanoTrabalho();
        $db = $planotrabalho->getDefaultAdapter();
        $sql = "SELECT
	rubrica.tiporubrica as rubrica,
	planotrabalho.valor_planotrabalho as total,
        Replace(
        Replace(
        Replace(
        Format(SUM(Replace(Replace(despesa_rubrica_campo.valor,'.',''),',','.')),2), '.', '|'), ',', '.'), '|', ',') AS gasto,
        Replace(
        Replace(
        Replace(
        Format(
        Replace(Replace(planotrabalho.valor_planotrabalho,'.',''),',','.')
        -
        SUM(Replace(Replace(despesa_rubrica_campo.valor,'.',''),',','.'))
        ,2), '.', '|'), ',', '.'), '|', ',') as disponivel,
        rubrica.idrubrica, despesa.projeto_idprojeto
        FROM
        despesa
        INNER JOIN projeto ON projeto.idprojeto = despesa.projeto_idprojeto
        INNER JOIN despesa_rubrica_campo ON despesa_rubrica_campo.despesa_iddespesa = despesa.iddespesa
        INNER JOIN rubrica_campo ON rubrica_campo.idrubricacampo = despesa_rubrica_campo.rubrica_campo_idrubricacampo
        INNER JOIN rubrica ON rubrica.idrubrica = rubrica_campo.rubrica_idrubrica
        INNER JOIN campo ON campo.idcampo = rubrica_campo.campo_idcampo
        INNER JOIN planotrabalho ON rubrica_campo.rubrica_idrubrica = planotrabalho.rubrica_idrubrica AND planotrabalho.projeto_idprojeto = projeto.idprojeto
        where rubrica_campo.validator = \"money\" and projeto.idprojeto = '" . $_GET['idprojeto'] . "' GROUP BY 	rubrica.tiporubrica";
        $data = array();
        try {
            $data["sEcho"] = (int) $_GET["sEcho"];
            $data["iTotalRecords"] = sizeof($db->fetchAll($sql));
            $data["iTotalDisplayRecords"] = $data["iTotalRecords"];
            $data["aaData"] = $db->fetchAll($sql);
        } catch (Exception $e) {
            $data["aaData"] = array();
        }
        echo Zend_Json::encode($data);
    }

    public function getcamposburubricaAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();



        echo Zend_Json::encode($result);
    }

    public function getdespesascamposbyrubricaAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        try {

            $despesa = new Application_Model_DbTable_Despesa();
            $rubrica = new Application_Model_DbTable_Rubrica();

            $saida = array();

            $db = $rubrica->getDefaultAdapter();
            $sql = 'SELECT
                campo.nome,
                campo.label
                FROM
                rubrica
                INNER JOIN rubrica_campo ON rubrica_campo.rubrica_idrubrica = rubrica.idrubrica
                INNER JOIN campo ON rubrica_campo.campo_idcampo = campo.idcampo
                where idrubrica = ' . $_POST['idrubrica'] . ' order by nome
                ';

            $resultado = $db->fetchAll($sql);
            //{ "mData": "nome", "sTitle":"Nome" ,"bSortable":false,"sClass": "center"},
            $result = array();
            foreach ($resultado as $key => $value) {
                $dados = array();
                $dados['mData'] = $value['nome'];
                $dados['sTitle'] = $value['label'];
                $dados['bSortable'] = false;
                $dados['sClass'] = "center";
                $result[] = $dados;
            }
            $saida['campos'] = $result;

            $db = $despesa->getDefaultAdapter();
            $sql = 'SELECT
                    rubrica.idrubrica,
                    rubrica.tiporubrica,
                    campo.idcampo,
                    campo.nome,
                    campo.label,
                    campo.tipo,
                    despesa_rubrica_campo.valor,
                    despesa.iddespesa,
                    despesa.projeto_idprojeto
                    FROM
                    rubrica
                    INNER JOIN rubrica_campo ON rubrica.idrubrica = rubrica_campo.rubrica_idrubrica
                    INNER JOIN despesa_rubrica_campo ON rubrica_campo.idrubricacampo = despesa_rubrica_campo.rubrica_campo_idrubricacampo
                    INNER JOIN campo ON campo.idcampo = rubrica_campo.campo_idcampo
                    INNER JOIN despesa ON despesa.iddespesa = despesa_rubrica_campo.despesa_iddespesa
                    where idrubrica = ' . $_POST['idrubrica'] . ' and projeto_idprojeto = ' . $_POST['projeto_idprojeto'] . '
                    group by valor,iddespesa,nome
                    order by iddespesa,nome
                    ';
            $result = $db->fetchAll($sql);
            $dados = array();
            foreach ($result as $key => $value) {
                $dados[$value['iddespesa']][$value['nome']] = $value['valor'];
            }
            $resultado = array();
            foreach ($dados as $key => $value) {
                $resultado[] = $value;
            }
            $saida['dados'] = $resultado;

            echo Zend_Json::encode($saida);
        } catch (Exception $e) {
            echo $e;
        }
    }

    public function getformdespesasAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $rubricacampo = new Application_Model_DbTable_RubicaCampo();
        $db = $rubricacampo->getDefaultAdapter();

        $sql = "SELECT
              rubrica.idrubrica,
              rubrica.tiporubrica,
              campo.idcampo,
              campo.nome,
              campo.label,
              campo.tipo,
              rubrica_campo.obrigatorio,
                rubrica_campo.mask,
                rubrica_campo.validator,
                rubrica_campo.placeholder
                FROM
                rubrica
                INNER JOIN rubrica_campo ON rubrica.idrubrica = rubrica_campo.rubrica_idrubrica
                INNER JOIN campo ON rubrica_campo.campo_idcampo = campo.idcampo
                ";
    }

    public function orcamentobyprojetoAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        //
        $despesas = new Application_Model_DbTable_Despesas();
        $db = $despesas->getDefaultAdapter();

        $result = array();
        $sql = "SELECT
	rubrica.tiporubrica as rubrica,
	projeto.valor as planotrabalho,
        Replace(
        Replace(
        Replace(
        Format(SUM(Replace(Replace(despesa_rubrica_campo.valor,'.',''),',','.')),2), '.', '|'), ',', '.'), '|', ',') AS despesas,
        Replace(
        Replace(
        Replace(
        Format(
        Replace(Replace(projeto.valor,'.',''),',','.')
        -
        SUM(Replace(Replace(despesa_rubrica_campo.valor,'.',''),',','.'))
        ,2), '.', '|'), ',', '.'), '|', ',') as disponivel,
        rubrica.idrubrica, despesa.projeto_idprojeto
        FROM
        despesa
        INNER JOIN projeto ON projeto.idprojeto = despesa.projeto_idprojeto
        INNER JOIN despesa_rubrica_campo ON despesa_rubrica_campo.despesa_iddespesa = despesa.iddespesa
        INNER JOIN rubrica_campo ON rubrica_campo.idrubricacampo = despesa_rubrica_campo.rubrica_campo_idrubricacampo
        INNER JOIN rubrica ON rubrica.idrubrica = rubrica_campo.rubrica_idrubrica
        INNER JOIN campo ON campo.idcampo = rubrica_campo.campo_idcampo
        INNER JOIN planotrabalho ON rubrica_campo.rubrica_idrubrica = planotrabalho.rubrica_idrubrica AND planotrabalho.projeto_idprojeto = projeto.idprojeto
        where rubrica_campo.validator = \"money\" and projeto.idprojeto = '" . $_GET['idprojeto'] . "'";
        try {
            $result = $db->fetchRow($sql);
            if ($result['planotrabalho'] == null) {
                $result = array();
                $result['planotrabalho'] = $_GET['total'];
                $result['despesas'] = '0,00';
                $result['disponivel'] = $_GET['total'];
            }
        } catch (Exception $e) {
            
        }
        echo Zend_Json::encode($result);
    }

    public function trataTxt($var) {

        $var = strtolower($var);
        $var = preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities($var));

        $array1 = array("á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç"
            , "Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç");
        $array2 = array("a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c"
            , "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C");
        $var = str_replace($array1, $array2, $var);

        return $var;
    }

}

