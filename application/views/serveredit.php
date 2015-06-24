    <div class="container">
		<div class="col-md-12">
          <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">Edit your server</h3>
            </div>
            <div class="panel-body">
				<form class="container" method="post">
					<span hidden id="hiddenurl"><?php echo $server['url']; ?></span>
					<span hidden id="hiddendesc"><?php echo $server['desc']; ?></span>
					<div class="row">
						<h3 class="dark-grey"><?php echo $server['name'] ?></h3>
						<div class="form-group col-md-4">
							<label>Website:</label>
							<input type="" id="urlin" required class="form-control" name="url" value="">
						</div>
						</div>
					<div class="row">
						<div class="form-group col-md-8	">
							<label>Description:</label>
							<textarea class="form-control" id="descin" required rows="5" name="desc" value=""></textarea>
						</div>
						<script type="text/javascript">
							document.getElementById("urlin").value = document.getElementById('hiddenurl').innerHTML;
							document.getElementById("descin").value = document.getElementById('hiddendesc').innerHTML;
						</script>

					</div>
				<button type="submit" class="btn btn-success">Edit</button>
				</form>
            </div>
          </div>
        </div>
