<?php
namespace Lib\Core\Db ;

/**
 * pdo 连接 mysql 数据库
 * Enter description here ...
 * @author lixin
 * @date 2014-05-28
 */
abstract class Dbmysql{

	protected $dsn;
	protected $host;
	protected $port;
	protected $user;
	protected $pwd;
	protected $db;
	protected $charset;
	protected $prefix;
	protected $cacheFolder;

	protected $tableName_c; //缓存的表名
	protected $tableName; //表名
	protected $sql; //查询语句
	protected $fields; //字段

	protected $tableAlias; //~ 别名（用于联表查询，在具体model中定义）
	protected $joinTables; //~ 连接表数组（用于联表查询，在具体model中定义）

	protected $_field='', $_field_join; //_field_join 连接的字段
	protected $_where='';
	protected $_group='';
	protected $_order='';
	protected $_limit='';
	protected $_join='';
	
	private $link = null ;
	
	abstract protected function getName();
	abstract protected function getAlias();

	/**
	 * 构造函数
	 * Enter description here ...
	 * @param unknown_type $tableName
	 * @throws SQLException
	 */
	public function __construct(){
		$this->host=DB_HOST;
		$this->port = DB_PORT;
		$this->user=DB_USER;
		$this->pwd=DB_PWD;
		$this->db=DB_NAME;
		$this->prefix=DB_PREFIX;
		$this->charset = DB_CHARSET;
		$this->cacheFolder=rtrim(DB_CACHE_FOLDER,'/').'/';

		$this->setTableName();

		//尝试连接数据库
		//mysql:host=localhost;port=3307;dbname=testdb
		$this->dsn = 'mysql:host='.$this->host.';port='.$this->port.';dbname='.$this->db;

		try{
			$this->link = new \PDO($this->dsn, $this->user, $this->pwd);
		}catch(\PDOException $e){

			throw new \Lib\Exception\Statement('pdo 数据库连接失败 :'.$e->getMessage());

		}

		$this->query("set names $this->charset");

		$this->getFields();

	}

	/**
	 * 设置数据表名称
	 * Enter description here ...
	 * @param string $tableName 去掉前缀的数据表名称，首次调用自动生成
	 */
	protected function setTableName()
	{
		$this->tableAlias = $this->getAlias();
	
		if(empty($this->tableName_c)){
			$this->tableName_c=$this->getName();
		}
	
		if(!empty($this->_join)){
			$this->tableName=$this->tableName_c.' as '.$this->tableAlias;
		}else{
			$this->tableName=$this->tableName_c;
		}
	
	}

	/**
	 * 设置字段缓存
	 * Enter description here ...
	 * @throws SQLException
	 * @return void|unknown
	 */
	protected function writeFields(){
		$sql="desc ".$this->tableName;
		$result=$this->query($sql);

		foreach($result as $val){
			$field[]=$val['Field'];

			if($val['Key']=='PRI'){
				$field['_pk']=$val['Field'];
			}
			if($val['Extra']=='auto_increment'){
				$field['_auto']=$val['Field'];
			}

		}
		$string="<?php \n return ".var_export($field,true)."\n ?>";

		if(!file_put_contents($this->cacheFolder.$this->tableName.'.php',$string)){
			throw new \Lib\Exception\Statement('设置数据库字段失败,写入文件失败，请检查文件权限');
			return ;
		}

		return $field;
	}

	/**
	 * 获取字段缓存
	 * Enter description here ...
	 */
	protected function getFields(){
		$file=$this->cacheFolder.$this->tableName.'.php';
		if(file_exists($file)){
			$this->fields=include($file);
		}else{
			$this->fields=$this->writeFields();
		}
	}

	/**
	 * 清空条件缓冲
	 * Enter description here ...
	 */
	protected function flushMembers()
	{
	 	$this->_field='';
	 	$this->_where='';
	 	$this->_group='';
	 	$this->_order='';
	 	$this->_limit='';
	 	$this->_join='';
	 	$this->_field_join='';
	}

