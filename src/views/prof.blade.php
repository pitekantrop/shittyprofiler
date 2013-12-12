<html>
<head>
	<title></title>
	<style type="text/css">
		body {
			background-color: #EEE;
			font-family: Verdana;
		}
		a, a:hover, a:visited {
			color:black;
			text-decoration: none;
		}
		.wrapper {
			margin:0 auto;
			width: 960px;
		}
		caption {
			color:#222;
			background-color: #ED591A;
			border: 1px solid rgba(0,0,0, 0.08);
			text-transform: uppercase;
			font-weight: bold;
			text-align: center;
			border-radius: 1px;
			padding: 5px;
		}
		table {
			width: 100%;
			background-color: #272727;
			color: #ddd;
			font-size: 12px;
			border-collapse: collapse;
			margin-top: 10px;
		}
		.large { padding: 10px; font-size: 14px;}
		tr:nth-child(odd) { background-color: rgba(255,255,255, 0.06); }
		td { padding: 5px; }
	</style>
</head>
<body>
	<div class="wrapper">

		<table>
			<caption class="large">Time: {{ $timestamp }}ms / Memory: {{$memory}}MB / <a href="{{Request::url().'?profile'}}">Refresh</a></caption>
			@foreach($markers as $mark)
			<tr>
				<td>{{$mark['name']}}</td>
				<td align="right">{{$mark['time']}}ms</td>
			</tr>
			@endforeach
		</table>

		<table>
			<caption>DB Queries: {{count($db['queries'])}} / Time: {{$db['total']}}ms</caption>
			@foreach($db['queries'] as $query)
				<tr>
					<td>{{$query['query']}}</td>
					<td align="right">{{$query['time']}}ms</td>
				</tr>
			@endforeach
		</table>

		<table>
			<caption>Included Files: {{count($files)}}</caption>
			@foreach($files as $i => $file)
				<tr>
					<td>{{++$i}}</td>
					<td>{{$file}}</td>
				</tr>
			@endforeach
		</table>
	</div>
</body>
</html>



