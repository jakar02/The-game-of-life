//var tab = new Array(50).fill(new Array(30).fill(false));
var tab = [];
for (let i = 0; i < 52; i++) {
    tab[i] = new Array(32).fill(false);
}

var isRunning = false;
var how_many_steps=1;

function ile_krokow_fun(){
    var how_many = document.getElementById("ile_krokow");
    how_many_steps = parseInt(how_many.value);
    console.log(how_many_steps);
}

function stop_game(){
    isRunning = false;
}

async function play_game_of_life(){
    isRunning = true;
    console.log("play_game_of_life");
    
    const c2 = document.getElementById("myCanvas");
    var ctx2 = c2.getContext("2d");
    ctx2.fillStyle = "green";

        //patrzymy na old_tab a zmian dokonujemy w tab
    while(isRunning == true){
        await timeout(500);

        var old_tab = [];
        for (let i = 0; i < 52; i++) {
            old_tab[i] = new Array(32).fill(false);
        }
        for (var i=1; i<51; i++){
            for(var j=1; j<31; j++){
                old_tab[i][j] = tab[i][j];
            }
        }
        for (var i=1; i<51; i++){
            for(var j=1; j<31; j++){
                //old_tab[i][j] = tab[i][j];
                var alive_friends = 0;
    
                for (var k=-1; k<2; k++){
                    for(var l=-1; l<2; l++){
                        if(old_tab[i+k][j+l] == true && !(k==0 && l==0)){
                            alive_friends++;
                        }
                    }
                }               
                if(old_tab[i][j]==false && alive_friends == 3 ){
                    tab[i][j] = true;
                }
                else if (alive_friends<2 || alive_friends>3){
                    tab[i][j] = false;
                }
            }
        }

        fill_with_color();
    }
}

function fill_with_color(){
    console.log("fill_with_color");
    const c3 = document.getElementById("myCanvas");
    var ctx3 = c3.getContext("2d");
    for(let i=0; i<52; i++){
        for(let j=0; j<32; j++){

            if(tab[i][j] == true){
                ctx3.fillStyle = "red";
            }
            else{
                ctx3.fillStyle  = "rgb(249, 239, 213)";
            }
            ctx3.fillRect(20*i -20, 20*j -20, 19, 19);
        }
    }
}

function cliked_field(canvas, event) {
    let rect = canvas.getBoundingClientRect();
    let x = event.clientX - rect.left;
    let y = event.clientY - rect.top;
    var x_field =  Math.floor(x/20);
    var y_field =  Math.floor(y/20);

    console.log("x_field: " + x_field, "y_field: " + y_field);

    const c2 = document.getElementById("myCanvas");
    var ctx2 = c2.getContext("2d");
    
    //zmieniamy pole w tablicy +1 dalsze
    tab[x_field+1][y_field+1] = true;//!tab[x_field+1][y_field+1];
    ctx2.fillStyle = "red";
    if(tab[x_field+1][y_field+1] == false){
        ctx2.fillStyle = "rgb(249, 239, 213)";
    }
    ctx2.fillRect(20*x_field, 20*y_field, 19, 19);
}



function clear_canvas() {
    const c2 = document.getElementById("myCanvas");
    var ctx2 = c2.getContext("2d");
    ctx2.fillStyle = "rgb(249, 239, 213)";

    for(let i=0; i<52; i++){
        for(let j=0; j<32; j++){
            tab[i][j] = false;
            ctx2.fillRect(20*i, 20*j, 19, 19);
        }
    }
}


function timeout(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}
