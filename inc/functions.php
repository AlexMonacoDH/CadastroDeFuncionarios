<?php
	// Definindo uma constante para o nome do arquivo
	define('ARQUIVO','funcionarios.json');

	// Função para validar dados do post
	function errosNoPost(){
		$erros =[];
		if(!isset($_POST['nome']) || $_POST['nome']==''){
			$erros[] = 'errNome';
		}

		if(!isset($_POST['email']) || $_POST['email']==''){
			$erros[] = 'errEmail';
		}

		if(!isset($_POST['senha']) || $_POST['senha']==''){
			$erros[] = 'errSenha';
		}

		if(($_POST['conf']) != $_POST['senha'] && isset($_POST['conf'])){
			$erros[] = 'errConf';
		}

		return $erros;
	}

	// Carregando o conteúdo do arquivo (string json) para uma variável
	function getFuncionarios(){
		$json = file_get_contents(ARQUIVO);
		$funcionarios = json_decode($json,true);
		return $funcionarios;
	}
	
	// Função que adiciona funcionario ao json
	function addFuncionario($nome,$email,$senha){

		// Carregando os funcionarios
		$funcionarios = getFuncionarios();

		// Adicionando um novo funcionario ao array de funcionarios
		$funcionarios[] = [
			'nome' => $nome,
			'email' => $email,
			'senha' => password_hash($senha,PASSWORD_DEFAULT)
		];
		
		// Transformando o array funcionarios numa string json
		$json = json_encode($funcionarios);

		// Salvar a string json no arquivo
		file_put_contents(ARQUIVO,$json); 
    }
    
    //Função para verificar se o login é válido
    function logar($email,$senha){

        //carregar funcionários
        $funcionarios = getFuncionarios();
        
        //procurar o funcionário com o email dado
        $achou = false;
        foreach($funcionarios as $f){
            if($f['email'] == $email){
                $achou = true;
                break;
            }
        }
        if(!$achou){
            return false;
        }
        else{
            $senhaOK = password_verify($senha,$f['senha']);
            return $senhaOK;
        }
    }

?>