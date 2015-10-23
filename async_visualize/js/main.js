setInterval('getStatus()', 2000);
var movedFlag = 0;
var position;
var tempPosition;
var count = 50;
var increX;
var increY;
var first = 1;
var i = 0;

tempPosition = {
    x : 0,
    y : 0,
    mets: 0
};

function getStatus(){
  var url = "./getdata.php";
  $.ajax({
    url:url,
    beforeSend:function(){},
    success:function(ref){
      position = JSON.parse(ref);
      i = 0;
      drawPosition(position);
    }
  });
}

function drawPosition(position){
  console.log(position);

  var X = parseFloat(position.x);
  var Y = parseFloat(position.y);
  var mets = parseFloat(position.mets);
  var tempX = parseFloat(tempPosition.x);
  var tempY = parseFloat(tempPosition.y);
  var tempMets = parseFloat(tempPosition.mets);

  var APP = { };
  if (X - tempX != 0){
    movedFlag = 1;
    increX = (X - tempX) / count;
    increY = (Y - tempY) / count;
	console.log(increX);
  } else {
	console.log("There is no move!!");
  };
  APP.animate = function() {
	if (movedFlag == 1){
		APP.circle.position.x = APP.circle.position.x + increX*250 - 500;
		APP.circle.position.y = APP.circle.position.y - increY*250 + 500;
		console.log("x:"+APP.circle.position.x);
		console.log("y:"+APP.circle.position.y);
		APP.renderer.render(APP.scene, APP.camera);
		window.requestAnimationFrame( APP.animate );
		APP.circle.position.x += 500;
		APP.circle.position.y -= 500;
		i++;
		console.log("i:"+i);
		console.log("count:"+count);
		if (i == count){movedFlag = 0};
	}else {
		APP.circle.position.x = parseFloat(X*250 - 500);
		APP.circle.position.y = parseFloat(Y*250 + 500);
		// APP.renderer.render(APP.scene, APP.camera);
		// window.requestAnimationFrame( APP.animate );
	}
	tempPosition = position;
	first = 0;
  }
}

function setColor(mets){
	if(mets > 1.5) {
		material.color.setHex(0xff0000);
	}
}

$(document).ready( function() {
	// Rendererを用意
	APP.renderer = new THREE.WebGLRenderer( { 'canvas' : $('#canvas')[0]  , 'alpha': true});
	APP.renderer.setSize(1000, 1000);

	// Cameraを用意
	APP.camera = new THREE.PerspectiveCamera();
	//APP.camera.position.z = 500;
	APP.camera.position.z = 1000;

	// Sceneを用意
	APP.scene = new THREE.Scene();
	APP.scene.add( APP.camera );

	// 図形を作る
	var material = new THREE.MeshBasicMaterial( { color: 0xeeee00 } );
	var geometry = new THREE.CircleGeometry( 20, 500 );
	APP.circle = new THREE.Mesh( geometry, material );
	APP.scene.add( APP.circle );

	console.log(APP.circle);

	APP.renderer.render( APP.scene, APP.camera );

	APP.animate();
} );
