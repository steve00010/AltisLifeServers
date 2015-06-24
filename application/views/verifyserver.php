    <div class="container">
		<div class="col-md-12">
          <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">Register a server</h3>
            </div>
            <div class="panel-body">
				<div class="container">
					<?php if($server['valid'] == true) { ?>
					<h2>Server IP: <?php echo $server['ip'].':'.$server['port']; ?></h2>
					<p>Server name: <span class="offline"><?php echo $server['name']; ?></span></p>
					<?php if(!$server['verified']) { ?>
					<p> Please change your server name to <span class="online"><?php echo $server['randomname']; ?></span> for it to be verified!</p>
					<p> Refresh the page once this is done and your server will be verified.</p>
					<p> There will be a link for verification on your profile if you wish to come back!</p>
					<?php } else { ?>
						<p> Your server is now verified! </p>
					<?php } } else {?></div>
					<div class="alert alert-danger" role="alert">
							<strong>Not Found!</strong> This server is not online or doesn't exist, please try again!
						</div>
					<a href="<?php echo base_url();?>profile/register" class="btn btn btn-success">Register Server</a>						
					<?php } ?>
					
				
            </div>
          </div>
        </div>
