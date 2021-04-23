<?php
$lang = 'fr_FR'; //lang
//Chargement du fichier de configuration
$config = json_decode(file_get_contents("https://infopolitiquepresse.com/data/config.json"));
//chargement de la base de donnée
$databaseJson = file_get_contents("https://infopolitiquepresse.com/data/journaux/_FR.json");

?> 

<!DOCTYPE html>
<html lang='fr'>
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Paul Martinez">
        <title>Info Politique Presse | Application</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="color-scheme" content="dark light">

        <!--Apple meta tags-->
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">

        <!-- Icons tags -->
        <link rel="apple-touch-icon" sizes="57x57" href="/icons/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="/icons/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="/icons/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="/icons/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="/icons/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="/icons/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="/icons/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="/icons/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="/icons/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="/icons/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/icons/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="/icons/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/icons/favicon-16x16.png">
        <link rel="manifest" href="/icons/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="/icons/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">


        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <!--<link rel="stylesheet" href="https://infopolitiquepresse.com/css/style2.css">-->
        <link rel="stylesheet" href="css/appstyle.css">
        <link rel="stylesheet" href="css/palette.css">
        <link rel="stylesheet" href="css/application_ux.css">   
		<link rel="stylesheet" href="css/application_responsive.css">   

        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet"> 

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>                <!-- jQuery -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>       <!-- Popper JS -->

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">  <!-- Bootstrap icons -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>


        <?php // /*premiere visite*/ if (!isset($_COOKIE['uuid'])) { echo "<script async='true' defer='true' src='js/static.firsttime.js'></script>"; } ?>
        <?php echo "<script> const jsonDB = '".(string)$databaseJson."' </script>" ?>
    </head>
