<?php

/**
 * Clase Gato, Tic Tac Toe
 *
 * 
 * @package SoapDiscovery
 * @author David Solorzano, Ivan Chavarria
 * @version 1.0
 * @access public
 **/


class Gato {
	private $tablero = array("-", "-", "-", "-", "-", "-", "-", "-", "-"); //Tablero de tic tac toe
	private $recordJugadores;
	private $recordTiempos;
	private $records;
	private $casillasRestantes; //cantidad de casillas disponibles
	private $jugador = ''; //nombre del jugador
	private $resultados; //resultados de la partida

	//Constructor de la clase gato.
	public function __construct() {
		$this->casillasRestantes = 9;
		$this->records = "";
		$this->recordJugadores = array();
		$this->recordTiempos = array();
	}

	//Verifica si la casilla sigue disponible, hay que investigar si esto se puede realizar desde la interfac
	
	
	//Metodo donde se cambia la casilla selecionada en el juego por una 'X'
	public function jugar($casilla){
		$this->tablero[$casilla] = "X";
		$this->casillasRestantes--;

		$this->guardarRecords();
	}
	
	//Metodo que genera el movimiento de la maquina rival o IA
	public function juegaMaquina(){
		
		
		$randomPlay = rand(0,8);
		while(true)//Mientras este ocupad
		{
			if($this->tablero[$randomPlay] != "-")
				$randomPlay = rand(0,8);
			else
				break;		
		}
		$this->tablero[$randomPlay] = "O";
		$this->casillasRestantes--;
		
		return $randomPlay;
	}

	//Metodo que verifica si el jugador ganó
	public function checkWin($casilla,$simbolo){
		$victoria = false;

		//casilla superior izquierda
		if($casilla == 0){
			//Verifica casilla horizontal

			$victoria = $this->checkCasillas(1,2,$simbolo);
			//si no gano, revisar hacia abajo 
			if($victoria === false){
				//vertical
				$victoria = $this->checkCasillas(3,6,$simbolo);
			}
			//En diagonal
			if($victoria === false){
				$victoria = $this->checkCasillas(4,8,$simbolo);	
			}			
		}
		
		//Casilla superior Central
		if($casilla == 1){
			//Verifica horizontal
			$victoria = $this->checkCasillas(0,2,$simbolo);
			//Verifica vertical
			if($victoria === false){
				
				$victoria = $this->checkCasillas(4,7,$simbolo);
			}
		}		

		//Casilla superior Derecha
		if($casilla == 2){
			//Verifica casilla de la izquierda
			$victoria = $this->checkCasillas(1,0,$simbolo);
			
			//si no gano, revisar hacia abajo 
			if($victoria === false){
				$victoria = $this->checkCasillas(5,8,$simbolo);	
			}

			//En diagonal
			if($victoria === false){
				$victoria = $this->checkCasillas(4,6,$simbolo);
			}	
		}

		//casilla central izquierda
		if($casilla == 3){
			//verificar hacia arriba y abajo
			$victoria = $this->checkCasillas(0,6,$simbolo);
			//si no gano, revisar hacia abajo 
			if($victoria === false){
				$victoria = $this->checkCasillas(4,5,$simbolo);	
			}
		}

		//Casilla Central
		if($casilla == 4){
			//verificar hacia arriba y abajo

			$victoria = $this->checkCasillas(1,7,$simbolo);
			
			//Derecha e izquierda
			if($victoria === false){	
				$victoria = $this->checkCasillas(3,5,$simbolo);
			}

			//Diagonal a la derecha
			if($victoria === false){

				$victoria = $this->checkCasillas(6,2,$simbolo);
			}
			
			//Diagonal a la izquierda
			if($victoria === false){
				$victoria = $this->checkCasillas(0,8,$simbolo);	
			}			
		}
		
		//Casilla central derecha
		if($casilla == 5){
			//verificar hacia arriba y abajo
			
			$victoria = $this->checkCasillas(2,8,$simbolo);	
			//si no gano, revisar hacia abajo 
			if($victoria === false){
				$victoria = $this->checkCasillas(4,3,$simbolo);	
			}
		}

		//Casilla inferior izquierda
		if($casilla == 6){
			//verificar hacia arriba 
			$victoria = $this->checkCasillas(3,0,$simbolo);	
			//si no gano, hacia la derecha 
			if($victoria === false){
				$victoria = $this->checkCasillas(7,8,$simbolo);	
			}
			
			//si no gano, revisar en diagonal 
			if($victoria === false){
				$victoria = $this->checkCasillas(4,2,$simbolo);	
			}			
		}
		
		if($casilla == 7){
			//verificar hacia arriba 

			$victoria = $this->checkCasillas(4,1,$simbolo);	
			//si no gano, hacia la derecha e izquierda 
			if($victoria === false){
				$victoria = $this->checkCasillas(6,8,$simbolo);		
			}	
		}
		if($casilla == 8){
			//verificar hacia arriba 
			$victoria = $this->checkCasillas(5,2,$simbolo);	
			//si no gano, hacia la izquierda 
			if($victoria === false){
				$victoria = $this->checkCasillas(7,6,$simbolo);	
			}
			
			//si no gano, revisar en diagonal 
			if($victoria === false){
				$victoria = $this->checkCasillas(4,0,$simbolo);	
			}			
		}
		
		if($victoria){
			$this->reiniciar();
		}
		
		return $victoria; 
	}

	//Metodo que verifica si las casillas contiguas a la seleccionada forma la combinacion necesaria para ganar
	public function checkCasillas($contigua1, $contigua2,$simbolo){
		
		$gano = false;
		if($this->tablero[$contigua1] === $simbolo){
			if($this->tablero[$contigua2] === $simbolo){
				$gano = true;
			}
		}		

		return $gano;
	}

	//Método que devuelve la cantidad de casillas restantes
	public function getCasillasRestantes(){
		if($this->casillasRestantes === 0){
			$this->reiniciar();
			return 0;
		}
		
		return $this->casillasRestantes;
	}
	//Metodo para solicitar el nombre del jugador
	public function setJugador($nombre){
		$this->jugador = $nombre;
	}

	//Metodo que retorna el array que representa el tablero
	public function getBoard(){ //retorna el array 
		return implode($this->tablero);
	}
	
	public function reiniciar($duracion){
		$this->tablero = array("-", "-", "-", "-", "-", "-", "-", "-", "-");
		$this->casillasRestantes = 9;

		if($duracion > 0){
			$this->guardarResultados($duracion);
		}
	}
	
	public function guardarRecords(){
		$fn = fopen("records.txt","r");
		while(! feof($fn))  {
			$result = fgets($fn);
			$temp = explode(":",$result);
			array_push($this->recordJugadores, $temp[0]);
			array_push($this->recordTiempos, $temp[1]);
		}

		fclose($fn);
	}
	
	public function getRecordJugadores(){
		return implode($this->recordJugadores);
	}
	
	public function getRecordTiempos(){
		return implode($this->recordTiempos);
	}

	public function guardarResultados($duracion){
		$tupla = "\n".$this->jugador.':'.$duracion;
        file_put_contents("records.txt", $tupla, FILE_APPEND);

		array_push($this->recordJugadores, $this->jugador);
		array_push($this->recordTiempos, $duracion);
	}

	public function getTop(){
        $file = file("records.txt");
        $this->records = file_get_contents("records.txt");
        return $this->records;
	}
}
?>