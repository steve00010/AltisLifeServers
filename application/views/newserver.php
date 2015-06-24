    <div class="container">
		<div class="col-md-12">
          <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">Register a server</h3>
            </div>
            <div class="panel-body">
						<?php if(isset($server) && $server['taken']) { ?>
						<div class="alert alert-danger" role="alert">
							<strong>Server taken!</strong> This server is already registered!
						</div>
						<?php } ?>
				<form class="container">
				
					<div class="col-md-4">
						<h3 class="dark-grey">Registration</h3>

						<div class="form-group col-lg-6">
							<label>Server IP</label>
							<input type="" required name="ip" class="form-control" id="" value="" >
						</div>
						
						<div class="form-group col-lg-4">
							<label>Port</label>
							<input type="" required name="port" class="form-control" id="" value="" style="width:60px">
						</div>
					
					</div>
		
					<div class="col-md-8">
						<h3 class="dark-grey">Terms and Conditions</h3>
						<p>
							By clicking on "Register" you agree to AltisLifeServers terms and conditions.
						</p>
						
				
						<button type="submit" class="btn btn-primary">Register</button>
					</div>
				</form>
            </div>
          </div>
        </div>
