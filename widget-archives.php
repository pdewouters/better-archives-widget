<?php

/**
 * Class Baw_Widgetarchives_Widget_My_Archives
 */
class Baw_Widgetarchives_Widget_My_Archives extends WP_Widget {

	//process the new widget
	function baw_widgetarchives_widget_my_archives() {
		$widget_ops = array(
			'classname'   => 'baw_widgetarchives_widget_class',
			'description' => __( 'Display links to archives grouped by year then month.', 'better-archives-widget' ),
		);
		parent::__construct( 'baw_widgetarchives_widget_my_archives', __( 'Custom Archives Widget', 'better-archives-widget' ), $widget_ops );
	}

	//build the widget settings form
	function form( $instance ) {
		$defaults = array( 'title' => 'archives' );
		$instance = wp_parse_args( (array) $instance, $defaults );
		$title    = $instance['title'];

		?>
		<p><?php esc_html_e( 'Title:', 'better-archives-widget' ); ?>
			<input class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<?php
	}

	//save the widget settings
	function update( $new_instance, $old_instance ) {
		$instance          = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );

		return $instance;
	}

	//display the widget
	function widget( $args, $instance ) {
		extract( $args );

		echo $before_widget;
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'Archives', 'better-archives-widget' ) : $instance['title'], $instance, $this->id_base );


		if ( ! empty( $title ) ) {
			echo $before_title . $title . $after_title;
		};

		// years - months

		global $wpdb;
		$prevYear    = '';
		$currentYear = '';

		/**
		 * Filter the SQL WHERE clause for retrieving archives.
		 */
		$where = apply_filters( 'getarchives_where', "WHERE post_type = 'post' AND post_status = 'publish' AND post_date <= now()" );

		/**
		 * Filter the SQL JOIN clause for retrieving archives.
		 */
		$join = apply_filters( 'getarchives_join', '' );

		if ( $months = $wpdb->get_results( "SELECT YEAR(post_date) AS year, MONTH(post_date) AS numMonth, DATE_FORMAT(post_date, '%M') AS month, count(ID) as post_count FROM $wpdb->posts $join $where GROUP BY YEAR(post_date), MONTH(post_date) ORDER BY post_date DESC" ) ) {
			echo '<ul>';
			foreach ( $months as $month ) {
				$currentYear = $month->year;
				if ( ( $currentYear !== $prevYear ) && ( '' !== $prevYear ) ) {
					echo '</ul></li>';
				}
				if ( $currentYear !== $prevYear ) {
					?>
					<li class="baw-year">
					<a href="<?php echo esc_url( get_year_link( $month->year ) ); ?>"><?php echo esc_html( $month->year ); ?></a>
					<ul class="baw-months">
					<?php
				} ?>
				<li class="baw-month">
					<a href="<?php echo esc_url( get_month_link( $month->year, $month->numMonth ) ); ?>"><?php echo esc_html( $month->month . ' ' . $month->year ); ?></a>
				</li>
				<?php
				$prevYear = $month->year;
			}
		}
		?>
		</ul></li>
		<?php
		echo '</ul>';
		echo $after_widget;
	}
}
