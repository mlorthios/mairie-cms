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
        <link href="/public/admin/plugins/summernote/summernote.css" rel="stylesheet"/>
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
                                Modification menu de navigation
                            </div>
                            <div class="card-block">
                                <div class="form-group">
                                    <label>Nom du menu</label>
                                    <input type="text" class="form-control" name="name" value="<?= $f['name']; ?>" placeholder="Nom du menu">
                                </div>
                                <div class="form-group">
                                    <label>Icon</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text" id="iconcurrent"></span></div>
                                        <select id="icon" name="icon" class="form-control"></select>
                                    </div>
                                    <small><a target="_blank" href="https://fontawesome.com/icons?d=gallery">Accéder à la liste complète des icons (Version Pro fonctionnelle)</a></small>
                                </div>
                                <div class="form-group">
                                    <label>Ordre</label>
                                    <input class="form-control" type="number" name="ordre" value="<?= $f['number']; ?>">
                                </div>
                                <button name="publish" type="submit" class="btn btn-primary btn-block">Publier</button>
                                <button name="delete" type="submit" class="btn btn-danger btn-block">Supprimer</button>
                                <a href="/admin/pages" class="btn btn-green btn-block">Retour</a>
                                <small id="publish_msg"></small>
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
        <script src="/public/admin/plugins/summernote/summernote.min.js"></script>
        <script src="/public/admin/plugins/summernote/fr.js"></script>
		<script>
            
			$(document).ready(function(){
				App.init();
			});
            
            $.get('/public/metadata/icons.json', function(data) {
                $.each(data, function(index, icon){
                    
                    var classname = 'fa'+icon.styles[0].substr(0, 1)+' fa-' + index + '';
                    var classactive = '<?php echo $f['icon']; ?>';
                    
                    if(classactive == classname) {
                        $('#icon').append('<option selected value="fa'+icon.styles[0].substr(0, 1)+' fa-' + index + '">' + index + '</option>');
                    } else {
                        $('#icon').append('<option value="fa'+icon.styles[0].substr(0, 1)+' fa-' + index + '">' + index + '</option>');
                    }
                });
                
                $('#iconcurrent').html('<i class="'+$('#icon').val()+'"></i>')
            });
            
            $("#icon").change(function(){
                var icono = $(this).val();
                $("#iconcurrent").html('<i class="' + icono + '"></i>');
            });
            
            $('[name="delete"]').click(function() {
                if(confirm("Voulez-vous vraiment supprimer ce menu de navigation ?")) {
                    $('[name="delete"]').prop('disabled', true);
                    $('[name="publish"]').prop('disabled', true);
                    var csrf = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': csrf
                        },
                        type: "POST",
                        url: "/api/admin/pages/navigator/delete",
                        data: {
                           id: <?php echo $id; ?>
                        },
                        dataType: 'json',
                        success: function(json) {
                            if(json.status == 'success') {
                                setTimeout(function() {
                                    window.location.href = '/admin/pages';
                                }, 2200);
                                $.gritter.add({
                                    title: "Notification",
                                    text: json.response
                                });
                            } else {
                                $('[name="publish"]').prop('disabled', false);
                                $('#back').prop('disabled', false);
                                $('#cancel').show();
                                $.gritter.add({
                                    title: "Notification",
                                    text: json.response
                                });
                            }
                        },
                        error: function (request, status, error) {
                            $.gritter.add({
                                title: "Notification",
                                text: "Une erreur est survenue : " + request.responseText
                            });
                        }
                    });
                } else {
                    $.gritter.add({
                        title: "Notification",
                        text: 'Vous avez annulé la suppression du menu de navigation'
                    });
                }
            });
            
            $('[name="publish"]').click(function() {
                $('[name="publish"]').prop('disabled', true);
                $('#back').prop('disabled', true);
                $('#cancel').hide();
                $('#addpage').prop('disabled', true);
                var csrf = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': csrf
                    },
                    type: "POST",
                    url: "/api/admin/pages/navigator/edit",
                    data: {
                        menu_name: $('[name="name"]').val(),
                        menu_ordre: $('[name="ordre"]').val(),
                        menu_icon: $('[name="icon"]').val(),
                        id: <?php echo $id; ?>
                    },
                    dataType: 'json',
                    success: function(json) {
                        if(json.status == 'success') {
                            setTimeout(function() {
                                window.location.href = '/admin/pages';
                            }, 2200);
                            $.gritter.add({
                                title: "Notification",
                                text: json.response
                            });
                        } else {
                            $('[name="publish"]').prop('disabled', false);
                            $('#back').prop('disabled', false);
                            $('#cancel').show();
                            $.gritter.add({
                                title: "Notification",
                                text: json.response
                            });
                        }
                    },
                    error: function (request, status, error) {
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
