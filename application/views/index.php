    <div class="container">
      <!-- Example row of columns -->
      <div class="row">
        <div class="col-md-4">
          <h2>Register</h2>
          <p>Register here and sign your server up to be seen by all who come to the website! Your own advertising page where you can show off your server!</p>
          <p><a class="btn btn-default" href="<?php echo base_url().'welcome/about';?>" role="button">View details &raquo;</a></p>
        </div>
        <div class="col-md-4">
          <h2>Search</h2>
          <p>Search by vote, by tags or just see the top servers which are currently populated!</p>
          <p><a class="btn btn-default" href="<?php echo base_url().'welcome/about';?>" role="button">View details &raquo;</a></p>
       </div>
        <div class="col-md-4">
          <h2>Vote</h2>
          <p>Vote for your favourite servers and have them move up the ranks!</p>
          <p><a class="btn btn-default" href="<?php echo base_url().'welcome/about';?>" role="button">View details &raquo;</a></p>
        </div>
      </div>
	  <hr />
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Altis Life Servers</h3>
				</div>
				<div class="panel-body">
				
					<div class="table-responsive">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>Rank</th>
								<th>Server</th>
								<th>Players</th>
								<th>Votes</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>              
						<?php
						foreach($servers as $row){
							?><tr itemscope itemtype="http://schema.org/GameServer"><td> <?php echo $row['rank'] ?> </td>
			<!--Server Name -->	<td><a href="<?php echo base_url();?>server/index/<?php echo $row['sid'] ?>"><span itemprop="name" > <?php echo $row['name'] ?></span> </a><br />
									<img src="<?php echo base_url();?>assets/img/flags/<?php echo str_replace(' ','_',$row['country']); ?>.png">
									<span class='lowerinfo'> Gamemode: <span itemprop="game"><?php echo $row['gamemode'] ?> </span></span> 
								</td>
			<!--Players -->		<td itemprop="playersOnline"> <?php echo $row['players'] ?> </td>
			<!-- Votes -->		<td> <?php echo $row['votes'] ?> </td>
			<!-- Status -->		<td itemprop="serverStatus"> <?php echo $row['Online'] ?> </td>
							</tr><?php }  ?>
						</tbody>
					</table>
					<nav>
					  <ul class="pagination">
						<li ><a href="<?php echo base_url() ?>" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li> 
						<?php for($i=0;$i<ceil($totalrows/10);$i++){ ?>
					
						<li <?php if($i==$offset) { ?> class="active"> <?php } ?><a href="<?php echo base_url().'welcome/index/'.$i ?>"><?php echo ($i+1) ?> <span class="sr-only">(current)</span></a></li> 
						<?php } ?>
						<li><a href="<?php echo base_url().'welcome/index/'.(floor($totalrows/10));?>" aria-label="Next"><span aria-hidden="true">»</span></a></li>
					  </ul>
					</nav>					
				</div>
				</div>
			</div>
		</div>

