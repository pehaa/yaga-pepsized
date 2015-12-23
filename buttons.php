<?php

$download_url= trim( get_post_meta( get_the_ID(), 'ph_attachment_link', true ) );
$demo_button = (int) get_post_meta( get_the_ID(), 'ph_demo_id', true );
$donate = get_post_meta( get_the_ID(),'ph_donate_button', true );

if ( $download_url && $demo_button > 0 ) { ?>
	
	<div class="pht-layout "><!--
		--><div class="pht-layout__item u-1-of-2-desk u-1-of-2-lap">
			<div class="pht-colorbox  pht-box--valign-top " style="">
				<div class="phtpb_item pht-btn__container pht-btn__container-center pht-text-center phtpb_width--value5">
					<a href="<?php echo esc_url( get_the_permalink( $demo_button ) );?>" class="pht-btn pht-btn__pb  u-1-of-1-desk u-1-of-1-lap pht-rounded--none" target="_self">
						<i class="pht-btn__icon pht-ic-f1-caret-right-circle"></i> <span class="pht-btn__text" data-pht-tcontent="See the Demo"><span class="pht-btn__textin">See the Demo</span></span>
					</a>
				</div>
			</div>
		</div><!--
	--><div class="pht-layout__item u-1-of-2-desk u-1-of-2-lap">
			<div class="pht-colorbox  pht-box--valign-top " style="">
			<div class="phtpb_item pht-btn__container pht-btn__container-center pht-text-center phtpb_width--value5">
				<a href="<?php echo esc_url( $download_url );?>" class="pht-btn pht-btn__pb  u-1-of-1-desk u-1-of-1-lap pht-rounded--none" target="_self">
					<i class="pht-btn__icon pht-ic-f1-download"></i> <span class="pht-btn__text" data-pht-tcontent="Download .zip"><span class="pht-btn__textin">Download .zip</span></span>
				</a>
			</div>
		</div>
	</div><!--
--></div>
<?php } elseif ( $download_url ) { ?>
	<div class="phtpb_item pht-btn__container pht-btn__container-center pht-text-center phtpb_width--value5">
		<a href="<?php echo esc_url( $download_url );?>" class="pht-btn pht-btn__pb  u-1-of-1-desk u-1-of-1-lap pht-rounded--none" target="_self">
			<i class="pht-btn__icon pht-ic-f1-download"></i> <span class="pht-btn__text" data-pht-tcontent="Download .zip"><span class="pht-btn__textin">Download .zip</span></span>
		</a>
	</div>

<?php } elseif ( $demo_button > 0 ) { ?>
	<div class="phtpb_item pht-btn__container pht-btn__container-center pht-text-center phtpb_width--value5">
		<a href="<?php echo esc_url( get_the_permalink( $demo_button ) );?>" class="pht-btn pht-btn__pb  u-1-of-1-desk u-1-of-1-lap pht-rounded--none" target="_self">
			<i class="pht-btn__icon pht-ic-f1-caret-right-circle"></i> <span class="pht-btn__text" data-pht-tcontent="See the Demo"><span class="pht-btn__textin">See the Demo</span></span>
		</a>
	</div>
<?php }
if ( $donate ) { ?>
	<form class="paypal pht-mb0" action="https://www.paypal.com/cgi-bin/webscr" method="post">
		<input type="hidden" name="lc" value="GB">
		<input type="hidden" name="cmd" value="_s-xclick">	
		<div class="phtpb_item pht-btn__container pht-btn__container-center pht-text-center phtpb_width--1plus phtpb_width--075plus phtpb_width--value10">
		<button type="submit" class="pht-btn pht-btn__pb  pht-mb0 u-1-of-1-desk u-1-of-1-lap pht-rounded--none" target="_self" name="submit">
			<i class="pht-btn__icon pht-ic-f1-cup"></i>
			<span class="pht-btn__text" data-pht-tcontent="Buy me a coffee. Thanks!"><span class="pht-btn__textin">Buy me a coffee. Thanks!</span></span>
		</button>
		<img class="pht-mb0" alt="" border="0" src="https://www.paypalobjects.com/fr_FR/i/scr/pixel.gif" width="1" height="1">
		</div>
	</form>
<?php }