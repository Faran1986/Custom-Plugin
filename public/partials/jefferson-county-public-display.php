<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://iplex.co
 * @since      1.0.0
 *
 * @package    Jefferson_County
 * @subpackage Jefferson_County/public/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->



	<div class="aw-views-wrap">
		<ul>
			<li class="aw-active temp-type" data-id="1">Monthly</li>
			<li class="temp-type" data-id="2">Weekly</li>
			<li class="temp-type" data-id="3">Daily</li>
			<li class="temp-type" data-id="4">Agenda</li>
		</ul>
	</div><!---====== aw-views-wrap ==== --->

      <?php
      
      
      $categories = get_terms([
            'taxonomy'   => 'category',
            'hide_empty' => true,
        ]);
    
      
      ?>


      <div class="aw-filters">
            <div class="w-50">
                  <label>Choose Category :</label><br>
                  <select class="aw-input" id="eventCat">
                        <option value="all">Select Category</option>
                        <?php

                        foreach($categories as $cat){

                        ?>
                        <option value="<?= $cat->slug ?>"><?= $cat->name ?></option>
                        <?php } ?>
                  </select>
            </div>
            
            <div class="w-50">
                  <label>Search Event :</label><br>
                  <input type="text" class="aw-input" placeholder="Search...." id="searchContent">
                  <button id="searchBtn"><i class="fa fa-search"></i></button>
            </div>
      </div>

    


    <div mbsc-page class="demo-desktop-month-view calendar-temp" id="temp1">
        <div style="height:100%">
                <div id="demo-desktop-month-view"></div>
        </div>
    </div>

    <div mbsc-page class="demo-desktop-week-view calendar-temp" id="temp2"  style="display:none">
        <div style="height:100%">
                <div id="demo-desktop-week-view"></div>
        </div>
    </div>

    <div mbsc-page class="demo-desktop-day-view calendar-temp" id="temp3" style="display:none">
        <div style="height:100%">
                <div id="demo-desktop-day-view"></div>
        </div>
    </div>



    <div mbsc-page class="demo-daily-events calendar-temp" id="temp4" style="display:none">
        <div style="height:100%">
                <div id="demo-daily-events"></div>
        </div>
    </div>




    <div class="aw-event-details">
      <i class="fa fa-arrow-right removeModel"></i>
      <div class="event-content">
        
      </div>
    </div><!--- ====== aw-event-details ====== ---->



  <div id="awLoader">
      <img src="<?= plugin_dir_url( __FILE__ ).'/loading-gif.gif' ?>">
  </div>


    
    
