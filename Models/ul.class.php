<?php
	class ul implements componente
	{
		public function __construct(private array $elementos = array()){}
		
		public function criar()
		{
			echo "<ul>";
			foreach($this->elementos as $dado)
			{
				$dado->criar();
			}
			
			echo"</ul>";
		}
		public function setElemento($elemento)
		{
			$this->elementos[] = $elemento;
		}
		
	}
?>