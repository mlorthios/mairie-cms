<nav class="navbar navbar-inverse">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Menu</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div id="navbar" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li <?php if($pageid == '0') { echo 'class="active"'; } ?>><a href="/"><i class="fa fa-home"></i> Accueil</a></li>
                        
                        <?php
                        
                        $Navigator = $db->query('SELECT * FROM navigator ORDER BY number');
                        
                        while($a = $Navigator->fetch()) {
                            $Pages = $db->prepare('SELECT COUNT(*) AS nb FROM pages WHERE navigator_id = ?');
                            $Pages->execute(array($a['id']));
                            $fetch = $Pages->fetch();
                            if($fetch['nb'] > 1) {
                                echo '<li class="';
                                
                                $CheckActive = $db->prepare('SELECT * FROM pages WHERE url = ?');
                                $CheckActive->execute(array($pageid));
                                $FetchActive = $CheckActive->fetch();
                                
                                if($FetchActive['navigator_id'] == $a['id']) {
                                    echo 'active';
                                }
                                echo ' dropdown"><a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="'.$a['icon'].'"></i> '.$a['name'].' <span class="caret"></span></a>
                                <ul class="dropdown-menu">';
                                    $Pages = $db->prepare('SELECT * FROM pages WHERE navigator_id = ? ORDER BY number');
                                    $Pages->execute(array($a['id']));
                                    
                                    while($b = $Pages->fetch()) {
                                        echo '<li><a href="/pages/'.$b['url'].'">'.$b['name'].'</a></li>';
                                    }
                                echo '</ul>
                                </li>';
                            }
                        }
                        
                        ?>
                    </ul>
                </div>
            </div>
        </nav>