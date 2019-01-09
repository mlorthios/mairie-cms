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
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                Les utilisateurs
                            </div>
                            <div class="card-block">
                                <div class="table-responsive">
								    <table class="table table-striped m-b-0">
                                        <thead>
                                            <tr>
                                                <th>Prénom</th>
                                                <th>Nom</th>
                                                <th>Adresse e-mail</th>
                                                <th width="1%"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="users">
                                            <?php
                                        
                                            $user = $db->query('SELECT * FROM users');
                                        
                                            while($u = $user->fetch()) {
                                                echo '<tr id="user'.$u['id'].'">
                                                <td>'.$u['first_name'].'</td>
                                                <td>'.$u['last_name'].'</td>
                                                <td>'.$u['email'].'</td>
                                                <td class="with-btn" nowrap="">
                                                <a href="/admin/users/edit/'.$u['id'].'" class="btn btn-sm btn-primary">Éditer</a>
												<a href="javascript:;" onclick="Delete('.$u['id'].')" class="btn btn-sm btn-white">Supprimer</a>
                                                </td>
                                                </tr>';
                                            }
                                        
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
					   </div>    
                    </div>
                    <div class="col-md-2">
                        <button name="add_user" type="button" class="btn btn-primary btn-block">Ajouter un utilisateur</button>
                    </div>
				</div>
                <div class="row" style="display: none" id="create">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                Créer un compte utilisateur
                            </div>
                            <div class="card-block">
                                <div class="form-group">
                                    <label>Prénom<sup>*</sup></label>
                                    <input class="form-control" name="first_name" placeholder="Prénom">
                                </div>
                                <div class="form-group">
                                    <label>Nom<sup>*</sup></label>
                                    <input class="form-control" name="last_name" placeholder="Nom">
                                </div>
                                <div class="form-group">
                                    <label>Adresse e-mail<sup>*</sup></label>
                                    <input type="email" class="form-control" name="email" placeholder="Adresse e-mail">
                                </div>
                                <div class="form-group">
                                    <label>Mot de passe<sup>*</sup></label>
                                    <input type="password" class="form-control" name="password" placeholder="Mot de passe">
                                </div>
                                <div class="form-group">
                                    <label>Grade<sup>*</sup></label>
                                    <select class="form-control" name="rank">
                                        <?php
                                        
                                        $r = $db->query('SELECT * FROM groups');
                                        
                                        while($g = $r->fetch()) {
                                            echo '<option value="'.$g['id'].'">'.$g['name'].'</option>';
                                        }
                                        
                                        ?>
                                    </select>
                                </div>
                                <button type="submit" name="create" class="btn btn-primary btn-block">Créer le compte</button>
                            </div>
					   </div>
                    </div>
                    <div class="col-md-2">
                        <button type="button" name="back_home" class="btn btn-danger btn-block">Retour</button>
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
            
            $('[name="add_user"]').click(function() {
                $('#home').hide();
                $('#create').fadeIn(500);
            });
            
            $('[name="back_home"]').click(function() {
                $('#create').hide();
                $('#home').fadeIn(500);
            });
            
            $('[name="create"]').click(function() {
                $('[name="create"]').prop('disabled', true);
                $('[name="create"]').html('Création du compte en cours');
                
                var csrf = $('meta[name="csrf-token"]').attr('content');
                
                
                
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': csrf
                    },
                    url: '/api/admin/users/create',
                    type: 'POST',
                    data: {
                        first_name: $('[name="first_name"]').val(),
                        last_name: $('[name="last_name"]').val(),
                        email: $('[name="email"]').val(),
                        rank: $('[name="rank"]').val(),
                        password: $('[name="password"]').val()
                    },
                    dataType: 'json',
                    success: function(json) {
                        if(json.status == 'success') {
                            $('#users').append('<tr id="user'+json.id+'"><td class="with-img"><img src="/public/img/avatars/default.png" class="img-rounded height-30"></td><td>'+$('[name="first_name"]').val()+'</td><td>'+$('[name="last_name"]').val()+'</td><td>'+$('[name="email"]').val()+'</td><td class="with-btn" nowrap=""><a href="/admin/users/edit/'+json.id+'" class="btn btn-sm btn-primary">Éditer</a> <a href="javascript:;" onclick="Delete('+json.id+')" class="btn btn-sm btn-white">Supprimer</a></td></tr>');
                            $('[name="create"]').prop('disabled', false);
                            $('[name="create"]').html('Créer le compte');
                            $('[name="first_name"]').val('');
                            $('[name="last_name"]').val('');
                            $('[name="email"]').val('');
                            $('[name="password"]').val('');
                            $('#create').hide();
                            $('#home').fadeIn(500);
                            $.gritter.add({
                                title: "Notification",
                                text: json.response
                            });
                        } else {
                            $('[name="create"]').prop('disabled', false);
                            $('[name="create"]').html('Créer le compte');
                            $.gritter.add({
                                title: "Notification",
                                text: json.response,
                            });
                        }
                    },
                    error: function (request, status, error) { 
                        $('[name="create"]').prop('disabled', false);
                        $('[name="create"]').html('Créer le compte');
                        $.gritter.add({
                            title: "Notification",
                            text: "Une erreur est survenue : " + request.responseText
                        });
                    }
                });
            });
            
            function Delete(id) {
                $('#user'+id).hide();
                
                if(confirm('Voulez-vous vraiment supprimer cette utilisateur ?')) {
                    var csrf = $('meta[name="csrf-token"]').attr('content');
                
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': csrf
                        },
                        url: '/api/admin/users/delete',
                        type: 'POST',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function(json) {
                            if(json.status == 'success') {
                                $('#user'+id).remove();
                                $.gritter.add({
                                    title: "Notification",
                                    text: json.response
                                });
                            } else {
                                $('#user'+id).show();
                                $.gritter.add({
                                    title: "Notification",
                                    text: json.response,
                                });
                            }
                        },
                        error: function (request, status, error) { 
                            $('#user'+id).show();
                            $.gritter.add({
                                title: "Notification",
                                text: "Une erreur est survenue : " + request.responseText
                            });
                        }
                    });
                } else {
                    $('#user'+id).show();
                    $.gritter.add({
                        title: "Notification",
                        text: "Vous avez annuler la suppression de l'utilisateur"
                    });
                }
            }
		</script>
	</body>
</html>
