<!DOCTYPE html>
<html <?php language_attributes(); ?> style="margin-top:0!important">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!-- Prefetch DNS for external resources to speed up loading time -->
  	<link rel="dns-prefetch" href="//fonts.googleapis.com">
	<?php wp_head(); ?>
</head>
<?php
$article_id = get_post_meta( $post->ID, 'ph_demo_post_id', true );
$url = get_post_meta( $article_id, 'ph_demo_link', true );
?>
<body id="no-bar" <?php body_class( 'no-js' ); ?>>
	<div class="framing actionfont pht-milli pht-box pht-box--tiny" id="framing">
		
		<?php if ( have_posts() ) : 
			while (have_posts()) : the_post(); 
				previous_post_link( ' %link ', ' <span class="pht-icon pht-icon--tiny"><i class="pht-btn__icon pht-ic-f1-caret-left"></i></span> ' );
				next_post_link(' %link ', ' <span class="pht-icon pht-icon--tiny"><i class="pht-btn__icon pht-ic-f1-caret-right"></i></span> ');
			endwhile; 
		else:
		endif;?>
		<a class="article actionfont" href="<?php echo get_permalink( $article_id );?>">Back to article</a>
		<a id="close" class="pht-btn__icon pht-ic-f1-close pht-text-center" title="Close the iframe" href="<?php echo esc_url( $url ); ?>"></a>
	</div>
	<?php if ( $url ) { ?>
		<iframe  src="<?php echo esc_url( $url );?>"></iframe>
	<?php } else { ?>
		sorry no demo found
	<?php } ?>
	
</body>
</html>	