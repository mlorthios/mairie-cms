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
                                Les groupes
                            </div>
                            <div class="card-block">
                                <div class="table-responsive">
								    <table class="table table-striped m-b-0">
                                        <thead>
                                            <tr>
                                                <th>Nom</th>
                                                <th width="1%"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="groups">
                                            <?php
                                        
                                            $user = $db->query('SELECT * FROM groups');
                                        
                                            while($u = $user->fetch()) {
                                                echo '<tr id="group'.$u['id'].'">
                                                <td>'.$u['name'].'</td>
                                                <td class="with-btn" nowrap="">
												<a href="javascript:;" onclick="Delete2('.$u['id'].')" class="btn btn-sm btn-white">Supprimer</a>
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
                        <button name="add_group" type="button" class="btn btn-primary btn-block">Ajouter un groupe</button>
                    </div>
				</div>
                <div class="row" style="display: none" id="create">
                    <div class="col-md-5">
                        <div class="card">
                            <div class="card-header">
                                Créer un nouveau groupe
                            </div>
                            <div class="card-block">
                                <div class="form-group">
                                    <label>Nom du groupe<sup>*</sup></label>
                                    <input class="form-control" name="name" placeholder="Nom du groupe">
                                </div>
                                <div class="row">
                                    <div class="col-md-6" id="permissions">
                                        <label>Permissions</label><br>
                                        <button class="btn btn-primary btn-xs m-r-5 m-b-5" id="admin_access" onclick="Add('admin_access')">Ajouter l'accès à l'administration</button>
                                        <button class="btn btn-primary btn-xs m-r-5 m-b-5" id="admin_pages" onclick="Add('admin_pages')">Ajouter la gestion des pages</button>
                                        <button class="btn btn-primary btn-xs m-r-5 m-b-5" id="admin_events" onclick="Add('admin_events')">Ajouter la gestion des événements</button>
                                        <button class="btn btn-primary btn-xs m-r-5 m-b-5" id="admin_news" onclick="Add('admin_news')">Ajouter la gestion de l'actualité</button>
                                        <button class="btn btn-primary btn-xs m-r-5 m-b-5" id="admin_messages" onclick="Add('admin_messages')">Ajouter la gestion des messages</button>
                                        <button class="btn btn-primary btn-xs m-r-5 m-b-5" id="admin_banners" onclick="Add('admin_banners')">Ajouter la gestion des bannières</button>
                                        <button class="btn btn-primary btn-xs m-r-5 m-b-5" id="admin_newsletter" onclick="Add('admin_newsletter')">Ajouter la gestion de la newsletter</button>
                                        <button class="btn btn-primary btn-xs m-r-5 m-b-5" id="admin_users" onclick="Add('admin_users')">Ajouter la gestion des utilisateurs</button>
                                        <button class="btn btn-primary btn-xs m-r-5 m-b-5" id="admin_permissions" onclick="Add('admin_permissions')">Ajouter la gestion des permissions</button>
                                        <button class="btn btn-primary btn-xs m-r-5 m-b-5" id="admin_maintenance" onclick="Add('admin_maintenance')">Ajouter l'accès à la maintenance</button>
                                    </div>
                                    <div class="col-md-6" id="permissionsok">
                                        <label>Permissions ajoutées</label><br>
                                        <input class="hide" name="admin_access" type="checkbox" value="1">
                                        <input class="hide" name="admin_pages" type="checkbox" value="1">
                                        <input class="hide" name="admin_events" type="checkbox" value="1">
                                        <input class="hide" name="admin_news" type="checkbox" value="1">
                                        <input class="hide" name="admin_messages" type="checkbox" value="1">
                                        <input class="hide" name="admin_banners" type="checkbox" value="1">
                                        <input class="hide" name="admin_newsletter" type="checkbox" value="1">
                                        <input class="hide" name="admin_users" type="checkbox" value="1">
                                        <input class="hide" name="admin_permissions" type="checkbox" value="1">
                                        <input class="hide" name="admin_maintenance" type="checkbox" value="1">
                                    </div>
                                </div>
                                <button style="margin-top: 10px" type="submit" name="create" class="btn btn-primary btn-block">Créer le groupe</button>
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
            
            $('[name="add_group"]').click(function() {
                $('#home').hide();
                $('#create').fadeIn(500);
            });
            
            $('[name="back_home"]').click(function() {
                $('#create').hide();
                $('#home').fadeIn(500);
            });
            
            function PermissionsName(name) {
                switch(name) {
                    case 'admin_access':
                        return 'Ajouter l\'accès à l\'administration';
                        break;
                    case 'admin_pages':
                        return 'Ajouter la gestion des pages';
                        break;
                    case 'admin_events':
                        return 'Ajouter la gestion des événements';
                        break;
                    case 'admin_news':
                        return 'Ajouter la gestion de l\'actualité';
                        break;
                    case 'admin_messages':
                        return 'Ajouter la gestion des messages';
                        break;
                    case 'admin_banners':
                        return 'Ajouter la gestion des bannières';
                        break;
                    case 'admin_newsletter':
                        return 'Ajouter la gestion de la newsletter';
                        break;
                    case 'admin_users':
                        return 'Ajouter la gestion des utilisateurs';
                        break;
                    case 'admin_permissions':
                        return 'Ajouter la gestion des permissions';
                        break;
                    case 'admin_maintenance':
                        return 'Ajouter l\'accès à la maintenance';
                        break;
                }
            }
            
            function PermissionsName2(name) {
                switch(name) {
                    case 'admin_access':
                        return 'Supprimer l\'accès à l\'administration';
                        break;
                    case 'admin_pages':
                        return 'Supprimer la gestion des pages';
                        break;
                    case 'admin_events':
                        return 'Supprimer la gestion des événements';
                        break;
                    case 'admin_news':
                        return 'Supprimer la gestion de l\'actualité';
                        break;
                    case 'admin_messages':
                        return 'Supprimer la gestion des messages';
                        break;
                    case 'admin_banners':
                        return 'Supprimer la gestion des bannières';
                        break;
                    case 'admin_newsletter':
                        return 'Supprimer la gestion de la newsletter';
                        break;
                    case 'admin_users':
                        return 'Supprimer la gestion des utilisateurs';
                        break;
                    case 'admin_permissions':
                        return 'Supprimer la gestion des permissions';
                        break;
                    case 'admin_maintenance':
                        return 'Supprimer l\'accès à la maintenance';
                        break;
                }
            }
            
            function Add(id) {
                $('#'+id).remove();
                $('#permissionsok').append("<button class=\"btn btn-danger btn-xs m-r-5 m-b-5\" id=\""+id+"\" onclick=\"Delete('"+id+"')\">"+PermissionsName2(id)+"</button>");
                document.getElementsByName(""+id+"")[0].checked = true;
            }
            
            
            function Delete(id) {
                $('#'+id).remove();
                $('#permissions').append("<button class=\"btn btn-primary btn-xs m-r-5 m-b-5\" id=\""+id+"\" onclick=\"Add('"+id+"')\">"+PermissionsName(id)+"</button>")
                document.getElementsByName(id)[0].checked = false;
            }
            
            function CheckOrNot(id) {
                if(document.getElementsByName(""+id+"")[0].checked) {
                    return '1';
                } else {
                    return '0';
                }
            }
            
            function Delete2(id) {
                var csrf = $('meta[name="csrf-token"]').attr('content');
                
                $('#group'+id).hide();
                
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': csrf
                    },
                    url: '/api/admin/permissions/delete',
                    type: 'POST',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(json) {
                        console.log(CheckOrNot("admin_access"));
                        if(json.status == 'success') {
                            $('#group'+id).remove();
                            $.gritter.add({
                                title: "Notification",
                                text: json.response
                            });
                        } else {
                            $('#group'+id).show();
                            $.gritter.add({
                                title: "Notification",
                                text: json.response,
                            });
                        }
                    },
                    error: function (request, status, error) { 
                        $('#group'+id).show();
                        $.gritter.add({
                            title: "Notification",
                            text: "Une erreur est survenue : " + request.responseText
                        });
                    }
                });
            }
            
            $('[name="create"]').click(function() {
                $('[name="create"]').prop('disabled', true);
                $('[name="create"]').html('Création du groupe en cours');
                
                var csrf = $('meta[name="csrf-token"]').attr('content');
                
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': csrf
                    },
                    url: '/api/admin/permissions/create',
                    type: 'POST',
                    data: {
                        name: $('[name="name"]').val(),
                        admin_access: CheckOrNot("admin_access"),
                        admin_pages: CheckOrNot("admin_pages"),
                        admin_events: CheckOrNot("admin_events"),
                        admin_news: CheckOrNot("admin_news"),
                        admin_messages: CheckOrNot("admin_messages"),
                        admin_banners: CheckOrNot("admin_banners"),
                        admin_newsletter: CheckOrNot("admin_newsletter"),
                        admin_users: CheckOrNot("admin_users"),
                        admin_permissions: CheckOrNot("admin_permissions"),
                        admin_maintenance: CheckOrNot("admin_maintenance")
                    },
                    dataType: 'json',
                    success: function(json) {
                        console.log(CheckOrNot("admin_access"));
                        if(json.status == 'success') {
                            $('[name="create"]').prop('disabled', false);
                            $('[name="create"]').html('Créer le groupe');
                            $('#create').hide();
                            $('#home').fadeIn(500);
                            $.gritter.add({
                                title: "Notification",
                                text: json.response
                            });
                        } else {
                            $('[name="create"]').prop('disabled', false);
                            $('[name="create"]').html('Créer le groupe');
                            $.gritter.add({
                                title: "Notification",
                                text: json.response,
                            });
                        }
                    },
                    error: function (request, status, error) { 
                        $('[name="create"]').prop('disabled', false);
                        $('[name="create"]').html('Créer le groupe');
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
