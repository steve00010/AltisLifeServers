    <div class="container">
		<div class="col-md-12">
          <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title"><?php echo $info['name']; ?> | Votes:  <?php echo $info['votes']; ?></h3>
            </div>
            <div class="panel-body">
			<?php if(isset($voted)) { 
					if($voted == true) { ?>
						<div class="alert alert-success" role="alert">
							You have successfully voted for this server!
						</div>
					<?php } else { ?>
						<div class="alert alert-danger" role="alert">
							You have already voted today! You have approx <?php echo gmdate("H:i",(86400-(time()-$votetime))) ?> hours left before you can vote!
						</div>
					<?php } 
				}?>
				<div class="container">
					<div class="row">
						<div class="col-md-4">
							<h4>Website: <a href="<?php echo $info['url'];?>"><?php echo $info['url'];?></a></h2>
							<p>Vote: <a href="<?php echo base_url().'server/vote/'.$info['sid'].'/0'?>"><span class="glyphicon glyphicon-thumbs-up"></span></a> or <a href="<?php echo base_url().'server/vote/'.$info['sid'].'/1'?>"><span class="glyphicon glyphicon-thumbs-down"></span></a></p>	

						</div>	
												<div class="col-md-6">
							<img src="http://cache.www.gametracker.com/server_info/<?php echo $info['ip'].':'.$info['port']?>/b_560_95_1.png"></img>
						</div>
						
					</div>	
					<div class="row">
						<div class="col-md-8">
													<h4>Description: </h4>
							<p><?php echo $info['desc']; ?></p>
							</div>
							</div>
					
				</div>
            </div>
          </div>
        </div>
