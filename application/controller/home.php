<?php

/**
 * Class Home
 * Retrieves information and build home screen
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */
class Home extends Controller
{
    /**
     * PAGE: index
     * This method handles what happens when you move to http://yourproject/home/index (which is the default page btw)
     */
    public function index()
    {
    	session_start();
    	
    	if (isset($_POST['user'])) {
    		$user = $_POST['user'];
    	} else {
    		$user = "";
    	}
    	
    	if (isset($_POST['passwd'])) {
    		$passwd = $_POST['passwd'];
    	} else {
    		$passwd = "";
    	}
    	
    	/**
    	 * trecho de codigo para autenticacao com LDAP IC
    	 * 
    	 * 
    	 * $ldap_con = ldap_connect("ldaps://meta.ic.unicamp.br") or die("ERRO");
ldap_set_option($ldap_con, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($ldap_con, LDAP_OPT_REFERRALS, 0);
$ldap_user = "uid=".$user.",ou=People,dc=lab,dc=ic,dc=unicamp,dc=br";

//string que identifica o usuario
$pass=$_POST["passwd"];

//Busca no LDAP para identificar Nome e Sobrenome
$base = "dc=ic,dc=unicamp,dc=br";
$filter = "(uid=$nome)";
$attributes_ad = array("cn","sn","homedirectory","uid");
$result = ldap_search($ldap_con, $base, $filter, $attributes_ad);
$info = ldap_get_entries($ldap_con, $result);
$firstname = split("[ ]+", $info[0]["cn"][0]);
$lastname = split("[ ]+", $info[0]["sn"][0]);
$homedir = $info[0]["homedirectory"][0];
$grupo = split("/", $homedir);
$grupo = $grupo[2];
$permitir = "allow";

// Teste de grupo exceção
if (preg_match("/^spec/", $grupo)){
    $permitir = "deny";
}

// Testa autenticação + regra de exceção
if(ldap_bind($ldap_con,$ldap_user,$pass) && ($permitir == "allow")){
    $_SESSION['auth_ccid'] = $_POST['ccid'];
                                        $_SESSION['account_number'] = '100041363';
                                        $_SESSION['auth_email'] = $_POST['ccid'];
                                        $_SESSION['last_name'] = $lastname[0];
                                        $_SESSION['first_name'] = $firstname[0];
                                        $_SESSION['academic_statuses'] = 'staff,students,faculty';
                                        session_write_close();
                                }
    	 * 
    	 * 
    	 */
    	
    	//autenticacao dummy enquanto nao passarmos pra intra do IC
    	if (($user != "funcionario" && $passwd != "funcionario123") &&
    		!isset($_SESSION['login']) ) {
    		require APP . 'view/_templates/header.php';
    		require APP . 'view/home/login.php';
    		require APP . 'view/_templates/footer.php';
    	} 
        
        else {
    		$_SESSION['login'] = $user;
    		// create a client instance
    		$client = new Solarium\Client($this->config);
    		
    		// get a select query instance
    		$query = $client->createSelect();
    		
    		// set start and rows param (comparable to SQL limit) using fluent interface
    		$query->setRows(4);
    		
    		$query->addSort('indexingdate_s', $query::SORT_DESC);
    		
    		// this executes the query and returns the result
    		$resultset = $client->select($query);
    		
    		// load views
    		require APP . 'view/_templates/header.php';
    		require APP . 'view/home/index.php';
    		require APP . 'view/_templates/footer.php';
    	}
    }
}
