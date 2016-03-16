<?php
namespace Lib\Controller\Home ;

class Index extends Base
{
	public function index()
	{
		//$table = M('debug');
		//$qus = $table->select();

		//$res = $qus->fetchAll(PDO::FETCH_ASSOC);
		//var_dump($qus);
		$this->show("index");
	}
}
?>