<body class='bg-dark'>
    <div class="application-wrapper">

        <header style="width: 100%;">
            <nav class='navbar bg-main'>
                <div class='navbar-container'>
					<a href="../"><img class="navbar-logo" src="/media/logo/rounded/logo-rounded-white-64.png" height="36px"></a>
					<a href="../" class='navbar-brand text-white'>Info Politique Presse <span class='navbar-brand-badge bg-gray-800 text-secondary'>Application</span></a>
                    <div class="navbar-collapse collapse" id="collapseNavigation">
                    	<ul class="navbar-nav">
                        	<li class="nav-item">
                        	    <button class='btn bg-main hoverable nav-link' onclick="$('#updateModal').css('display', 'block').addClass('show fade')">
                        	        <i class="bi bi-info-circle pe-2"></i>Notes de mise à jour
                        	    </button>
                        	</li>
                        	<li class="nav-item">
                        	    <button class='btn bg-main hoverable nav-link' onclick="$('#helpModal').css('display', 'block').addClass('show fade')">
                        	        <i class="bi bi-question-circle pe-2"></i>Aide
                        	    </button>
							</li>
							<li class="nav-item">
								<button id="fsc-btn" class='btn bg-main hoverable nav-link' onclick="openFullscreen()" data-isFullscreen="false" title="Mettre la page en plein écran (F)">
									<i class="bi bi-fullscreen"></i>
								</button>
							</li>
						</ul>
					</div>
					<button class="btn btn-menu bg-main hoverable nav-link" onclick="$('.navbar-collapse').toggleClass('show');$('.navbar-container').toggleClass('mobile-open')">
						<i class="bi bi-list"></i>
					</button>
                </div>
            </nav>
        </header>

        <div class="dashboard-container">

            <div class="dashboard-item dashboard-secondary">

                <aside id='js-side-info' class='aInf dashboard-infos bg-main'>
                    <div class='aInf-container'></div>
                </aside>

            </div>

            <div class="dashboard-item dashboard-main">

				<section class='app-plot'>
					<div id='plot' class='plot-container text-light'>
						<svg id='app-graph-svg-plot' height='100%' width='100%'>
							<defs>
								<style>
									.cls {
										stroke:none;
										stroke-miterlimit:10;
									}
									.txt {
										font-size: 1.5vh;
									}
								</style>
							</defs>
							<!--Support-->
							<rect class="cls" x="0" y="0" width="50%" height="50%" fill="#903"/>
							<rect class="cls" x="0" y="50%" width="50%" height="50%" fill="#390"/>
							<rect class="cls" x="50%" y="50%" width="50%" height="50%" fill="#609"/>
							<rect class="cls" x="50%" y="0" width="50%" height="50%" fill="#135390"/>
							<line x1="50%" y1="0" x2="50%" y2="100%" stroke-linecap="round" stroke-width="2" stroke="#fff"></line>
							<line x1="0" y1="50%" x2="100%" y2="50%" stroke-linecap="round" stroke-width="2" stroke="#fff"></line>
							<text class='txt' x="1%" y="49%" fill="white">Gauche</text>
							<text class='txt' x="95.5%" y="49%" fill="white">Droite</text>
							<text class='txt' x="51%" y="3%" fill="white">Autoritaire</text>
							<text class='txt' x="51%" y="98%" fill="white">Libertarien</text>
						</svg>

						<div>
							<div id="pol-socialDemocratique" data-name="Social Démocratique" title="Social démocratique" class="pol" style='left:0; top:40%; width:40%; height:20%;'>
								<p>Social Démocratique</p>
							</div>
							<div id="pol-centriste" data-name="Centriste" title="Centriste" class="pol" style='left:40%; top:40%; width:20%; height:20%;'>
								<p>Centriste</p>
							</div>
							<div id="pol-liberalismeLibertaires" data-name="Liberalisme Libertaire" title="Liberalisme Libertaire" class="pol" style='left:40%; top:60%; width:20%; height:40%;'>
								<p>Liberalisme Libertaire</p>
							</div>
							<div id="pol-anarchoSyndycalisme" data-name="Anarcho-syndycalisme" title="Anarcho-syndycalisme" class="pol" style='left:10%; top:60%; width:30%; height:40%;'>
								<p>Anarcho-syndycalisme</p>
							</div>
							<div id="pol-anarchoCommunisme" data-name="Anarcho-communisme" title="Anarcho-communisme" class="pol" style='left:0; top:60%; width:10%; height:40%;'>
								<p>Anarcho-communisme</p>
							</div>
							<div id="pol-trotskysme" data-name="Trotskysme" title="Trotskysme" class="pol" style='left:0; top:20%; width:10%; height:20%;'>
								<p>Trotskysme</p>
							</div>
							<div id="pol-maoisme" data-name="Maoisme" title="Maoisme" class="pol" style='left:0; top:0; width:10%; height:20%;'>
								<p>Maoisme</p>
							</div>
							<div id="pol-marxismeLeninisme" data-name="Marxisme Léninisme" title="Marxisme leninisme" class="pol" style='left:10%; top:0; width:25%; height:20%;'>
							<p>Marxisme Léninisme</p>
							</div>
							<div id="pol-populismeDeGauche" data-name="Populisme de Gauche" title="Populisme de gauche" class="pol" style='left:10%; top:20%; width:40%; height:20%;'>
								<p>Populisme de Gauche</p>
							</div>
							<div id="pol-capitalismeDEtat" data-name="Capitalisme d'Etat" title="Capitalisme d'etat" class="pol" style='left:35%;top:0; width:30%; height:20%;'>
								<p>Capitalisme d'Etat</p>
							</div>
							<div id="pol-populismeDeDroite" data-name="Populisme de Droite" title="Populisme de droite" class="pol" style='left:50%; top:20%; width:40%; height:20%;'>
								<p>Populisme de Droite</p>
							</div>
							<div id="pol-nationalSocialisme" data-name="National-socialisme" title="National-socialisme" class="pol" style='left:82.5%; top:0; width:17.5%; height:20%;'>
								<p>National-socialisme</p>
							</div>
							<div id="pol-fascisme" data-name="Fascisme" title="Fascisme" class="pol" style='left: 65%; top:0; width: 17.5%; height: 20%;'>
								<p>Fascisme</p>
							</div>
							<div id="pol-royalisme" data-name="Royalisme" title="Royalisme" class="pol" style='left:90%; top:20%;width:10%; height:40%;'>
								<p>Royalisme</p>
							</div>
							<div id="pol-conservatisme" data-name="Conservatisme" title="Conservatisme" class="pol" style='left:60%; top:40%; width:30%; height:20%;'>
								<p>Conservatisme</p>
							</div>
							<div id="pol-liberalisme" data-name="Libéralisme" title="Libéralisme" class="pol" style='left: 60%; top:60%; width:20%; height:30%;'>
								<p>Libéralisme</p>
							</div>
							<div id="pol-néoLiberalisme" data-name="Néo Libéralisme" title="Néo Libéralisme" class="pol" style='left: 80%; top: 60%; width: 20%; height: 30%;'>
								<p>Néo Libéralisme</p>
							</div>
							<div id="pol-anarchoCapitalisme" data-name="Anarcho-capitalisme" title="Anarcho-capitalisme" class="pol" style='left:60%; top:90%; width:40%; height: 10%'>
								<p>Anarcho-capitalisme</p>
							</div>      
						</div>

						<div id="med-point" class="bg-main" style="height: .75vh; width: .75vh; border-radius: 50px; position: absolute; display: none;"></div>
					</div>
				</section>

				<aside id='js-side-panel' class='app-aside right--anchor bg-main'>
					<div id='js-side-list-settings' class='app-aside-head'>
						<div class='app-searcharea'>
							<input type="text" id="searchInput" placeholder="Recherche.." value='<?php if (isset($_GET['search'])) { echo $_GET['search']; }; ?>' autocomplete='off' title="Tapez le nom d'un journal (Shift + Y)" >
							<button id='searchCancel' class='app-aside-close-button point' title='Effacer la recherche (Shift + G)' onclick="emptySearchbar()">
								<i class="bi bi-x unselectable"></i>
							</button>
							<button id='searchButton' class='app-aside-search-button point' style="border-radius: 0 .25rem .25rem 0 !important; border-left: none !important; flex-grow: 1;">
								<i class="bi bi-search unselectable"></i>
							</button>
						</div>
						<div class='app-aside-settings'>
							<span class='app-aside-settings-filter'>
								<select id='filter' onchange='List.sort()'>
									<option value='default' selected>Filtrer par nom A-Z</option>
									<option value='reverse'>Filtrer par nom Z-A</option>
								</select>
							</span>
                          	<span style="display: block; flex-grow: 14 !important"></span>
							<button id='itemDeselector' class='app-aside-search-button point' title='Effacer la sélection (K)' style='display: none; border-radius: .25rem !important; flex-grow: 1' onclick='List.deselect()'>
								<i class="bi bi-dash-square-fill unselectable"></i>
							</button>
						</div>
					</div> 
					<div id='js-list' class='app-aside-list'></div>
				</aside>  

            </div>

        </div>


        <div id="updateModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-card text-light text-justify" style="border: none; padding: 2rem 1rem; padding-bottom: .25rem !important; display: flex;">
                        <h3 id="updateModalLabel" style="font-size: 2em; margin-left: 1rem;" class="modal-title text-primary">Notes de mise à jour</h3>
                    </div>
                    <div class="modal-body bg-card text-light" style="padding: .25rem 2rem !important">
                        <h2>Version <?php echo $config->version->title ?></h2>
                        <i class="text-secondary" style="margin-bottom: .1em !important"><?php echo $config->patchnotes->warn ?></i>
						<div style="margin: 1.5em 0">
							<h2 style="margin: .25rem 0; font-weight: 600;">Ajouts de la version</h2>
							<ul style="list-style: none;">
								<?php 
									$updates = $config->patchnotes->last;
									foreach($updates as $item)
									{
									echo "<li>$item</li>";
									}
								?>
							</ul>
						</div>
						<div style="margin: .75em 0">
							<h4 style="margin: .25rem 0; font-weight: 600;">Versions antérieures</h4>
							<ul style="list-style: none; font-size: .8rem;">	
								<?php 
									$updates = $config->patchnotes->previous;
									foreach($updates as $item)
									{
									echo "<li>$item</li>";
									}
								?>
							</ul>
						</div>
                    </div>
                    <div class="modal-footer bg-card text-light" style='border: none; padding-top: .1rem !important;'>
						<button class="btn bg-card hoverable nav-link" type="button" onclick="$('#updateModal').removeClass('show fade').css('display', 'none')">
                            <i class="bi bi-x pe-2"></i>Fermer
                        </button>
					</div>
                </div>
            </div>
        </div>
        
        <div id="helpModal" class="modal fade" role="dialog" data-ipp-firsttime="true">
            <div class="modal-dialog">
                <div class="modal-content" data-ipp-help-active=1>
                    <div id="helpModal1" class="tab bg-card">
                        <div class="modal-header bg-card text-primary text-justify" style='border: none; padding: 3rem 1rem; display: flex;'>
                            <img src="https://infopolitiquepresse.com/media/logo/rounded/logo-rounded-white-512.png" height="192rem" style="margin-left: auto; margin-right: 1rem;">
                            <h3 style="font-size: 3em; font-weight: 500; margin-right: auto;">Info<br>Politique<br>Presse.</h3>
                        </div>
                        <div class="modal-body bg-card text-light" style="padding: 1.5rem;">
                            <p style="font-size: 1.25rem; line-height: 150%;">
                                Bienvenue sur l'application Info Politique Presse.<br>
                                Si vous ne connaissez pas encore l'application, vous pouvez avoir un aperçu des fonctionnalités en cliquant sur le bouton "Suivant".
                            </p>
                        </div>
                    </div>
					<div id="helpModal2" class="tab bg-card">
                        <div class="modal-header bg-card text-primary text-justify" style='border: none; padding: 3rem 1rem; display: flex;'>
							<img src="../media/ressources/help/helpaffichage.svg" height="192rem" style="margin: auto">
                        </div>
                        <div class="modal-body bg-card text-light" style="padding: 1.5rem;">
                            <p style="font-size: 1.25rem; line-height: 150%;">
                                L'application comporte 3 panneaux principaux.<br>
								L'échiquier central permet de visualiser les médias dans l'espace politique français.<br>
                            </p>
                        </div>
                    </div>
                    <div id="helpModal3" class="tab bg-card">
                        <div class="modal-header bg-card text-primary text-justify" style='border: none; padding: 3rem 1rem; display: flex;'>
							<img src="../media/ressources/help/helpliste.svg" height="192rem" style="margin-left: auto; margin-right: 1rem;">
                            <h3 style="font-size: 3em; font-weight: 500; margin-right: auto;">Parcourir<br>la liste.</h3>
                        </div>
                        <div class="modal-body bg-card text-light" style="padding: 1.5rem;">
                            <p style="font-size: 1.25rem; line-height: 150%;">
                                Utilisez la liste à droite de votre écran pour rechercher un média français et obtenir des informations.
                            </p>
                        </div>
                    </div>
					<div id="helpModal4" class="tab bg-card">
                        <div class="modal-header bg-card text-primary text-justify" style='border: none; padding: 3rem 1rem; display: flex;'>
							<img src="../media/ressources/help/helpselection.svg" height="192rem" style="margin-left: auto; margin-right: 1rem;">
                            <h3 style="font-size: 3em; font-weight: 500; margin-right: auto;">Comparer<br>des médias.</h3>
                        </div>
                        <div class="modal-body bg-card text-light" style="padding: 1.5rem;">
                            <p style="font-size: 1.25rem; line-height: 150%;">
                                En sélectionnant des médias dans la liste, vous pourrez les comparer.<br>
								Un point médian de l'orientation s'affichera sur l'échiquier.
                            </p>
                        </div>
                    </div>
					
					<!--
                    <div class="tabs-viewer bg-card">
                        <i class="bi bi-circle-fill text-primary"></i>
                        <i class="bi bi-circle text-secondary"></i>
                    </div>
					-->
                    <div class="modal-footer bg-card text-light" style='border: none; padding-top: .1rem !important;'>
                        <button id="helpBackBtn" class="btn bg-alt hoverable nav-link" type="button" style="margin-right: auto;" onclick="helpPrev()">
                            <i class="bi bi-arrow-left-circle pe-2"></i>Retour
                        </button>
                        <button id="helpCloseBtn" class="btn bg-main hoverable nav-link" type="button" onclick="helpClose()">
                            <i class="bi bi-x pe-2"></i>Fermer
                        </button>
                        <button id="helpNextBtn" class="btn bg-alt hoverable nav-link" type="button" style="color: #57D8A3 !important" onclick="helpNext()">
                            <i class="bi bi-arrow-right-circle pe-2"></i>Suivant
                        </button>
                    </div>
                </div>
            </div>  
        </div>  

    </div>
        


	<script src="js/ipp-framework.js" async></script>
    <script src="js/application.js" async></script>
	<script src="js/static.firsttime.js" async></script>
	<script src="js/shortcuts.js" async></script>

</body>
</html> 