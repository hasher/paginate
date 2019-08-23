<?php


/**
 * Short description
 *
 * Long and full description
 * 
 * @author 		Judicaël AHYI <judicael.ahyi.pro@gmail.com>
 * @version 	1.0
 * @link 		https://www.github.com/hasher/paginate/
 */
class Paginate {

	/**
	 * @var 	array 	$template 	Collection de modèle pour chaque élément de la pagination
	 */
	private $template;

	/**
	 * @var 	int 	$total 	Total des éléments à afficher sur l'ensemble des pages
	 */
	private $total;

	/**
	 * @var 	int 	$npp 	Nombre d'élément maximal à afficher sur une page
	 */
	private $npp;

	/**
	 * @var 	int 	$lrmpn 	Nombre maximales à gauche et à droite
	 */
	private $lrmpn;

	/**
	 * @var 	string 	$selector 	Paramètre GET servant d'indication pour la page actuelle 
	 */
	private $selector;

	/**
	 * @var 	int 	$limit 	Code SQL à utiliser dans la requête d'affichage de la page en cours
	 */
	public $limit;

	/**
	 * @var 	string 	$pagination 	Code HTML permettant d'afficher la pagination
	 */
	public $pagination;



	/**
	 * 
	 * Definir les paramètres généraux
	 *
	 * @param array $param  Collection de tout les paramètres
	 * @return object
	 */
	public function __construct(array $param) {

		$this->total = $param['total'];
		$this->npp = $param['npp'];
		$this->lrmpn = $param['lrmpn'];
		$this->selector = $param['selector'];

		$this->template = [
			'previous'	=>	$param['previous'],
			'normal'	=>	$param['normal'],
			'active'	=>	$param['active'],
			'next'		=>	$param['next'],
		];

		return $this;

	}


	/**
	 *
	 * @return string
	 */
	public function __toString() {

		$this->_proceed();
		return $this->pagination;

	}


	/**
	 * 
	 * Procédure :: éxécution du script principal 
	 *
	 * @return void
	 */
	private function _proceed():void {

		$selector = $this->selector;

		$pattern = [ 
			"/%page/",
			"/%number/"
		];
		

		if ( isset($_GET[$selector]) && is_numeric($_GET[$selector]) ) {
			$page_number = $_GET[$selector];
		} else {
			$page_number = 1;
		}

		$uri = $this->_uri_formatter($selector);

		$last_page = ceil( $this->total / $this->npp );

		if ( $page_number < 1 ) {
			$page_number = 1;
		} elseif ( $page_number > $last_page ) {
			$page_number = $last_page;
		}

		$this->limit = 'LIMIT ' . ($page_number - 1) * $this->npp . ',' . $this->npp;
		$this->pagination = '';


		if ( $last_page != 1 ) {

			if ( $page_number > 1 ) {

				$previous = $page_number - 1;
				$replacement = [
					($uri . $previous),
					$previous
				];

				$this->pagination .= preg_replace($pattern, $replacement, $this->template['previous']);

				$i = $page_number - $this->lrmpn;

				for ( $i; $i < $page_number; $i++ ) {

					if ( $i > 0 ) {
						$replacement = [
							($uri . $i),
							$i
						];
						$this->pagination .= preg_replace($pattern, $replacement, $this->template['normal']);
					}

				}

			}

			$replacement = [
				($uri . $page_number),
				$page_number
			];
			$this->pagination .= preg_replace($pattern, $replacement , $this->template['active']);

			$i = $page_number + 1;

			for ( $i; $i <= $last_page; $i++ ) {

				$replacement = [
					($uri . $i),
					$i
				];
				$this->pagination .= preg_replace($pattern, $replacement, $this->template['normal']);
				
				if ( $i >= $page_number + $this->lrmpn ){
					break;
				}

			}

			if ( $page_number != $last_page ) {

				$next = $page_number + 1;
				$replacement = [
					($uri . $next),
					$next
				];

				$this->pagination .= preg_replace($pattern, $replacement, $this->template['next']);

			}

		}

	}


	/**
	 * 
	 * Retourne le code SQL ( LIMIT ) de la page actuelle 
	 *
	 * @return string
	 */
	public function limit():string {

		$this->_proceed();
		return $this->limit;

	}


	/**
	 * 
	 * Formate l'URI afin de mieux positionner le séléecteur 
	 *
	 * @return string
	 */
    private function _uri_formatter($target = 'page'):string {

    	$last = '';
    	$uri = '?';

    	if ( count($_GET) > 0 ) {
			$last = $target . '=';
		} else {
			$last = $target . '=';
		}

   		foreach ($_GET as $key => $value) {

   			if ( $key != $target ) {
	   			$uri .= $key . '=' . $value . '&';
   			}

	   	}
		
		$uri .= $last;
		
   		return $uri;
	
    }


}