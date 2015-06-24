<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Altis Life server finder, dynamic server listing with voting capability! Search for Altis Life servers and see who else likes them!">
    <meta name="tags" content="Altis Life, RPG, Gaming, ARMA,ARMA3,PC,Server,Search,Listing,Games,FPS,Voting,Dynamic,Bootstrap">
	<meta name="author" content="Steve">
    <link rel="icon" href="../../favicon.ico">
    <title><?php echo $title; ?></title>

    <style>
        body {
            padding-top: 50px;
            padding-bottom: 20px;
        }
        .jumbotron {
            background-image: url('<?php echo base_url()?>assets/img/bg1.png');
            background-repeat: no-repeat;
            background-attachment: fixed;
            color: #ecf0f1 !important;
        }
        .lowerinfo {
            font-size: 10px;
        }
        .online {
            color: #27ae60;
        }
        .offline {
            color: #c0392b;
        }
        span.glyphicon {
            font-size: 1.35em;
        }
        span.glyphicon-thumbs-up {
            color: #27ae60;
        }
        span.glyphicon-thumbs-down {
            color: #c0392b;
        }
    </style>
    <!--[if lt IE 9]> <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script> <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
</head>

<body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar"> <span class="sr-only">Toggle navigation</span>  <span class="icon-bar"></span>  <span class="icon-bar"></span>  <span class="icon-bar"></span> 
                </button> <a class="navbar-brand" href="#">AltisLife Servers</a> 
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
					<?php if (strpos($title,'About') !== false) { ?>
						<li ><a href="<?php echo base_url();?>">Home</a>
						</li>
						<li class="active"><a  href="<?php echo base_url();?>welcome/about">About</a>
					<?php	} else { ?>
						<li class="active"><a href="<?php echo base_url();?>">Home</a>
						</li>
						<li><a href="<?php echo base_url();?>welcome/about">About</a>
					<?php	} ?>
                  
                    
                    </li>
                    <li><a href="<?php echo base_url();?>welcome/contact">Contact</a>
                    </li>
                </ul>
                <form class="navbar-form navbar-right">
                    <!-- <div class="form-group"> <input type="text" placeholder="Search" class="form-control"> </div><button type="submit" class="btn btn-success">Search</button> -->
                    <?php echo $loginout ?>
                </form>
            </div>
        </div>
    </nav>
    <div class="jumbotron">
        <div class="container">
            <h2>Welcome<br/> to AltisLifeSevers</h2> 
            <p>Here you will find a large array of servers and the one suited to you!</p>
            <p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more &raquo;</a>
            </p>
        </div>
    </div>
