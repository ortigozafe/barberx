<?php
	class li implements componente
	{
		public function __construct(private $elemento){}
		
		public function criar()
		{
			echo "<li>";
			$this->elemento->criar();
			echo "</li>";
		}
	}
?>