<div id="header" data-responsive-fixed="true" data-fullwidth="true" class="dark submenu-light">
    <div class="header-inner">
        <div class="container" style="background-color:{{studioExtra('lp_header_bg_color', $studio->id)}} !important">
            <div id="logo" class="box_logo">
                <img style="margin-left: 20px;" height="60" src="{{s3Image($studio['logo_'.studioExtra('lp_header_logo', $studio->id)])}}">
            </div>
            <div class="header-extras">
                <ul>
                    <li class="d-none d-xl-block d-lg-block">
                        <a href="#section7" class="btn btn-roundeded btn-light" style="background-color:{{studioExtra('lp_main_color', $studio->id)}} !important; border: none !important;">Entrar
                            em
                            Contato</a>
                    </li>
                </ul>
            </div>
            <div id="mainMenu-trigger">
                <button class="lines-button x"> <span class="lines"></span></button>
            </div>
            <div id="mainMenu" class="menu-center light menu-one-page">
                <div class="container">
                    <nav>
                        <ul>
                            <li><a href="#slider" style="color:{{studioExtra('lp_header_text_color', $studio->id)}} !important">Início</a>
                            </li>
                            <li><a href="#section2" style="color:{{studioExtra('lp_header_text_color', $studio->id)}} !important">Galeria</a>
                            </li>
                            <li><a href="#section5" style="color:{{studioExtra('lp_header_text_color', $studio->id)}} !important">Equipe</a>
                            </li>
                            <li><a href="#section7" style="color:{{studioExtra('lp_header_text_color', $studio->id)}} !important">Contato</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
