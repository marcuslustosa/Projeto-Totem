<div class="modal fade" id="modal" tabindex="-1" role="modal" aria-labelledby="modal-label" aria-hidden="true"
    style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-label"
                    style="color:{{studioExtra('lp_main_color', $studio->id)}} !important;">Deseja ir para o WhatsApp?
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form action="{{route('studios.lead')}}" method="post">
                    @csrf
                    <input type="hidden" id="user_id" name="user_id" value="{{$studio->id}}">

                    <input type="hidden" id="campaign_id" name="campaign_id"
                        value="{{isset($campaign) ? $campaign->id : 0}}">
                    <input type="hidden" id="origin" name="origin" value="{{isset($origin) ? $origin: 0}}">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Nome <small style="color: #bebebe;">(Opcional)</small></label>
                                <input type="text" aria-required="true" name="name" id="name-whats"
                                    class="form-control name" placeholder="Insira seu Nome">
                            </div>
                            <div class="form-group m-b-5">
                                <label for="email">E-mail <small style="color: #bebebe;">(Opcional)</small></label>
                                <input type="email" aria-required="true" name="email" id="email-whats"
                                    class="form-control email" placeholder="Insira seu E-mail">
                            </div>
                            <div class="form-group m-b-5">
                                <label for="name">Celular <small style="color: #bebebe;">(Opcional)</small></label>
                                <input placeholder="(DDD) 00000-0000" class="form-control" type="text" id="mobile-whats"
                                    name="mobile">
                            </div>
                            <div class="text-start form-group">
                            </div>
                        </div>

                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-b" data-bs-dismiss="modal"
                    style="background-color:{{studioExtra('lp_main_color', $studio->id)}} !important; border:none;">Fechar</button>
                <a href="#" class="btn btn-b" onclick="submitWhatsAppForm('{{$studio->whatsapp}}')"
                    style="background-color:{{studioExtra('lp_main_color', $studio->id)}} !important; border:none;">Ir
                    para o WhatsApp</a>
            </div>
            </form>
        </div>
    </div>
</div>
