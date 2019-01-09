<div id="sidebar" class="sidebar">
    <div data-scrollbar="true" data-height="100%">
        <ul class="nav">
            <li class="nav-profile">
                <a href="javascript:;" data-toggle="nav-profile">
                    <div class="cover with-shadow"></div>
                    <div class="info">
                        <b class="caret pull-right"></b>
                        <?= $user->Firstname() ?>
                        <?= $user->Lastname() ?>
                        <small>
                            <?= $user->NameGroup() ?>
                        </small>
                    </div>
                </a>
            </li>
            <li>
                <ul class="nav nav-profile">
                    <li>
                        <a href="/admin/settings"><i class="fa fa-cog"></i> Paramètres</a>
                    </li>
                    <li>
                        <a href="/admin/logout"><i class="fa fa-power-off"></i> Déconnexion</a>
                    </li>
                </ul>
            </li>
        </ul>
        <ul class="nav">
            <li class="nav-header">Navigation</li>
            <li class="<?php if($page == 'home') { echo 'active'; } ?> has-sub">
                <a href="/admin/">
                    <i class="fa fa-home"></i>
                    <span>Accueil</span>
                </a>
            </li>
            <li class="<?php if($page == 'pages') { echo 'active'; } ?> has-sub">
                <a href="/admin/pages">
                    <i class="fa fa-columns"></i>
                    <span>Gestion des pages</span>
                </a>
            </li>
            <li class="<?php if($page == 'events') { echo 'active'; } ?> has-sub">
                <a href="/admin/events">
                    <i class="fa fa-calendar-alt"></i>
                    <span>Gestion des événements</span>
                </a>
            </li>
            <li class="<?php if($page == 'news') { echo 'active'; } ?> has-sub">
                <a href="/admin/news">
                    <i class="fa fa-newspaper"></i>
                    <span>Gestion de l'actualité</span>
                </a>
            </li>
            <li class="<?php if($page == 'messages') { echo 'active'; } ?> has-sub">
                <a href="/admin/messages">
                    <i class="fa fa-comment-alt"></i>
                    <span>Gestion des messages</span>
                </a>
            </li>
            <li class="<?php if($page == 'banners') { echo 'active'; } ?> has-sub">
                <a href="/admin/banners">
                    <i class="fa fa-scanner-touchscreen"></i>
                    <span>Gestion des bannières</span>
                </a>
            </li>
            <li class="nav-header">Outils</li>
            <li class="<?php if($page == 'newsletter') { echo 'active'; } ?> has-sub">
                <a href="/admin/newsletter">
                    <i class="fa fa-envelope"></i>
                    <span>Newsletter</span>
                </a>
            </li>
            <li class="nav-header">Paramètres</li>
            <li class="<?php if($page == 'users') { echo 'active'; } ?> has-sub">
                <a href="/admin/users">
                    <i class="fa fa-users"></i>
                    <span>Utilisateurs</span>
                </a>
            </li>
            <li class="<?php if($page == 'permissions') { echo 'active'; } ?> has-sub">
                <a href="/admin/permissions">
                    <i class="fa fa-lock"></i>
                    <span>Permissions</span>
                </a>
            </li>
            <li>
                <a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a>
            </li>
        </ul>
    </div>
</div>