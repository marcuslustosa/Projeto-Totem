var img = new Image();
var logoObj = new Image();
var logo;
var tr;
var layer;
var logo_url = "";
var ratio = 1;
var logoX,
    logoY = 0;
var logoWidth = 595;
var logoHeight = 205;
var description = "";

img.crossOrigin = "Anonymous";
logoObj.crossOrigin = "Anonymous";

var stage = new Konva.Stage({
    container: "container",
    width: 400,
    height: 200,
});

img.onload = function () {
    ratio = 0.38;

    if (screen.width < 600) {
        if (img.height > img.width) {
            ratio = (screen.height - 250) / img.height;
        } else {
            ratio = (screen.width - 30) / img.width;
        }
    }

    layer = new Konva.Layer();
    stage.add(layer);
    // main API:
    stage.width(img.width * ratio);
    stage.height(img.height * ratio);
    stage.scale({ x: ratio, y: ratio });

    if (img.height > img.width) {
        $("#descriptionContainer").addClass("d-none");
    } else {
        $("#descriptionContainer").removeClass("d-none");
        $("#post-description-div").width(img.width * ratio);
    }

    var template = new Konva.Image({
        x: 0,
        y: 0,
        image: img,
        scaleX: 1,
        scaleY: 1,
        draggable: false,
    });

    $("#modal-loader").addClass("hide-div");
    layer.add(template);

    logoObj.src = logo_url;
};

logoObj.onload = function () {    
    logo = new Konva.Image({
        x: logoX - 1,
        y: logoY - 1,
        image: logoObj,
        width: 595,
        height: 205,
        draggable: true,
    });
    logo.cache();
    logo.filters([Konva.Filters.HSL]);    
    var sliders = ['hue', 'saturation', 'luminance'];
    sliders.forEach(function (attr) {
        var slider = document.getElementById(attr);
        function update() {
            logo[attr](parseFloat(slider.value));
        }
        slider.oninput = update;
        update();
    });       
    
    layer.add(logo); 
 
    logo.on("mouseenter", function () {
        stage.container().style.cursor = "move";
    });

    logo.on("mouseleave", function () {
        stage.container().style.cursor = "default";
    });

      

    tr = new Konva.Transformer({
        nodes: [logo],
        centeredScaling: false,
    });

    layer.add(tr);
    
    layer.on('mouseenter', function () {
        tr.show();
    });
    
    layer.on('mouseleave', function () {
        tr.hide();
    });

};

const select = document.getElementById('logo-color');

select.addEventListener('change', function handleChange(event) {
    var saturation = document.querySelector("#saturation");
    saturation.value(0);
    
    tr.destroy();
    logo.destroy();
    layer.draw();
  logo_url =
        "https://app-familia-metalife-v2-storage-35a2c4f9194939-staging.s3.sa-east-1.amazonaws.com/public/images/studios/" +
        selectedStudioID +
        "/logos/";

    if (event.target.value == 0) {
        logo_url = logo_url + "color.png";
    } else if (event.target.value == 1) {
        logo_url = logo_url + "light.png";
    } else {
        logo_url = logo_url + "dark.png";
    }

  logoObj.src = logo_url;
  
});


$("#post-modal").on("shown.bs.modal", function () {
    /*tr = new Konva.Transformer({
    nodes: [],
    keepRatio: true,
    name: 'transformer',
    enabledAnchors: [
        'top-left',
        'top-right',
        'bottom-left',
        'bottom-right',
    ],
    });
    layer.add(tr);

    layer.on('mouseenter', function () {

    tr.show();
    });

    layer.on('mouseleave', function () {
    tr.hide();
    });*/
});

function fitStageIntoParentContainer(sceneWidth, sceneHeight) {
    var container = document.querySelector("#canvas-div");

    // now we need to fit stage into parent container
    var containerWidth = container.offsetWidth;
    var containerHeight = container.offsetHeight;

    // but we also make the full scene visible
    // so we need to scale all objects on canvas
    var scale =
        containerWidth < containerHeight
            ? containerWidth / sceneWidth
            : containerHeight / sceneHeight;

    stage.width(sceneWidth * scale);
    stage.height(sceneHeight * scale);
    stage.scale({ x: scale, y: scale });
}

function setImage(url, x, y, w, h, color, name, description) {
    
    $("#post-title").text(name);
    $("#post-description").text(description);

    stage.destroyChildren();
    logo_url =
        "https://app-familia-metalife-v2-storage-35a2c4f9194939-staging.s3.sa-east-1.amazonaws.com/public/images/studios/" +
        selectedStudioID +
        "/logos/";

    if (color == 0) {
        logo_url = logo_url + "color.png";
    } else if (color == 1) {
        logo_url = logo_url + "light.png";
    } else {
        logo_url = logo_url + "dark.png";
    }

    img.crossOrigin = "Anonymous";
    img.src = url;
    //onLoad event sets the stage width

    logoX = x;
    logoY = y;
    logoWidth = w;
    logoHeight = h;

    //$('#canvas-div').innerHTML = '';
    //$('#canvas-div').append(canvas);

    //$("#container").width(img.width);

    $("#post-modal").modal("show");
    $("#modal-loader").removeClass("hide-div");
}

function downloadImage() {
    var dataURL = stage.toDataURL({ pixelRatio: 1 / ratio });

    var link = document.createElement("a");
    link.download = $("#post-title").text() + ".png";
    link.href = dataURL;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    delete link;
}

async function share() {
    var dataURL = stage.toDataURL({ pixelRatio: 1 / ratio });

    const blob = await (await fetch(dataURL)).blob();

    const filesArray = [
        new File([blob], "familia_metalife.jpg", {
            type: blob.type,
            lastModified: new Date().getTime(),
        }),
    ];
    const shareData = {
        files: filesArray,
        title: $("#post-title").text(),
        text: $("#post-description").text(),
    };
    navigator.share(shareData);
}

function shareOnFacebook() {
    var dataURL = stage.toDataURL({ pixelRatio: 1 / ratio });

    //document.querySelector("body").style.visibility = "hidden";
    $("#loading-div").removeClass("hide-div");
    $("#loading-div").addClass("d-flex");

    $.ajax({
        type: "POST",
        url: "/api/post-templates/save",
        data: {
            image: dataURL,
            userId: user.id,
        },
    }).done(function (data) {
        $("#loading-div").addClass("hide-div");
        $("#loading-div").removeClass("d-flex");
        var url =
            "http://www.facebook.com/sharer.php?u=" +
            data +
            "&t=Post usando o Família MetaLife";
        window.open(url, "_blank").focus();
    });
}
