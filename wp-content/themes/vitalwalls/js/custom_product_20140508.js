

window.addEventListener('load', onload, false);


var target = document.getElementById('size');
var frame = document.getElementById('frames');

if (target != null)
{
target.addEventListener('change', jsFunction, false);
}
textnode2 = document.createElement("select");
var op1 = new Option();
op1.value = "";
op1.text = "Select Option";
textnode2.options.add(op1);

function onload()
{
var frame = document.getElementById('frames');

var value = document.getElementById('size').value;
/*if(value!=null)
{  
jQuery("#size option[value='"+value+"']").prop("selected", false);
}*/

//Hiding default frames dropdown
if ((frame != null))
{
frame.style.display = 'none';
}

/*////////Display frame dropdown for small variations only BEGINS
var selectedSize = jQuery(".variations #size").val();

var frameDropdown = new Array();
var frameDropdown_text = new Array();
var frameLen;

if(selectedSize=="small")
{
    frame.style.display = 'block';
    jQuery('select[name=frames] option:eq(1)').attr('selected', 'selected');
}

////////Display frame dropdown for small variations only ENDS */

//Hiding label for frames dropdown
var label = document.getElementsByTagName('label');

 for (var i = 0; i < label.length; i++) {
              
				if(label[i].htmlFor=='frames')
				{
				label[i].style.display = 'none';
				}
				
            }
       
var d = document.getElementsByClassName('variations_button');

//d[0].setAttribute("style","position:relative;top:40px");

var d1 = document.getElementsByClassName('quantity buttons_added');

//d1[0].setAttribute("style","position:relative;top:-43px");
}

function jsFunction()
{
    var myarray = new Array();
    var myarray_text = new Array();
    var j=0;
    var mylen;
    var frame = document.getElementById('frames');

    /////frame length
    mylen = frame.length;

    /////hide the frame
    frame.style.display = '';
    //frame.setAttribute("style","position:relative;top:-10px;left:133px");



    var label = document.getElementsByTagName('label');

    for (var i = 0; i < label.length; i++) {
        if(label[i].htmlFor=='frames')
		{
			label[i].style.display = '';
			//label[i].setAttribute("style","position:relative;top:18px;left:10px");
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

        var escapedseq = document.getElementById('size').value;
        escapedseq = escapedseq.replace(/[^A-Z]/ig, ""); //retrieve size value

        var escape_1 = arr_split[0];
        escape_1 = escape_1.replace(/[^A-VYZ]/ig, ""); // retrieve frame value

        // Only if size dropdown's value {medium} matches bracket part of frame dropdown's value {"frame1(medium)"}
        if (escape_1==escapedseq) {
             myarray[j] = textnode2.options[i].value;  // Set frame dropdown's values
             myarray_text[j] = textnode2.options[i].text //Set frame dropdown's text
             j++;
           }
    }


    document.getElementById('frames').options.length = 0;
    var pound = "\u20B9";

    var frame = document.getElementById('frames');
    var opt1 = document.createElement('option');
    opt1.value ="";
    opt1.innerHTML = "Select Option";
    frame.appendChild(opt1);

    for (var i = 0; i<myarray.length; i++){

        var opt = document.createElement('option');
        opt.value = myarray[i];
        opt.innerHTML = myarray_text[i];

        var data = myarray_text[i].split('-');

        var price = data[1].split(pound);

        var price_val = price[1];

        opt.setAttribute("data-price",price_val);
        frame.appendChild(opt);
    }
 
  
 }


