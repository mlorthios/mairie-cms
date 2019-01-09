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
				<div class="row" id="home">
                    <div class="col-md-12" id="__message-alert"></div>
					<div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                Newsletter
                            </div>
                            <div class="card-body">
                                <?php if($newsletter->Data('active') == 0) { ?>
                                <button type="submit" name="newsletter" class="btn btn-primary btn-block">Activer la newsletter</button>
                                <?php } else { ?>
                                <button type="submit" name="newsletter" class="btn btn-danger btn-block">Désactiver la newsletter</button>
                                <?php } ?>
                            </div>
                        </div>
                        <button type="button" name="open_message" class="btn btn-success btn-block">Envoyer un message aux inscrits</button>
                    </div>
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                Les inscrits à la newsletter
                            </div>
                            <div class="table-responsive" style="max-height: 450px; overflow: auto">
								<table class="table table-striped m-b-0">
									<thead>
										<tr>
											<th>Adresse e-mail</th>
											<th width="1%"></th>
										</tr>
									</thead>
									<tbody>
										<?php
                                        
                                        $g = $db->query('SELECT * FROM newsletter_registered');
                                        
                                        while($r = $g->fetch()) {
                                            echo '<tr id="email'.$r['id'].'">
											<td>'.$r['email'].'</td>
											<td class="with-btn" nowrap="">
												<a href="#" onclick="Delete('.$r['id'].')" class="btn btn-sm btn-white">Supprimer</a>
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
                <div class="row" style="display: none" id="message">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label>Objet</label>
                            <input class="form-control form-control-lg" name="object" placeholder="Objet">
                        </div>
                        <div class="form-group">
                            <label>Message</label>
                            <textarea id="summernote" class="summernote" name="content"></textarea>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary btn-block" name="send">Envoyer</button>
                        <button class="btn btn-danger btn-block" name="back_message">Retour</button>
                        <div style="display: none; margin-top: 10px" id="progress" class="progress rounded-corner">
                            <div class="progress-bar" style="width: 0%;">Chargement</div>
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
            
            $('[name="open_message"]').click(function() {
                $('#home').hide();
                $('#message').fadeIn(500);
            });
            
            $('[name="back_message"]').click(function() {
                $('#message').hide();
                $('#home').fadeIn(500);
            });
            
            $("#summernote").summernote({
                placeholder:"Personnalisez votre message !",
                lang: 'fr-FR',
                callbacks: {
                    onImageUpload: function(files) {
                        $('#progress').show();
                        sendFile(files[0]);
                    }
                }
            });

            function sendFile(file) {
                var csrf = $('meta[name="csrf-token"]').attr('content');
                data = new FormData();
                data.append("file", file);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': csrf
                    },
                    data: data,
                    dataType: 'json',
                    type: "POST",
                    processData: false,
                    contentType: false,
                    xhr: function() {
                        var myXhr = $.ajaxSettings.xhr();
                        if (myXhr.upload) myXhr.upload.addEventListener('progress',progressHandlingFunction, false);
                        return myXhr;
                    },
                    url: "/api/admin/pages/summernote/add/img",
                    success: function(json) {
                        if(json.status == 'success') {
                            console.info('Importation success')
                            var url = json.response;
                            $('#summernote').summernote('insertImage', 'http://localhost' + json.response);
                        } else {
                            $.gritter.add({
                                title: "Notification",
                                text: json.response
                            });
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.error(textStatus + " " + errorThrown);
                    }
                });
            }
            
            function progressHandlingFunction(e){
                if(e.lengthComputable){
                    var percentComplete = (e.loaded / e.total) * 100
                    $('div.progress-bar').css({ "width": percentComplete + "%", });
                    if (e.loaded == e.total) {
                        $('div.progress-bar').css({ "width": percentComplete + "%" });
                        setTimeout(function() {
                            $('#progress').hide();
                            $('div.progress-bar').css({ "width": "0%" });
                        }, 2200);
                    }
                }
            }
            
            function Delete(id) {
                $('#email'+id).hide();
                
                if(confirm('Voulez-vous vraiment supprimer cette adresse e-mail ?')) {
                    var csrf = $('meta[name="csrf-token"]').attr('content');

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': csrf
                        },
                        data: {
                          email: id  
                        },
                        dataType: 'json',
                        type: "POST",
                        url: "/api/admin/newsletter/email_delete",
                        success: function(json) {
                            if(json.status == 'success') {
                                $('#email'+id).remove();
                                $.gritter.add({ 
                                    title: "Notification",
                                    text: json.response
                                });
                            } else {
                                $('#email'+id).show();
                                $.gritter.add({
                                    title: "Notification",
                                    text: json.response
                                });
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            $('#email'+id).show();
                            $.gritter.add({
                                title: "Notification",
                                text: 'Une erreur est survenue : ' + textStatus + " " + errorThrown
                            });
                        }
                    });
                    
                } else {
                    $('#email'+id).show();
                    $.gritter.add({
                        title: "Notification",
                        text: 'Vous avez annuler la suppression de l\'adresse e-mail'
                    });
                }
            }
            
            $('[name="newsletter"]').click(function() {
                $('[name="newsletter"]').prop('disabled', true);
                $('[name="newsletter"]').html('Modification des paramètres en cours');
                
                var csrf = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': csrf
                    },
                    dataType: 'json',
                    type: "POST",
                    url: "/api/admin/newsletter/status",
                    success: function(json) {
                        if(json.status == 'success') {
                            $('[name="newsletter"]').prop('disabled', false);
                            if(json.nb == '1') {
                                $('[name="newsletter"]').html('Désactiver la newsletter');
                                $('[name="newsletter"]').attr("class","btn btn-danger btn-block");
                            } else if(json.nb == '0') {
                                $('[name="newsletter"]').html('Activer la newsletter');
                                $('[name="newsletter"]').attr("class","btn btn-primary btn-block");
                            }
                            $.gritter.add({ 
                                title: "Notification",
                                text: json.response
                            });
                        } else {
                            $.gritter.add({
                                title: "Notification",
                                text: json.response
                            });
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        $.gritter.add({
                            title: "Notification",
                            text: 'Une erreur est survenue : ' + textStatus + " " + errorThrown
                        });
                    }
                });
            });
            
            $('[name="send"]').click(function() {
                $('[name="send"]').prop('disabled', true);
                $('[name="send"]').html('Envoie en cours');
                
                var csrf = $('meta[name="csrf-token"]').attr('content'),
                    object = $('[name="object"]').val(),
                    content = $('[name="content"]').val();

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': csrf
                    },
                    data: {
                        object: object,
                        content: content
                    },
                    dataType: 'json',
                    type: "POST",
                    url: "/api/admin/newsletter/create",
                    success: function(json) {
                        if(json.status == 'success') {
                            $('[name="send"]').prop('disabled', false);
                            $('[name="send"]').html('Envoyer');
                            $('[name="object"]').val('');
                            $('[name="content"]').summernote("reset");
                            $('#message').hide();
                            $('#home').fadeIn(500);
                            $.gritter.add({ 
                                title: "Notification",
                                text: json.response
                            });
                        } else {
                            $('[name="send"]').prop('disabled', false);
                            $('[name="send"]').html('Envoyer');
                            $.gritter.add({
                                title: "Notification",
                                text: json.response
                            });
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        $.gritter.add({
                            title: "Notification",
                            text: 'Une erreur est survenue : ' + textStatus + " " + errorThrown
                        });
                    }
                });
            });
		</script>
	</body>
</html>
