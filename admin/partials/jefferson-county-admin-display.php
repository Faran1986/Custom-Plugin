<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://iplex.co
 * @since      1.0.0
 *
 * @package    Jefferson_County
 * @subpackage Jefferson_County/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->




        <form method="post" id="icsForm" enctype="multipart/form-data">
			<div class="form-wrap">
				<h3>Import Events</h3>
				<label>Choose ICS Feed<span>*</span></label>
				<input type="file" id="icsFile" name="ics_file" required>
				<input type="hidden" value="import_ics_events" name="action">
				<button id="importIcs" name="import_ics">Import</button>
			</div>
		</form>

			<div class="form-wrap">
				<h3>All Imports</h3>
				
				<div class="aw-table-responsive">
					<table>
						<thead>
							<tr>
                                <th>Date</th>
								<th>Import Url</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
                            <?php
                            
                            global $wpdb;

                            $event_table = $wpdb->prefix . 'event_import';

                            $results = $wpdb->get_results("SELECT * FROM $event_table");

                            foreach($results as $row){
                                
                            ?>
							<tr>
                                <th><?php echo $row->date; ?></th>
								<td><?php echo $row->url; ?></td>
								<td>
                                    <div class="aw-badge <?php if($row->status == 1){ echo "bg-sucess";}else{ echo "bg-danger";} ?>" >
                                    <?php if($row->status == 1){ echo "Completed";} else { echo "Canceled"; } ?>
                                    </div>
                                </td>
							</tr>

                            <?php } ?>

						</tbody>
					</table>
				</div>

			</div>




            <!--- =====================================================================
                  Popup
                  ==================================================================--->

                <div class="aw-overlay" id="importModel">
                    <div class="aw-model">
                        <img src="<?= plugin_dir_url( __FILE__ ).'/loading-gif.gif' ?>">
                        <h2>Processing....</h2>
                    </div>
                </div><!-- ========== aw-overlay ======== -->







            <script>


                jQuery(document).ready(function(){
                    
                jQuery('#icsForm').on('submit', function(e) {

                    e.preventDefault();

                    var form = jQuery(this);
                    var formData = new FormData(form[0]);

                    jQuery('#importModel').show();

                    jQuery.ajax({
                        url:"<?= admin_url( 'admin-ajax.php' ); ?>", 
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            // console.log(response);
                            jQuery('#importModel').find('.aw-model').html('<h2>'+response.data+'</h3>');
                            
                            setTimeout(() => {
                                jQuery('#importModel').fadeOut();
                                location.reload();
                            }, 3000);

                        },
                        error: function(xhr, status, error) {
                            // Handle the error
                            // console.error(xhr.responseText);
                            jQuery('#importModel').find('.aw-model').html('<h2>'+xhr.responseText+'</h3>');
                            setTimeout(() => {
                                jQuery('#importModel').fadeOut();
                            }, 3000);
                        }
                    });

                    });

                });

            </script>