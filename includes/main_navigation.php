<!-- MAIN NAVIGATION -->
			<ul id="main-navigation">
				<li><a href="index.php"<?php if($page == 'home'){ echo(" class=\"active\"");} ?>>about</a></li><?php if(is('user')&&($_SESSION['event_end']==0 || $_SESSION['event_end'] > time())){?><li><a href="index.php?do=create"<?php if($page == 'create'){ echo(" class=\"active\"");} ?>>+ add</a></li><?php } ?><li class="last"><a href="index.php?do=explore"<?php if($page == 'view'||$page == 'explore'){ echo(" class=\"active\"");} ?>>explore</a></li></ul>
		