<script>

var mousePosition;
var offset = [0,0];
var div;
var tagLabels = [];
var tagElements = [];
var tagFlags = [];
var cont = 0;
var vectorInputs = [];
var vectorInputsName = [];

function comprobar(){
    var i;
    for (i=0;i<vectorInputs.length;i++){
        tagLabels[i].innerHTML = vectorInputsName[i].value;
        if(vectorInputs[i].value==1){
            tagElements[i].style.background = "green";
        }
        if(vectorInputs[i].value==2){
            tagElements[i].style.background = "red";
        }
        if(vectorInputs[i].value==3){
            tagElements[i].style.background = "yellow";
        }
        if(vectorInputs[i].value==4){
            tagElements[i].style.background = "blue";
        }
    }

}

    var x_input = document.getElementById("input_x");
    var y_input = document.getElementById("input_y");
function crear(){


    var form1 = document.getElementById("form1");

    var labelmenu = document.createElement("label");
    labelmenu.style.width="50px";
    labelmenu.innerHTML=""+cont;
    labelmenu.className="unselectable";
    form1.appendChild(labelmenu);

    var input1 = document.createElement("input");
    input1.style.width="80px";
    input1.value="Trap"+cont;
    form1.appendChild(input1);
    vectorInputsName.push(input1);

    var input2 = document.createElement("input");
    input2.style.width="50px";
    form1.appendChild(input2);
    vectorInputs.push(input2);


    var br = document.createElement("br");
    form1.appendChild(br);

    var label = document.createElement("div");
    label.innerHTML="Trap"+cont;
    label.className="unselectable";
    label.style.position = "absolute";
    document.body.appendChild(label);
    tagLabels.push(label);

    var nuevo = document.createElement("div");
    nuevo.id="d"+cont;
    nuevo.style.position = "absolute";
    nuevo.style.left = "0px";
    nuevo.style.top = "0px";
    nuevo.style.width = "20px";
    nuevo.style.height = "20px";
    nuevo.style.background = "red";
    nuevo.style.color = "blue";
    nuevo.style.borderRadius="50%";
    nuevo.className=cont;
    
    var isDown = false;
    tagFlags.push(isDown);
    
    nuevo.addEventListener('mousedown', function(e) {
        tagFlags[nuevo.className] = true;
        //tagFlags.push(true);
        console.log("MouseDown");
        console.log(tagFlags);
        console.log(nuevo.className);
        offset = [
            nuevo.offsetLeft - e.clientX,
            nuevo.offsetTop - e.clientY
        ];

    }, true);
    tagElements.push(nuevo);
    document.body.appendChild(nuevo);
    cont++;

    
}


document.addEventListener('mouseup', function() {
    var i;
    for (i = 0; i < tagFlags.length; i++) {
        tagFlags[i]=false;
    }
}, true);

document.addEventListener('mousemove', function(event) {
    event.preventDefault();
    var i=0;
    for (i = 0; i < tagFlags.length; i++) {
        if (tagFlags[i]) {

            console.log("event move log");
            console.log(i);
            console.log(tagElements);
            mousePosition = {
        
                x : event.clientX,
                y : event.clientY
        
            };
            console.log(tagElements[i]);
            console.log(i);
            console.log(tagElements);

            tagElements[i].style.left = (mousePosition.x + offset[0]) + 'px';
            tagElements[i].style.top  = (mousePosition.y + offset[1]) + 'px';
x_input.value = (mousePosition.x + offset[0]) + 'px';
y_input.value = (mousePosition.y + offset[1]) + 'px';

            tagLabels[i].style.left = (mousePosition.x + offset[0]) + 'px';
            tagLabels[i].style.top  = (mousePosition.y + offset[1] - 20) + 'px';
        }
    }
}, true);




  function readURL(input) {
            if (input.files && input.files[0]) {
                console.log(input.files[0].mozFullPath);
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#laimg')
                        .attr('src', e.target.result);
                };
                //$('#laimg').attr('src',input.files[0].mozFullPath);
                reader.readAsDataURL(input.files[0]);
            }
        }


</script>

<html>

<meta charset="UTF-8">
<link class="jsbin" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
<script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>
<body id="mibody">
<div id="ola">

</div>
<div style="display: grid; grid-template-columns: 250px 200px">

    <div style="grid-column: 1">
        <form id="form" action="/action_page.php">
            <div id="form1">
          <label class="unselectable" for="cars"> Nombre Valor</label>
          <br>
      </div>
          <br>
          <!--input value="Actualizar" type="submit" -->
        </form>

          <button onclick="comprobar()">Actualizar</button>

    </div>
    <div style='width: 600px; height:300px; grid-column: 2;'>
        <img class="unselectable" id="laimg" src="http://www.elche.me/sites/default/files/styles/marcaagua/public/pf140.jpg?itok=nF_c9Qhk" style="border: 1px;border-color: black; border-style: solid;">
    </div>
</div>
<button > Mostrar/Ocultar</button>
<button onclick="crear()">Crear punto</button>
<br>
<input type='file' onchange="readURL(this);" />
<br>

<input id='input_x' style="width: 50px; height:20px;"> </input>
<input id="input_y" style="width: 50px; height:20px;"> </input>


</body>
</html>

<style type="text/css">
    
    .unselectable {
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}
</style>