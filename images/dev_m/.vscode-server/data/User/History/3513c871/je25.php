<div class="call-to-action background-image" style="background-color: darkgray;">
    <div class="container">
        <div class="row">
            <div class="col-lg-10">
                <h3 class="text-light">{{studioExtra('lp_callToAction_title', $studio->id, 'Agende Uma Aula Experimental! ')}}</h3>
                <p class="text-light">{{studioExtra('lp_callToAction_text', $studio->id, 'Melhore sua qualidade de vida, ganhe condicionamento físico, previna lesões e alivie dores.')}}</p>
            </div>
            <div class="col-lg-2">
                <a href="#" data-bs-target="#modal" data-bs-toggle="modal" class="btn btn-light btn-outline"
                    style="background-color:{{studioExtra('lp_main_color', $studio->id)}} !important; border: none !important;">
                    <i class="fa-brands fa-whatsapp" style="font-size:15px"></i>&nbsp;
                    {{studioExtra('lp_callToAction_button', $studio->id, 'Agendar')}}
                </a>
            </div>
        </div>
    </div>
</div>
