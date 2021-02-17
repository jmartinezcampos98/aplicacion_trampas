

var mousePosition;
var offset = [0,0];
var div;
var tagLabels = [];
var tagElements = [];
var tagFlags = [];
var cont = 0;
var vectorInputs = [];
var vectorInputsName = [];

function crear(){

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