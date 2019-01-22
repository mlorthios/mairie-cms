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
                    <div class="col-md-10" style="margin-bottom: 15px">
                        <div class="form-group">
                            <input name="title" class="form-control form-control-lg" placeholder="Nom de page" type="text" value="<?= $fpage->Data($id, 'name') ?>">
                        </div>
                        <div class="form-group">
                            <input name="description" class="form-control form-control-lg" placeholder="Description" type="text" value="<?= $fpage->Data($id, 'description') ?>">
                        </div>
                        <textarea id="summernote" name="content"><?= $fpage->Data($id, 'content') ?></textarea>
                    </div>
                    <div class="col-md-2">
                        <div class="card">
						  <div class="card-header">
                              Attributs des pages
                            </div>
                            <div class="card-block">
                                <div class="form-group">
                                    <label>Parent</label>
                                    <select class="form-control" name="parent">
                                        <option value="0">Sans parent</option>
                                        <?php
    
                                        $Navig = $db->query('SELECT * FROM navigator ORDER BY number');
                                        
                                        while($n = $Navig->fetch()) {
                                            echo '<option '; 
                                            if($fpage->Data($id, 'navigator_id') == $n['id']) {
                                                echo 'selected ';
                                            }
                                            echo 'value="'.$n['id'].'">'.$n['name'].'</option>';
                                        }
    
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Ordre d'affichage</label>
                                    <input type="number" name="ordre" class="form-control" value="<?= $fpage->Data($id, 'number') ?>">
                                </div>
                            </div>
                        </div>
                        <button name="save" type="submit" class="btn btn-primary btn-block">Publier</button>
                        <input type="button" id="bdelete" onclick="DeletePage(<?= $id ?>)" class="btn btn-danger btn-block" value="Supprimer">
                        <a style="margin-bottom: 10px" href="/admin/pages" class="btn btn-success btn-block">Annuler</a>
                        <div style="display: none" id="progress" class="progress rounded-corner">
                            <div class="progress-bar" style="width: 0%;">Importation</div>
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
            
            $("#summernote").summernote({
                placeholder:"Personnalisez votre page facilement !",
                lang: 'fr-FR',
                callbacks: {
                    onImageUpload: function(files) {
                        $('#progress').show();
                        sendFile(files[0]);
                    }
                }
            });
            
            function DeletePage(id) {
                var csrf = $('meta[name="csrf-token"]').attr('content');
                if(confirm('Voulez-vous vraiment supprimer cette page ?')) {
                    $("[name='save']").prop('disabled', true);
                    $("#bdelete").prop('disabled', true);
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': csrf
                        },
                        type: "POST",
                        url: "/api/admin/pages/delete",
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function(json) {
                            if(json.status == 'success') {
                                $.gritter.add({
                                    title: "Notification",
                                    text: json.response
                                });
                                setTimeout(function() {
                                    window.location.href = '/admin/pages';
                                }, 2200);
                            } else {
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
                        text: 'Vous avez annulé la suppression de la page'
                    });
                }
            }
            
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
                    xhr: function() {
                        var myXhr = $.ajaxSettings.xhr();
                        if (myXhr.upload) myXhr.upload.addEventListener('progress',progressHandlingFunction, false);
                        return myXhr;
                    },
                    url: "/api/admin/pages/summernote/add/img",
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(json) {
                        if(json.status == 'success') {
                            console.info('Importation success')
                            var url = json.response;
                            $('#summernote').summernote('insertImage', json.response);
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
            
            $('[name="save"]').click(function() {
                $("[name='save']").prop('disabled', true);
                $("[name='save']").html('Publication en cours');
                var content = $('[name="content"]').val();
                var title = $('[name="title"]').val();
                var parent = $('[name="parent"]').val();
                var ordre = $('[name="ordre"]').val();
                var csrf = $('meta[name="csrf-token"]').attr('content');
                var desc = $('[name="description"]').val();
                if(content) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': csrf
                        },
                        url: '/api/admin/pages/edit',
                        type: 'POST',
                        data: { content: content, title: title, parent: parent, ordre: ordre, description: desc, id: <?php echo $id; ?> },
                        dataType: 'json',
                        success: function(json) {
                            if(json.status == 'success') {
                                $.gritter.add({
                                    title: "Notification",
                                    text: json.response
                                });
                                $("[name='save']").prop('disabled', false);
                                $("[name='save']").html('Publier');
                            } else {
                                $.gritter.add({
                                    title: "Notification",
                                    text: json.response,
                                });
                                $("[name='save']").prop('disabled', false);
                                $("[name='save']").html('Publier');
                            }
                        }
                    });
                } else {
                    $("[name='save']").prop('disabled', false);
                    $("[name='save']").html('Publier');
                    $.gritter.add({
                        title: "Notification",
                        text: "Veuillez entrer au minimum un caractère"
                    })
                }
            })
		</script>
	</body>
</html>
