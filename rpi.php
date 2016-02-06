<?php
include("header.php");
include("menu.php");

// Config setters
$bdd = mysql_pdo_connect();
?>

<section>
	<article>
		<?php
		if(isset($_SESSION['username'])) {
		?>
		<h1>Raspberry PI monitor</h1>
		<p>
			<b>Hostname</b>: <?php echo exec('hostname'); ?><br>
			<b>Uptime</b>: 
			<?php
			$matches = array();
			$in_str = exec('ls -l /var/run/nginx.pid');
			$pattern = '/([A-Z][a-zA-Z0-9.]+)[ ]*([0-9]+)[ ]([0-9:]+)/';
			preg_match($pattern, $in_str, $matches);
			
			$_month = $matches[1];
			$_day 	= $matches[2];
			$_time 	= $matches[3];
			
			$_startedday = strtotime($_month."-".$_day);
			$_temp = explode(':',$_time);
			$_startedhour = $_temp[0];
			$_startedmin = $_temp[1];
			
			$started_time = $_startedday+$_startedhour*3600+$_startedmin*60;
			$current_time = time();
			$uptime = $current_time - $started_time;
			
			$uptime_days = floor($uptime/(24*3600));
			$uptime_hours = floor(($uptime-$uptime_days*24*3600)/3600);
			$uptime_minutes = floor(($uptime-$uptime_days*24*3600-$uptime_hours*3600)/60);
			
			echo $uptime_days."d ".$uptime_hours."h ".$uptime_minutes."m ";
			?>
			<br>
			<b>CPU temperature</b>: 
			<?php
			$matches = array();
			$in_str = exec('/opt/vc/bin/vcgencmd measure_temp');
			preg_match('/([0-9.]+)/', $in_str, $matches);
			echo $matches[0];
			?>°C
			<br>
			<b>Network:</b> 
			<?php
			$ifconfig = shell_exec('ifconfig eth0 | grep RX\ bytes');
			$ifconfig = str_ireplace("RX bytes:", "", $ifconfig);
			$ifconfig = str_ireplace("TX bytes:", "", $ifconfig);
			$ifconfig = trim($ifconfig);
			$ifconfig = explode(" ", $ifconfig);
			
			$rxRaw = $ifconfig[0] / 1024 / 1024;
			$txRaw = $ifconfig[4] / 1024 / 1024;
			$rx = round($rxRaw, 2);
			$tx = round($txRaw, 2);
			?>
			<i>(received)</i> <?php echo $rx ?>MB, <i>(sent)</i> <?php echo $tx; ?>MB, <i>(total)</i> <?php echo $tx+$rx; ?>MB<br>
			<b>Active connections:</b> 
			<?php
			$connections = shell_exec("netstat -nta --inet | wc -l");
			$connections--;
			echo substr($connections, 0, -1);
			?>
		</p>
		<?php
		} else {
		?>
			<h1>Log in form</h1>
			<p>You are not connected. Please connect now to access the administration tools.</p>
			
			<form method=post action="login">
				<table style="width:100%">
				<tr>
					<td style="padding-top:20px">Username<br><input type="text" name="username"></td>
				</tr>
				<tr>
					<td style="padding-top:20px">Password<br><input type="password" name="password"></td>
				</tr>
				<tr>
					<td style="padding-top:20px"><input type="submit" value="Log in"></td>
				</tr>
				</table>
			</form>
		<?php
		}
		?>
	</article>
</section>

<?php
include("footer.php");
?>
