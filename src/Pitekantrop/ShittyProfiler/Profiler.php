<?php namespace Pitekantrop\ShittyProfiler;


class Profiler {

	protected $startTime;
	protected $endTime;
	protected $app;
	static $markers = array();

	/**
	 * Set initial params
	 * 
	 * @param integer $endTime
	 * @param Illuminate\Foundation\Application $app
	 */
	public function __construct($endTime, $app)
	{
		$this->startTime = LARAVEL_START;
		$this->endTime = $endTime;
		$this->app = $app;
	}

	//--------------------------------------------------------------------
	
	/**
	 * Replace the response output with the profiler view
	 * 
	 * @return void
	 */
	public function displayProfiler($res)
	{	
		$data['timestamp'] = $this->getGlobalTime();
		$data['memory']    = $this->getMemoryUsage();
		$data['markers']   = $this->getMarkerPoints();
		$data['files']     = $this->getIncludedFiles();
		$data['db']        = $this->getQueryStrings();
		
		$res->header('Content-Type', 'text/html');
		$res->setContent($this->app['view']->make('shittyprofiler::prof', $data));
	}


	//--------------------------------------------------------------------

	/**
	 * Set a marker point
	 * 
	 * @param  string $mark
	 * @return void
	 */
	public static function mark($mark)
	{
		static::$markers[$mark] = microtime(true);
	}

	//--------------------------------------------------------------------

	/**
	 * Prepare all marker points that are set by Profiler::mark()
	 * 
	 * @return array
	 */
	protected function getMarkerPoints()
	{
		$markers = array();

		foreach (static::$markers as $mark => $time) 
		{
			$endMark = $mark.'End';

			if (array_key_exists($endMark, static::$markers)) 
			{
				$time = static::$markers[$endMark] - $time;
			}
			else
			{
				$mark = 'start -> '.$mark;
				$time = $time - $this->startTime;
			}

			if (!strpos($endMark, 'EndEnd')) 
			{
				$markers[] = array(
					'name' => $mark,
					'time' => $this->formatTime($time),
				);
			}
		}

		return $markers;
	}

	//--------------------------------------------------------------------

	/**
	 * Calculate the elapsed time since LARAVEL_START
	 * 
	 * @return float
	 */
	protected function getGlobalTime()
	{
		return $this->formatTime($this->endTime - $this->startTime);
	}

	//--------------------------------------------------------------------

	/**
	 * Convert microseconds to milliseconds
	 * 
	 * @param  integer  $timestamp 
	 * @param  integer  $points    
	 * @return float
	 */
	public function formatTime($timestamp, $points = 2)
	{
		return number_format($timestamp * 1000, $points);
	}

	//--------------------------------------------------------------------

	/**
	 * Get query strings and format them to be more informative
	 * 
	 * @return array
	 */
	protected function getQueryStrings()
	{
		$queries = $this->app->make('db')->getQueryLog();
		
		$db['queries'] = array();
		$db['total'] = 0;

		foreach ($queries as $i => $query) 
		{
			$bindings = $query['bindings'];
			$db['total'] += $query['time'];

			$db['queries'][] = array(
				'time'  => $query['time'],
				'query' => preg_replace_callback('/\?/', function($matches) use(&$bindings) {
					return array_shift($bindings);
				}, $query['query']),
			);
		}

		return $db;
	}

	//--------------------------------------------------------------------

	/**
	 * Get a list of included files
	 * 
	 * @return array
	 */
	protected function getIncludedFiles()
	{
		return get_included_files();
	}

	//--------------------------------------------------------------------

	/**
	 * Get memory usage info;
	 * 
	 * @return float
	 */
	protected function getMemoryUsage()
	{
		return number_format(memory_get_usage() / 1048576, 2);
	}
}
