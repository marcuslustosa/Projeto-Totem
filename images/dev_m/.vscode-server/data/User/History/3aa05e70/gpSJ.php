<section id="section7" class="p-t-1 equalize">
    <!-- style=background-image:url(homepages/branding/images/background-4.png); background-position:71% 22%; -->
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-lg-12">
                        <h2 class="m-b-10 font_color" style="color:{{studioExtra('lp_main_color', $studio->id)}} !important;">Entre em
                            Contato Conosco!</h2>
                        <p class="lead"></p>
                    </div>
                    <div id="box-info_studio" class="col-lg-6 m-b-30 d-flex justify-content-between w-100">
                        <div>
                            <strong>ENDEREÇO</strong><br>
                            @if(!is_null($studio->address))
                            {{$studio->address->street . ' ' . $studio->address->number . ' - '.
                            $studio->address->extra}} <br>
                            {{$studio->address->city .'/'. $studio->address->state}}<br>
                            @endif
                        </div>
                        <div>
                            <strong>Telefone:</strong> {{$studio->phone}}
                            <br>
                            <!-- <strong>Whatsapp:</strong> {{$studio->whatsapp}}
                            <br> -->
                            <strong>Email:</strong> {{$studio->email}}
                        </div>
                    </div>
                    <div class="col-lg-12 m-b-30">
                        <h4 class="font_color" style="color:{{studioExtra('lp_main_color', $studio->id)}} !important;">
                            Nossas Redes Sociais</h4>
                        <div class="social-icons social-icons-light social-icons-colored-hover">
                            <ul>
                                <!-- facebook  -->
                                @if(!empty(studioExtra('lp_social_facebook', $studio->id)))
                                <li class="social-facebook">
                                    <a href="{{studioExtra('lp_social_facebook', $studio->id)}}">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    @endif
                                </li>

                                <!-- instagram  -->
                                @if(!empty(studioExtra('lp_social_instagram', $studio->id)))
                                <li class="social-instagram">
                                    <a href="{{studioExtra('lp_social_instagram', $studio->id)}}">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                    @endif
                                </li>

                                <!-- linkedin  -->
                                @if(!empty(studioExtra('lp_social_linkedin', $studio->id)))
                                <li class="social-linkedin">
                                    <a href="{{studioExtra('lp_social_linkedin', $studio->id)}}">
                                        <i class="fab fa-linkedin"></i>
                                    </a>
                                    @endif
                                </li>

                                <!-- youtube  -->
                                @if(!empty(studioExtra('lp_social_youtube', $studio->id)))
                                <li class="social-youtube">
                                    <a href="{{studioExtra('lp_social_youtube', $studio->id)}}">
                                        <i class="fab fa-youtube"></i>
                                    </a>
                                    @endif
                                </li>

                                <!-- tiktok  -->
                                @if(!empty(studioExtra('lp_social_tiktok', $studio->id)))
                                <li class="social-tiktok">
                                    <a href="{{studioExtra('lp_social_tiktok', $studio->id)}}">
                                        <i class="fab fa-tiktok"></i>
                                    </a>
                                    @endif
                                </li>

                                <!-- twitter  -->
                                @if(!empty(studioExtra('lp_social_twitter', $studio->id)))
                                <li class="social-twitter">
                                    <a href="{{studioExtra('lp_social_twitter', $studio->id)}}">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                    @endif
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 offset-1">
                <form id='contact-form' class="widget-contact-form" novalidate action="{{route('studios.lead')}}" role="form" method="post">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="name">Nome</label>
                            <input type="text" aria-required="true" name="name" id="name-contact" class="form-control required" placeholder="Insira seu nome">
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="upper" for="phone">Celular</label>
                            <input type="text" class="form-control required" name="mobile" id="mobile-contact" placeholder="(00)00000-0000" aria-required="true">
                        </div>
                    </div>
                    <div class="row">

                        <div class="form-group col-md-12">
                            <label for="email">E-mail</label>
                            <input type="email" aria-required="true" required name="email" id="email-contact" class="form-control required" placeholder="Insira seu E-mail">
                        </div>

                        <!-- <div class="form-group col-md-6 col-lg-6">
                            <label>Interesses</label>
                            <select class="form-select" name="services">
                                <option value="">Selecione seu interesse</option>
                                <option value="dores_art">Dores nas Articulações</option>
                                <option value="idosos">Idosos</option>
                                <option value="gestantes">Gestantes</option>
                                <option value="fisioterapia">Fisioterapia</option>
                            </select>
                        </div> -->
                    </div>
                    <input type="hidden" id="studio_id" name="studio_id" value="{{$studio->id}}" />
                    <div class="form-group">
                        <label for="message">Mensagem</label>
                        <textarea type="text" name="notes" rows="8" id="notes-contact" class="form-control required" placeholder="Insira sua mensagem"></textarea>
                    </div>
                    <div class="form-group">
                        <a class="btn btn-light" id="form-submit" onclick="submitContactForm()" style="background-color:{{studioExtra('lp_main_color', $studio->id)}} !important; border: none !important;"><i class="fa fa-paper-plane"></i>&nbsp;Enviar
                            Mensagem</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</section>
