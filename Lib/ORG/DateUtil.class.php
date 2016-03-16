<?php
/**
 * 日期扩展类
 * Enter description here ...
 * @author lixin
 * @info 主要功能：生成各种日期/时间戳
 */
class DateUtil
{
	
	public static $ONEDAY; //一天的毫秒数
	public static $ONEWEEK; //一周的毫秒数
	public static $unixtime; //本地时间戳
	
	public static function init()
	{
		self::$ONEDAY=24*60*60;
		self::$ONEWEEK=self::$ONEDAY*7;
		
		self::$unixtime= time();
	}
	
	public static function shiftDate($val, $shift){
		return $val*$shift;
	}

	/**
	 * 获取项目统计表格需要的时间值
	 * Enter description here ...
	 * @info 返回时间戳数组
	 * 包括 今天23:59、昨天23:59、前天:23:59
	 * 包括 本周最后一天23:59、上周最后一天23:59、大上周最后一天23:59
	 * 包括 本月最后一天23:59、上月最后一天23:59、大上月最后一天23:59
	 */
	public static function getAppTimestampArray($shift=null)
	{
		$d['now']=time(); //当前时间
		
		$d['today']=DateUtil::getFullDayDate(); //获取到今天 23:59:59 的unix时间戳
		$d['yesterday']=$d['today']-DateUtil::$ONEDAY; //昨天 23:59:59
		$d['yesterday2']=$d['yesterday']-DateUtil::$ONEDAY; //前天 23:59:59
		$d['yesterday3']=$d['yesterday2']-DateUtil::$ONEDAY; //大前天 23:59:59
		
		//周
		$d['thisWeek']=DateUtil::getFullWeekDate();
		$d['lastWeek']=$d['thisWeek']-DateUtil::$ONEWEEK;
		$d['lastWeek2']=$d['lastWeek']-DateUtil::$ONEWEEK;
		
		//月
		$d['thisMonth']=DateUtil::getFullMonthDate();
		$d['lastMonth']=DateUtil::getFullMonthDate($d['thisMonth']-DateUtil::$ONEDAY*32);
		$d['lastMonth2']=DateUtil::getFullMonthDate($d['lastMonth']-DateUtil::$ONEDAY*32);
		
		//如果有差值，则计算（用于转换为java风格或C#风格）
		if(!empty($shift)){
			foreach($d as $k=>$v){
				$d[$k] = $v*$shift;
			}
		}
		
		return $d;
	}
	
	/**
	 * 获取整天时间戳 （今天的 23:59:59）
	 * Enter description here ...
	 * @param $unixTime
	 */
	public static function getFullDayDate($unixTime=0){
		if(empty($unixTime)){
			$unixTime=time();
		}

		$year=date('Y',$unixTime);
		$month=date('m',$unixTime);
		$day=date('d',$unixTime);
		
		$_d=mktime(23,59,59,$month,$day,$year);
		
		return $_d;
	}
	
	/**
	 * 获取指定月份的天数
	 * Enter description here ...
	 * @param int $year 年
	 * @param int $month 月
	 */
	public static function getDayLenOfMonth($year,$month)
	{
		if(in_array($month, array(1,3,5,7,8,10,12))){
			$dLen=31;
		}else if($month == 2){
			if(($year%4==0&&$year%100!=0) || $year%400==0){
				$dLen=29;
			}else{
				$dLen=28;
			}
		}else{
			$dLen=30;
		}
		
		return $dLen;
	}
	
	/**
	 * 获取整月时间 （本月之后一号的 23:59:59）
	 * Enter description here ...
	 * @param unknown_type $unixTime
	 */
	public static function getFullMonthDate($unixTime=0)
	{
		if(empty($unixTime)){
			$unixTime=time();
		}
		
		$year=date('Y',$unixTime);
		$month=date('m',$unixTime);
		$day=date('d',$unixTime);
		
		//获取本月天数
		$dLen=self::getDayLenOfMonth($year, $month);
		
		$dayShift=$dLen-$day;
		
		$unixTime+=$dayShift*self::$ONEDAY; //this is weekend
		
		return self::getFullDayDate($unixTime); //换算成整天
		
	}
	
	/**
	 * 获取整周时间戳 （本周日的 23:59:59）
	 * Enter description here ...
	 * @param $unixTime
	 */
	public static function getFullWeekDate($unixTime=0)
	{
		if(empty($unixTime)){
			$unixTime=time();
		}
		
		$dayOfWeek=date('N', $unixTime);//今天星期几？
		
		
		$dayShift=7-$dayOfWeek; //距离周末的差值（天）
		
		$unixTime+=$dayShift*self::$ONEDAY; //this is weekend
		
		return self::getFullDayDate($unixTime); //换算成整天
		
	}
}