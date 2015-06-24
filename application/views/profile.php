    <div class="container">
		<div class="col-md-12">
          <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">Your servers</h3>
            </div>
            <div class="panel-body">
              <table class="table table-striped">
						<thead>
							<tr>
								<th>Rank</th>
								<th>Server</th>
								<th>Players</th>
								<th>Votes</th>
								<th>Status</th>
								<th>Verified</th>
								<th>Edit</th>
							</tr>
						</thead>
						<tbody>              
						<?php
						if($servers[0]) {
							foreach($servers as $row){
								?><tr><td> <?php echo $row[0] ?> </td>
									<td> <?php echo $row[1] ?> <br /><img src="<?php echo base_url();?>/assets/img/flags/<?php echo str_replace(' ','_',$row[5]); ?>.png"><span class='lowerinfo'> Gamemode: <?php echo $row[6] ?> </span> </td>
									<td> <?php echo $row[2] ?> </td>
									<td> <?php echo $row[3] ?> </td>
									<td> <?php echo $row[4] ?> </td>
									<td><?php if($row[8] ==0) { echo "No"; } else { echo "Yes"; } ?> </td>
									<td> <a  class="btn btn btn-info" href="<?php 
										if($row[8] ==1) {echo base_url()
											?>server/edit/<?php echo $row[7]; ?> ">Edit</a><?php
											} else { echo base_url()
											?>profile/verify?ip=<?php echo $row[9]; ?>&port=<?php echo $row[10]
											?>">Verify</a><?php } ?> </td>
						</tr><?php } } else { ?>
						<td> No servers owned</td>
						<?php } ?>
						</tbody>
					</table>
					<a href="<?php echo base_url();?>profile/register" class="btn btn btn-success">Register Server</a>
            </div>
          </div>
        </div>