	/**
	 * 执行查询 select(non-PHPdoc)
	 * @see PDO::query()
	 */
	public function query($sql){
		$this->flushMembers();	//清空条件缓冲
		$this->sql=$sql;
		
		$statement=$this->link->query($sql);
		
		if ($statement === false){
			throw new \Lib\Exception\Statement("SQL ERR " . $sql);
		}
		
		$rowcount = $statement->rowCount();
		
		if ($rowcount <= 0){
			return array();
		}
		
		$result=$statement->fetchAll(\PDO::FETCH_ASSOC);
		
		return $result;
	}

	/**
	 * 执行更新 insert delete update
	 * Enter description here ...
	 * @param $sql
	 */
	public function execute($sql){
		$this->flushMembers();	//清空条件缓冲
		$this->sql=$sql;

		$statement=$this->link->query($sql);
		if(!empty($statement))
			return $statement->rowCount();
		else
			return false;
	}

	/**
	 * 增加
	 * Enter description here ...
	 * @param unknown_type $data
	 */
	public function add($data){
		$realFieldArray=array_intersect($this->fields, array_keys($data));//所有有效字段
		$field=implode(',', $realFieldArray);

		foreach($realFieldArray as $v){
			$values[]="'$data[$v]'";
		}

		$values=implode(',', $values);

		$this->execQueryFilter(); //参数重组
		$sql="insert into $this->tableName($field) values($values)";


		return $this->execute($sql);


	}

	/**
	 * 联表字段
	 * Enter description here ...
	 * @param array $tables
	 * @info 需要连接的表必须已经在所属model中建立了关系
	 * @info join 方法必须在第一个调用
	 * @example $db_user->join(array('userfileds'))->where(***)->order(***)->find()
	 */
	public function join($tables){

		if(empty($tables)){
			return $this;
		}

		foreach($tables as $v){
			$val=$this->joinTables[$v];

			if(empty($val))	continue;
			$this->_join.=" $val[type] join {$this->prefix}$val[table] as $val[alias] on $val[on] ";

			$this->_field_join.=$val['fields'].',';
		}

		$this->_field_join=trim($this->_field_join,',');

		return $this;
	}

	/**
	 * 执行查询过滤，参数重组
	 * Enter description here ...
	 */
	protected function execQueryFilter()
	{
		if(!empty($this->_join)){
			$_fields=explode(',', $this->_field);

			foreach($_fields as $k=>$v){
				$_fields[$k]=$this->tableAlias.'.'.$v;
			}

			$this->_field=implode(',', $_fields).','.$this->_field_join;

		}

		$this->setTableName();
	}

	/**
	 * limit条件
	 * Enter description here ...
	 * @param string $limit （例：10,30）
	 */
	public function limit($limit){
		$this->_limit='limit '.$limit;
		return $this;
	}

	/**
	 * 排序条件
	 * Enter description here ...
	 * @param mixed $order （例：name desc）多个条件使用索引数组
	 */
	public function order($order){
		if(is_array($order)){
			$order=implode(',', $order);
		}
		$this->_order='order by '.$order;
		return $this;
	}

	/**
	 * 分组字段
	 * Enter description here ...
	 * @param string $group （例：tel）
	 */
	public function group($group){
		$this->_group='group by '.$group;
		return $this;
	}

	/**
	 * 设置查寻条件
	 * Enter description here ...
	 * @param mixed $where （例：id=1）多个条件使用索引数组
	 */
	public function where($where){
		if(is_array($where)){
			$where=implode(" and ", $where);
		}
		$this->_where='where '.$where;
		return $this;
	}

	/**
	 * 设置字段
	 * Enter description here ...
	 * @param unknown_type $field
	 */
	public function field($field){
		if(!is_array($field)){
			$field=explode(',', $field);
		}
		$field = $this->trimEach($field);

		$_field=array_intersect($this->fields, array_values($field));//所有有效字段
		$_field=array_unique($_field);
		$this->_field=implode(',', $_field);
		return $this;
	}

	/**
	 * 递归执行去除两边字符串
	 * Enter description here ...
	 * @param mixed $value 需要执行的变量
	 * @param string $char 需要去除的字符
	 */
	private function trimEach($value, $char=' '){
		if(is_array($value)){
			foreach($value as $key=>$val){
				$value[$key] = $this->trimEach($val, $char);
			}
			return $value;
		}else{
			return trim($value, $char);
		}
	}

