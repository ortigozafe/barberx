<?php
	class a implements componente
	{
		public function __construct(private string $rota, private string $texto){}
		
		public function criar()
		{
			echo "<a href='{$this->rota}'>$this->texto</a>";
		}
		
	}
?>