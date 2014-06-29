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
			<caption class="large">Time: <?php echo $timestamp; ?>ms / Memory: <?php echo $memory; ?>MB / <a href="<?php echo Request::url().'?profile'; ?>">Refresh</a></caption>
			<?php foreach($markers as $mark): ?>
			<tr>
				<td><?php echo $mark['name']; ?></td>
				<td align="right"><?php echo $mark['time']; ?>ms</td>
			</tr>
			<?php endforeach; ?>
		</table>

		<table>
			<caption>DB Queries: <?php echo count($db['queries']); ?> / Time: <?php echo $db['total']; ?>ms</caption>
			<?php foreach($db['queries'] as $query): ?>
				<tr>
					<td><?php echo $query['query']; ?></td>
					<td align="right"><?php echo $query['time']; ?>ms</td>
				</tr>
			<?php endforeach; ?>
		</table>

		<table>
			<caption>Included Files: <?php echo count($files); ?></caption>
			<?php foreach($files as $i => $file): ?>
				<tr>
					<td><?php echo ++$i; ?></td>
					<td><?php echo $file; ?></td>
				</tr>
			<?php endforeach; ?>
		</table>
	</div>
</body>
</html>



