<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8"/>
		<title>Administration</title>
		<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport"/>
        <meta name="csrf-token" content="<?= $csrf_token ?>">
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet"/>
		<link href="/public/admin/plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet"/>
		<link href="/public/admin/plugins/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet"/>
		<link href="/public/admin/plugins/font-awesome/css/all.min.css" rel="stylesheet"/>
		<link href="/public/admin/plugins/animate/animate.min.css" rel="stylesheet"/>
		<link href="/public/admin/css/default/style.min.css" rel="stylesheet"/>
		<link href="/public/admin/css/default/style-responsive.min.css" rel="stylesheet"/>
		<link href="/public/admin/css/default/theme/default.css" rel="stylesheet" id="theme"/>
		<link href="/public/admin/plugins/gritter/css/jquery.gritter.css" rel="stylesheet"/>
	</head>
	<body>
		<div id="page-container" class="page-container fade page-sidebar-fixed page-header-fixed">
			<div id="header" class="header navbar-default">
				<div class="navbar-header">
					<a href="/admin/" class="navbar-brand">
						<span class="navbar-logo"></span>
						<b>Administration</b>
					</a>
					<button type="button" class="navbar-toggle" data-click="sidebar-toggled">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>
				<ul class="navbar-nav navbar-right">
					<li class="dropdown navbar-user">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
							<span class="d-none d-md-inline">
								<?= $user->Firstname(); ?>
								<?= $user->Lastname(); ?>
							</span>
							<b class="caret"></b>
						</a>
						<div class="dropdown-menu dropdown-menu-right">
							<a href="/admin/settings" class="dropdown-item">Paramètres</a>
							<div class="dropdown-divider"></div>
							<a href="/admin/logout" class="dropdown-item">Déconnexion</a>
						</div>
					</li>
				</ul>
			</div>
			<?php include 'partials/nav.partial.php'; ?>
			<div class="sidebar-bg"></div>
			<div id="content" class="content">
				<div class="row" id="home">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                Modifier l'utilisateur #<?= $fetch['id']; ?>
                            </div>
                            <div class="card-block">
                                <div class="form-group">
                                    <label>Prénom<sup>*</sup></label>
                                    <input class="form-control" placeholder="Prénom" name="first_name" value="<?= $fetch['first_name']; ?>">
                                </div>
                                <div class="form-group">
                                    <label>Nom<sup>*</sup></label>
                                    <input class="form-control" placeholder="Nom" name="last_name" value="<?= $fetch['last_name']; ?>">
                                </div>
                                <div class="form-group">
                                    <label>Adresse e-mail<sup>*</sup></label>
                                    <input type="email" class="form-control" placeholder="Adresse e-mail" name="email" value="<?= $fetch['email']; ?>">
                                </div>
                                <div class="form-group">
                                    <label>Grade<sup>*</sup></label>
                                    <select name="rank" class="form-control">
                                        <?php
                                        
                                        $fg = $db->query('SELECT * FROM groups');
                                        
                                        while($t = $fg->fetch()) {
                                            echo '<option value="'.$t['id'].'">'.$t['name'].'</option>';
                                        }
                                        
                                        ?>
                                    </select>
                                </div>
                                <button type="submit" name="edit" class="btn btn-primary btn-block">Modifier</button>
                            </div>
					   </div>    
                    </div>
                    <div class="col-md-2">
                        <a href="/admin/users" class="btn btn-primary btn-block">Annuler</a>
                    </div>
				</div>
			</div>
			<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
		</div>
		<script src="/public/admin/plugins/jquery/jquery-3.3.1.min.js"></script>
		<script src="/public/admin/plugins/jquery-ui/jquery-ui.min.js"></script>
		<script src="/public/admin/plugins/bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
		<!--[if lt IE 9]>
		<script src="/public/admin/crossbrowserjs/html5shiv.js"></script>
		<script src="/public/admin/crossbrowserjs/respond.min.js"></script>
		<script src="/public/admin/crossbrowserjs/excanvas.min.js"></script>
		<![endif]-->
		<script src="/public/admin/plugins/slimscroll/jquery.slimscroll.min.js"></script>
		<script src="/public/admin/plugins/js-cookie/js.cookie.js"></script>
		<script src="/public/admin/js/theme/default.min.js"></script>
        <script src="/public/admin/plugins/gritter/js/jquery.gritter.js"></script>
		<script src="/public/admin/js/apps.min.js"></script>
		<script>
			$(document).ready(function(){
                App.init();
			});
            
            $('[name="edit"]').click(function() {
                $('[name="edit"]').prop('disabled', true);
                $('[name="edit"]').html('Création du compte en cours');
                
                var csrf = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': csrf
                    },
                    url: '/api/admin/users/edit',
                    type: 'POST',
                    data: {
                        first_name: $('[name="first_name"]').val(),
                        last_name: $('[name="last_name"]').val(),
                        email: $('[name="email"]').val(),
                        rank: $('[name="rank"]').val(),
                        password: $('[name="password"]').val(),
                        id: <?= $id ?>
                    },
                    dataType: 'json',
                    success: function(json) {
                        if(json.status == 'success') {
                            $('[name="edit"]').prop('disabled', false);
                            $('[name="edit"]').html('Modifier');
                            $.gritter.add({
                                title: "Notification",
                                text: json.response
                            });
                        } else {
                            $('[name="edit"]').prop('disabled', false);
                            $('[name="edit"]').html('Modifier');
                            $.gritter.add({
                                title: "Notification",
                                text: json.response,
                            });
                        }
                    },
                    error: function (request, status, error) { 
                        $('[name="edit"]').prop('disabled', false);
                        $('[name="edit"]').html('Modifier');
                        $.gritter.add({
                            title: "Notification",
                            text: "Une erreur est survenue : " + request.responseText
                        });
                    }
                });
            });
		</script>
	</body>
</html>
