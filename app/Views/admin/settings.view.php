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
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                Changement de mot de passe
                            </div>
                            <div class="card-block">
                                <div class="form-group">
                                    <input class="form-control" type="password" name="current" placeholder="Mot de passe actuel">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" type="password" name="new" placeholder="Nouveau mot de passe">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" type="password" name="new2" placeholder="Confirmez votre nouveau mot de passe">
                                </div>
                                <button type="submit" name="edit" class="btn btn-primary btn-block">Changer mon mot de passe</button>
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
            
            $('[name="edit"]').click(function() {
                var csrf = $('meta[name="csrf-token"]').attr('content');
                
                $('[name="edit"]').prop('disabled', true);
                $('[name="edit"]').html('Modification en cours');
                
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': csrf
                    },
                    url: '/api/admin/settings/password',
                    type: 'POST',
                    data: {
                        current: $('[name="current"]').val(),
                        new: $('[name="new"]').val(),
                        new2: $('[name="new2"]').val()
                    },
                    dataType: 'json',
                    success: function(json) {
                        if(json.status == 'success') {
                            $.gritter.add({
                                title: "Notification",
                                text: json.response
                            });
                            $('[name="edit"]').prop('disabled', false);
                            $('[name="edit"]').html('Changer mon mot de passe');
                            setTimeout(function() {
                                window.location.href = '/admin/';
                            }, 2200);
                        } else {
                            $.gritter.add({
                                title: "Notification",
                                text: json.response,
                            });
                            $('[name="edit"]').prop('disabled', false);
                            $('[name="edit"]').html('Changer mon mot de passe');
                        }
                    },
                    error: function (request, status, error) {
                        $('[name="edit"]').prop('disabled', false);
                        $('[name="edit"]').html('Changer mon mot de passe');
                        $.gritter.add({
                            title: "Notification",
                            text: "Une erreur est survenue : " + request.responseText
                        });
                    }
                });
            })
		</script>
	</body>
</html>
