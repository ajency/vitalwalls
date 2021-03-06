

window.addEventListener('load', onload, false);


var target = document.getElementById('size');
var size_popup = document.getElementById('size_popup');
var frame = document.getElementById('frames');
var frame_popup = document.getElementById('frames_popup');

if (target != null)
{
target.addEventListener('change', jsFunction, false);
}

//Change selected frames in popup and main page
if (frame_popup != null)
{
    frame_popup.addEventListener('change', selectedFrames, false);
}

if (size_popup != null)
{
    size_popup.addEventListener('change', jsFunction_popup, false);
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

var selectedSize = jQuery(".variations #size").val();

if(selectedSize!="")
{
    jsFunction();
}

else
 {
     //Hiding default frames dropdown
     if ((frame != null))
     {
         frame.style.display = 'none';
     }

     ///Hiding label for frames dropdown
        var label = document.getElementsByTagName('label');

        for (var i = 0; i < label.length; i++) {

            if(label[i].htmlFor=='frames')
            {
                label[i].style.display = 'none';
            }

        }
 }


var d = document.getElementsByClassName('variations_button');

//d[0].setAttribute("style","position:relative;top:40px");

var d1 = document.getElementsByClassName('quantity buttons_added');

//d1[0].setAttribute("style","position:relative;top:-43px");
}

/**
 * Function to display size specific frames
 **/
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


function jsFunction_popup()
{
    var sizeMain = document.getElementById('size');
    var size_popup = document.getElementById('size_popup');
  //  alert(sizeMain.value);
   // alert(size_popup.value);

    //Set pop up's size dropdown same as main size dropdown
    sizeMain.value = size_popup.value;

    /*Set popup's frame dropdown to main frame dropdown
    if(sizeMain.value!="")
    {
        jsFunction();
    }*/

    var myarray = new Array();
    var myarray_text = new Array();

    var j=0;
    var mylen;
    var frame_popup = document.getElementById('frames_popup');

    /////frame length
    mylen = frame_popup.length;

    /////hide the frame
    frame_popup.style.display = '';
    //frame.setAttribute("style","position:relative;top:-10px;left:133px");



    var label = document.getElementsByTagName('label');

    for (var i = 0; i < label.length; i++) {
        if(label[i].htmlFor=='frames')
        {
            label[i].style.display = '';
            //label[i].setAttribute("style","position:relative;top:18px;left:10px");
        }

    }

    if(document.getElementById('size_popup').value=="")
    {
        document.getElementById('frames_popup').options.length = 0;
        var frame_popup = document.getElementById('frames_popup');
        frame_popup.style.display = 'none';
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
            frame_popup.options.add(op);
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
            op.value = frame_popup.options[i].value;
            op.text = frame_popup.options[i].text
            textnode2.options.add(op);
        }
    }

    for (i=1;i<mylen;  i++) {
        var arr = textnode2.options[i].value.split('(');

        var arr_split = arr[1].split(')');

        var escapedseq = document.getElementById('size_popup').value;
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


    document.getElementById('frames_popup').options.length = 0;
    var pound = "\u20B9";

    var frame_popup = document.getElementById('frames_popup');
    var opt1 = document.createElement('option');
    opt1.value ="";
    opt1.innerHTML = "Select Option";
    frame_popup.appendChild(opt1);

    for (var i = 0; i<myarray.length; i++){

        var opt = document.createElement('option');
        opt.value = myarray[i];
        opt.innerHTML = myarray_text[i];

        var data = myarray_text[i].split('-');

        var price = data[1].split(pound);

        var price_val = price[1];

        opt.setAttribute("data-price",price_val);
        frame_popup.appendChild(opt);
    }




}

function selectedFrames()
{
    /*var frame_popup = jQuery("#frames_popup").val();
    alert("POPUP FRAME="+jQuery("#frames_popup").val());
    jQuery("#frames").val(frame_popup);
   alert("MAIN FRAME="+jQuery("#frames").val());*/

    var frame_popup = jQuery("#frames_popup").val();
    //alert("MAIN PAGE FRAME"+jQuery("#frames").val());
    var frame = document.getElementById('frames');
    frames.value = jQuery("#frames_popup").val();
    //alert( frames.value);
    jQuery("#frames option[value='frame1(medium)']").prop("selected", true);
    //jQuery("#frames").val(frame_popup);
    //alert(frame_popup);
    //alert("MAIN FRAME="+document.getElementById('frames'.value));
}