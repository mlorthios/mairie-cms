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
                    <div class="col-md-8">
                        <div class="form-group">
                            <input class="form-control form-control-lg" value="<?= $f['message']; ?>" placeholder="Message" name="message">
                        </div>
                        <div class="form-group">
                            <select name="type" class="form-control form-control-lg">
                                <option selected disabled>Type de message</option>
                                <option value="info">Information</option>
                                <option value="warning">Avertissement</option>
                                <option value="defile">Défilement</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select name="page" class="form-control form-control-lg">
                                <option selected disabled>Sur quelle page publier le message ?</option>
                                <option value="fullpage">Toutes les pages</option>
                                <option value="0">Accueil</option>
                                <?php
                                
                                $Pages = $db->query('SELECT * FROM pages');
                                
                                while($p = $Pages->fetch()) {
                                    
                                    echo '<option value="'.$p['id'].'">'.$p['name'].'</option>';
                                    
                                }
                                
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" name="publish" class="btn btn-primary btn-block">Publier</button>
                        <a href="/admin/messages" class="btn btn-danger btn-block">Annuler</a>
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
            
            $('[name="publish"]').click(function() {
                
                var csrf = $('meta[name="csrf-token"]').attr('content');
               
                $('[name="publish"]').prop('disabled', true);
                $('[name="publish"]').html('Publication en cours');
                
                var message = $('[name="message"]').val(),
                    type = $('[name="type"]').val(),
                    page = $('[name="page"]').val();
                
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': csrf
                    },
                    url: '/api/admin/messages/add',
                    type: 'POST',
                    data: {
                        message: message,
                        type: type,
                        page: page,
                    },
                    dataType: 'json',
                    success: function(json) {
                        if(json.status == 'success') {
                            $.gritter.add({
                                title: "Notification",
                                text: json.response
                            });
                            $("[name='publish']").prop('disabled', true);
                            $("[name='publish']").html('Publication effectué');
                            setTimeout(function() {
                                window.location.href = '/admin/messages';
                            }, 2200);
                        } else {
                            $.gritter.add({
                                title: "Notification",
                                text: json.response,
                            });
                            $("[name='publish']").prop('disabled', false);
                            $("[name='publish']").html('Publier');
                        }
                    },
                    error: function (request, status, error) {
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