	/**
	 * 查寻多个
	 * Enter description here ...
	 */
	public function select(){
		if(empty($this->_field)){
			$f=array_unique(array_values($this->fields));
			$this->_field=implode(',', $f);
		}

		$this->execQueryFilter(); //参数重组
		$sql="select $this->_field from $this->tableName $this->_join $this->_where $this->_group $this->_order $this->_limit";

		return $this->query($sql);
	}

	/**
	 * 查寻一个
	 * Enter description here ...
	 */
	public function find(){
		if(empty($this->_field)){
			$f=array_unique(array_values($this->fields));
			$this->_field=implode(',', $f);
		}

		$this->execQueryFilter();
		$sql="select $this->_field from $this->tableName $this->_join $this->_where $this->_group $this->_order $this->_limit";

		$_d=$this->query($sql);

		if(is_array($_d)){
			return $_d[0];
		}
		return $_d;
	}

	/**
	 * 删除指定内容
	 * Enter description here ...
	 * @return boolean|Ambigous <boolean, number>
	 */
	public function del(){
		if(empty($this->_where)){
			trigger_error("企图在没有条件的情况下删除 $this->tableName 表下的内容",E_USER_WARNING);
			return false;
		}
		$this->execQueryFilter(); //参数重组
		$sql="delete from $this->tableName $this->_where $this->_order $this->_limit";
		return $this->execute($sql);
	}

	/**
	 * 更新内容
	 * Enter description here ...
	 * @param unknown_type $data
	 */
	public function update($data){
		if(empty($this->_where)){
			trigger_error("企图在没有条件的情况下更新 $this->tableName 表下的内容",E_USER_WARNING);
			return false;
		}

		$f=array_intersect($this->fields, array_keys($data)); //合法数据
		foreach($f as $v){
			$sets[]="$v='$data[$v]'";
		}
		$sets=implode(',', $sets);

		$this->execQueryFilter(); //参数重组
		$sql="update $this->tableName set $sets $this->_where $this->_order $this->_limit";

		return $this->execute($sql);

	}

	/**
	 * 统计
	 * Enter description here ...
	 * @param unknown_type $filed
	 */
	public function count($filed='*'){

		$this->execQueryFilter();
		$sql="select count($filed) as c from $this->tableName $this->_join $this->_where";

		$_d=$this->query($sql);

		return intval($_d[0]['c']);
	}

	//最大值
	function max(){
		foreach(explode(',', $this->_field) as $v){
			$ms[]="MAX($v) as $v";
		}
		$ms=implode(',', $ms);

		$this->execQueryFilter(); //参数重组
		$sql="select $ms from $this->tableName $this->_where";

		$_d=$this->query($sql);

		return $_d[0];

	}

	//最小值
	function min(){
		foreach(explode(',', $this->_field) as $v){
			$ms[]="MIN($v) as $v";
		}
		$ms=implode(',', $ms);

		$this->execQueryFilter(); //参数重组
		$sql="select $ms from $this->tableName $this->_where";

		$_d=$this->query($sql);

		return $_d[0];
	}

	//平均值
	function avg(){
		foreach(explode(',', $this->_field) as $v){
			$ms[]="AVG($v) as $v";
		}
		$ms=implode(',', $ms);

		$this->execQueryFilter(); //参数重组
		$sql="select $ms from $this->tableName $this->_where";

		$_d=$this->query($sql);

		return $_d[0];
	}

	//求和
	function sum(){
		foreach(explode(',', $this->_field) as $v){
			$ms[]="SUM($v) as $v";
		}
		$ms=implode(',', $ms);

		$this->execQueryFilter(); //参数重组
		$sql="select $ms from $this->tableName $this->_where";

		$_d=$this->query($sql);

		return $_d[0];
	}

	/**
	 * 上次影响id
	 * Enter description here ...
	 */
	public function getLastInsertId(){
		return $this->link->lastInsertId();
	}
	/**
	 * 最后一次sql
	 * Enter description here ...
	 * @throws SQLException
	 */
	public function getLastSql(){
		return $this->sql;
	}

	public function __destruct(){

	}
}
