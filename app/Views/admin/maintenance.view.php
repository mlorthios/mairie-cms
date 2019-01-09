<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8"/>
		<title>Administration</title>
		<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport"/>
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
				<div class="row">
                    <div class="col-md-12" id="__message-alert"></div>
					<div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                Maintenance
                            </div>
                            <div class="card">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">Nom: <strong id="update_name">Chargement</strong></li>
                                    <li class="list-group-item">Version actuelle: <strong id="update_current_version">Chargement</strong></li>
                                    <li class="list-group-item">Dernière version: <strong id="update_version">Chargement</strong></li>
                                    <li class="list-group-item">Mise à jour: <strong id="update_maj">Chargement</strong></li>
                                    <li class="list-group-item">Dernière mise à jour: <strong id="update_last_maj">Chargement</strong></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="card">
                            <div class="card-header">
                                Changelogs
                            </div>
                            <div class="card">
                               
                            </div>
                        </div>
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
            
            $(document).ready(function() {
                $.getJSON( "/api/admin/maintenance/update", function( data ) {
                    $('#update_name').html(data.name);
                    $('#update_version').html(data.version)
                    
                    var current_version = "<?= $maintenance->CurrentVersion('version'); ?>";
                    
                    $('#update_current_version').html(current_version);
                    $('#update_last_maj').html("<?= $maintenance->CurrentVersion('last_update'); ?>")
                    
                    if(data.status == 'success') {
                        if(current_version < data.version) {
                            $('#update_maj').html('Disposible - <a href="#">Installer</a>')
                            $('#__message-alert').html('<div class="alert alert-success">Une <b>mise à jour</b> est <b>disponible</b>, installez là pour bénéficier des dernières amélioration. <a href="#">Cliquez ici pour accéder à la description de la mise à jour</a>.</div>');
                        } else {
                            $('#update_maj').html('Aucune')
                            $('#__message-alert').html('<div class="alert alert-info">Le site est à jour, aucun problème n\'a été détecté.</div>');
                        }
                    } else {
                        $('#__message-alert').html('<div class="alert alert-danger">'+data.message+'</div>');
                    }
                    
                }).fail(function() {
                    $('#update_name').html('Erreur');
                    $('#update_version').html('Erreur')
                    $('#update_maj').html('Erreur')
                    
                    var current_version = "<?= $maintenance->CurrentVersion('version'); ?>";
                    
                    $('#update_current_version').html(current_version);
                    $('#update_last_maj').html("<?= $maintenance->CurrentVersion('last_update'); ?>");
                    
                    $('#__message-alert').html('<div class="alert alert-danger">Connexion au serveur de mise à jour impossible. Veuillez nous contacter à l\'adresse e-mail suivante : <strong>business@lorthios.email</strong></div>');
                })
            })
		</script>
	</body>
</html>
