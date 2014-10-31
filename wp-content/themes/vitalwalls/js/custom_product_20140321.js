

window.addEventListener('load', onload, false);


var target = document.getElementById('size');
var frame = document.getElementById('frames');


target.addEventListener('change', jsFunction, false);

textnode2 = document.createElement("select");
var op1 = new Option();
op1.value = "";
op1.text = "Select Option";
textnode2.options.add(op1);

function onload()
{
var frame = document.getElementById('frames');
frame.style.display = 'none';
var label = document.getElementsByTagName('label');

 for (var i = 0; i < label.length; i++) {
              
				if(label[i].htmlFor=='frames')
				{
				label[i].style.display = 'none';
				}
				
            }
       
var d = document.getElementsByClassName('variations_button');

d[0].setAttribute("style","position:relative;top:40px");

var d1 = document.getElementsByClassName('quantity buttons_added');

d1[0].setAttribute("style","position:relative;top:-43px");
}

function jsFunction()
{

var myarray = new Array();
var myarray_text = new Array();
var j=0;
var mylen;
var frame = document.getElementById('frames');
mylen = frame.length;
frame.style.display = '';
frame.setAttribute("style","position:relative;top:-10px;left:133px");
var label = document.getElementsByTagName('label');

 for (var i = 0; i < label.length; i++) {
              
				if(label[i].htmlFor=='frames')
				{
				label[i].style.display = '';
				label[i].setAttribute("style","position:relative;top:18px;left:10px");
				}
				
            }

if(document.getElementById('size').value=="")
{
document.getElementById('frames').options.length = 0;
var frame = document.getElementById('frames');
frame.style.display = 'none';
var label = document.getElementsByTagName('label');

 for (var i = 0; i < label.length; i++) {
              
				if(label[i].htmlFor=='frames')
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


   if (arr_split[0]==document.getElementById('size').value) {
  
    
	 myarray[j] = textnode2.options[i].value;
	 myarray_text[j] = textnode2.options[i].text
	 j++;
   }
}


document.getElementById('frames').options.length = 0;
var pound = "\u00A3";

var frame = document.getElementById('frames');
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


