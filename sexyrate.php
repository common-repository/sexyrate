<?php
/*
Plugin Name: sexyrate
Plugin URI: http://www.sajithmr.com/sexy-rating-wordpress-plugin/
Description: You can put a user rating system for your blog. The visitor of your blog or website can rate your blog. You can see how they response with your blog. Fully Ajax implementation. Fast loading. Nice design
Version: 1.0
Author: Sajith
Author URI: http://www.sajithmr.com
*/


/*  Copyright 2008  sexyrate (email : mrsajith@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

function sexyrate_header() {
	
	$plugin_path = get_option('siteurl').'/wp-content/plugins/sexyrate' ;
	$style_sheet= '<link rel="stylesheet" href="'.$plugin_path.'/rate.css" type="text/css" />';
	echo $style_sheet;
}

add_action('wp_head', 'sexyrate_header');

function wp_show_my_rate()
{
	
	$perfect = get_option('perfect');
	$good = get_option('good');
	$bad = get_option('bad');
	$toobad = get_option('toobad');
	
	//update_option(perfect, 2 );
	
	$total = $perfect + $good + $bad + $toobad ;
	
	list($perfect_per,$good_per,$bad_per,$toobad_per) = array(0,0,0,0);
	
	
	
	if($total != 0)
	{
		
		$perfect_per =  round(($perfect / $total) * 100,1) ;
		$good_per = round(($good /$total) * 100,1) ;
		$bad_per = round(($bad / $total) * 100,1);
		$toobad_per = round(($toobad / $total) * 100,1) ;
	}
	
	
	
	$plugin_path = get_option('siteurl').'/wp-content/plugins/sexyrate' ;
	
	
	
	
	if(isset($_COOKIE['ratted']))
		$submit = '<span id="rupdate">(you already ratted)</span>';
	else
		$submit = '<span id="rupdate">
<input type="button" value="Rate"  class="rbutton" onclick="submitForm()"/>
</span>';	
	
	$output_template= '
<form name="rform" action="">
<div id="site-ratting">

Rate<span class="r-head"> '.str_replace("http://",'',get_option('siteurl')).'</span>
<a href="http://www.sajithmr.me/sexy-rating-wordpress-plugin/"><img src="'.$plugin_path.'/images/tick.gif"  alt="Sajithmr.com"  class="ricon"/></a>
<ul>			
<li><img src="'.$plugin_path.'/images/perfect.jpg" class="rimage" alt="Perfect" title="Perfect" /><br/>
<input type="radio" class="radioin" name="rate" value="p" /><span class="r-text">Perfect('.$perfect_per.'%)</span>

</li>
<li><img src="'.$plugin_path.'/images/good.jpg" class="rimage" alt="Good" title="Good" />
<br/>
<input type="radio" class="radioin" name="rate" value="g" /><span class="r-text">Good('.$good_per.'%)</span>
</li>

<li><img src="'.$plugin_path.'/images/bad.jpg" class="rimage" alt="Bad" title="Bad" />
<br/>
<input type="radio" class="radioin" name="rate" value="b" /><span class="r-text">Bad('.$bad_per.'%)</span>
</li>


<li><img src="'.$plugin_path.'/images/toobad.jpg" class="rimage" alt="Too Bad" title="Too Bad" />
<br/>
<input type="radio" class="radioin" name="rate"  value="t"/><span class="r-text">Too Bad('.$toobad_per.'%)</span>
</li>

</ul>			
<div class="clear"></div>

'.$submit.'
	

</div>
		
</form>		

		
<script type="text/javascript">

function getCheckedValue(radioObj) {
	if(!radioObj)
		return "";
	var radioLength = radioObj.length;
	if(radioLength == undefined)
		if(radioObj.checked)
			return radioObj.value;
		else
			return "";
	for(var i = 0; i < radioLength; i++) {
		if(radioObj[i].checked) {
			return radioObj[i].value;
		}
	}
	return "";
}
function submitForm()
{ 
    var xhr; 
    try {  xhr = new ActiveXObject("Msxml2.XMLHTTP");   }
    catch (e) 
    {
        try {   xhr = new ActiveXObject("Microsoft.XMLHTTP");    }
        catch (e2) 
        {
          try {  xhr = new XMLHttpRequest();     }
          catch (e3) {  xhr = false;   }
        }
     }
  
    xhr.onreadystatechange  = function()
    { 
         if(xhr.readyState  == 4)
         {
              if(xhr.status  == 200) 
                 
			{
				document.getElementById("rupdate").innerHTML = "";
			}	
                
         }
    }; 


  
   xhr.open("GET", "'.$plugin_path.'/addrate.php?rate="+ getCheckedValue(document.rform.rate),  true); 
   xhr.send(null); 
   
  
} 



</script>
';
	
	
	
	echo $output_template;
}

function my_rate_install()

{ 

	add_option('perfect', 	"0", "");

	add_option('good', 	"0", "");

	add_option('bad', 	"0", "");

	add_option('toobad', 	"0", "");

	
	

}
register_activation_hook(__FILE__,"my_rate_install");

		
		?>