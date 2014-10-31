

window.addEventListener('load', onload, false);



textnode2 = document.createElement("select");
var op1 = new Option();
op1.value = "";
op1.text = "Select Option";
textnode2.options.add(op1);

function onload()
{

var framepic = document.getElementById('frame_pic');
if(framepic!=null)
{
framepic.style.display = 'none';
}
//var choosesize = document.getElementById('choose-size');
//choosesize.style.display = 'none';
var label = document.getElementsByTagName('label');

 for (var i = 0; i < label.length; i++) {
              
				if(label[i].htmlFor=='frame_pic')
				{
				label[i].style.display = 'none';
				}
				
            }
       


var d1 = document.getElementsByClassName('quantity buttons_added');

// d1[0].setAttribute("style","position:relative;top:-43px");



}

//var target = document.getElementById('selectfiles-picture');
//target.addEventListener('click', loadSize, false);

function loadSize()
{
 $("#containing-div").load("[url of page with onload function]");
var choosesize = document.getElementById('choose-size');
choosesize.style.display = '';
}

var size = document.getElementById('choose-size');
if(size!=null){
size.addEventListener('change', jsFunction, false);
}
function jsFunction()
{
if(jQuery.trim(jQuery('.u_i_c_name').text()) == "") {
    alert('Please Upload the frame');
	document.getElementById('choose-size').value="";
	return false;
}
var myarray = new Array();
var myarray_text = new Array();
var j=0;
var mylen;
var frame = document.getElementById('frame_pic');
mylen = frame.length;
frame.style.display = '';
frame.setAttribute("style","position:relative;top:440px;left:138px");

var d1 = document.getElementsByClassName('single_variation_wrap');

d1[0].setAttribute("style","position: relative;top: 130px;");



var d2 = document.getElementsByClassName('woocommerce-tabs');

d2[0].setAttribute("style","position: relative;top: 132px;");
var label = document.getElementsByTagName('label');

 for (var i = 0; i < label.length; i++) {
              
				if(label[i].htmlFor=='frame_pic')
				{
				label[i].style.display = '';
				label[i].setAttribute("style","position:relative;top:470px;left:10px");
				}
				
            }

if(document.getElementById('choose-size').value=="")
{
document.getElementById('frame_pic').options.length = 0;
var frame = document.getElementById('frame_pic');
frame.style.display = 'none';
var label = document.getElementsByTagName('label');

 for (var i = 0; i < label.length; i++) {
              
				if(label[i].htmlFor=='frame_pic')
				{
				label[i].style.display = 'none';
				}
				
            }
for (i=0;i<textnode2.length;  i++) {




var op = new Option();
op.value = textnode2.options[i].value;
op.text = textnode2.options[i].text
frame.options.add(op); 
 }
 return false;
}
if(textnode2.length>1)
{
mylen= textnode2.length;
}
else
{
for (i=1;i<mylen;  i++) {




var op = new Option();
op.value = frame.options[i].value;
op.text = frame.options[i].text
textnode2.options.add(op); 
 }
}

for (i=1;i<mylen;  i++) {


var arr = textnode2.options[i].value.split('(');

var arr_split = arr[1].split(')');


   if (arr_split[0]==document.getElementById('choose-size').value) {
  
    
	 myarray[j] = textnode2.options[i].value;
	 myarray_text[j] = textnode2.options[i].text
	 j++;
   }
}


document.getElementById('frame_pic').options.length = 0;
var pound = "\u00A3";

var frame = document.getElementById('frame_pic');
 var opt1 = document.createElement('option');
    opt1.value ="";
    opt1.innerHTML = "Select Option";
	 frame.appendChild(opt1);
for (var i = 0; i<myarray.length; i++){
    var opt = document.createElement('option');
    opt.value = myarray[i];
    opt.innerHTML = myarray_text[i];
	var data = myarray_text[i].split(pound);
	
	opt.setAttribute("data-price",data[1]);
    frame.appendChild(opt);


}


}


