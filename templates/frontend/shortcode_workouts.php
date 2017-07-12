<?php 
date_default_timezone_set('UTC');
?>	
	<style>
		.pp-icons-plans { 
			cursor:pointer;
			margin:0 20px;
		}
	</style>
	<div class="wp-pushpress">
		<div class="workout-date">
			<button name="btnToday" class="btnToday" type="button">Today</button>
			<button name="btnTomorrow" class="btnTomorrow" type="button">Tomorrow</button>
			<input name="txtDate" class="txtDate" type="button" size="10" value="">
		</div>
            
		<div class="line-date">
                    <span><h2><?php echo empty($date) ? date('l, F jS') : date('l, F jS', $date); ?></h2></span> 
		</div>
		<?php foreach( $workouts as $key => $workout ): ?>
                        <h2><?php echo $workout['track_name'];?></h2>
			<div class="wp-pushpress-list">
				<?php if ( count($workout['data']) > 0 ): ?>
					<?php foreach ($workout['data'] as $key => $item):?>							
						<div class="item-other">
                                                    <h3><?php echo $item['type']; if(!empty($item['public_notes'])){?>
                                                        <i class="pp-icons-plans"></i>
                                                    <?php }?>
                                                    </h3>
                            <?php 
                            	if ($item['name']) { 
                            		echo '<p class="workout-title"><strong>' . $item['name'] . '</strong></p>';
                            	}
                            ?>                                                
							<p><?php echo $item['description'];?></p>
							<?php 
                            	if (strlen(trim($item['public_notes']))) { ?>
                                <p class="public_notes">
                                	<strong>Notes:</strong>
                                	<br/>
                                    <?php echo $item['public_notes']?>
                                </p>
                            <?php }?>
							<div class="clear"></div>
						</div>
					<?php endforeach;?>
				<?php else: ?>

					<div class="item-other">No Workout scheduled.</div>
				<?php endif; ?>

			</div>
		<?php endforeach;?>

	</div>
	<script type="text/javascript">
	  	jQuery( function( $ ) {

	  		function set_dateparams( dateval ){
				var url = window.location.href;
				if ( url.indexOf('?') ){
					var end = url.indexOf('?');
					window.location.href = url.substr(0, end) + "?datefilter=" + dateval;
				}else{
					window.location.href = url + "?datefilter=" + dateval;
				}
			}
			var textdate = ".txtDate";
	  		$( textdate ).datepicker( );
			//$( textdate ).datepicker( "option", "dateFormat", 'mm-dd-yy' );
			$( textdate ).on('change', function(){
				var dateval = $( textdate ).val();

				set_dateparams( dateval );
			});

			$( textdate ).on('click', function(){
				$(this).datepicker('show');
			});

			$( '.btnToday' ).on('click', function(){
                            var currDate = new Date();
                            var dateval = ( currDate.getMonth() + 1) + "/" + currDate.getDate() + "/" + currDate.getFullYear();
                            set_dateparams( dateval );
                            
//				var dateval = $( textdate ).val();
//				var firstDay = new Date( dateval );
//				var prevWeek = new Date( firstDay.getTime() - 7 * 24 * 60 * 60 * 1000 );
//				var dateval = ( prevWeek.getMonth() + 1) + "/" + prevWeek.getDate() + "/" + prevWeek.getFullYear();
//				set_dateparams( dateval );
			});

			$( '.btnTomorrow' ).on('click', function(){
//				var firstDay = new Date( dateval );
//				var nextWeek = new Date(firstDay.getTime() + 7 * 24 * 60 * 60 * 1000);
				var currDate = new Date();
				var tomorrow = new Date(currDate.getTime() + 1 * 24 * 60 * 60 * 1000);
				var dateval = ( tomorrow.getMonth() + 1 ) + "/" + tomorrow.getDate() + "/" + tomorrow.getFullYear();
				set_dateparams( dateval );
			});

			$( textdate ).val('<?php echo empty( $date ) ? date( 'm/d/Y' ) : date( 'm/d/Y', $date ) ;?>');
                        
                         makeDisabled();
                        function makeDisabled(){
                            var dateval = new Date($(".txtDate").val());
//                            var line_date = $.datepicker.formatDate('DD, MM', new Date(dateval)) + ' '+formatDayHaveSuffix($.datepicker.formatDate('dd', new Date(dateval)));
//                            $('.lbl-date').text(line_date);
                            var currDate = new Date();
                            var tomorrow = new Date(currDate.getTime() + 1 * 24 * 60 * 60 * 1000);
                            currDate.setHours(0, 0, 0, 0);//reset hours is zero
                            dateval.setHours(0, 0, 0, 0);//reset hours is zero
                            tomorrow.setHours(0, 0, 0, 0);//reset hours is zero
                            if(currDate.valueOf() === dateval.valueOf()){
                                $( '.btnToday' ).attr('disabled','disabled');
                           }
                            if(tomorrow.valueOf() === dateval.valueOf()){
                                $( '.btnTomorrow' ).attr('disabled','disabled');
                            }
                        }
                        
                        $('.pp-icons-plans').click(function(){
                            $('.public_notes').slideToggle();
                        });
                        
//                        function formatDayHaveSuffix(day){
//                            switch(day) {
//                                case '1': case '21': case '31': suffix = 'st'; break;
//                                case '2': case '22': suffix = 'nd'; break;
//                                case '3': case '23': suffix = 'rd'; break;
//                                default: suffix = 'th';
//                            }
//                            return day + suffix;
//                        }
		});
  	</script>