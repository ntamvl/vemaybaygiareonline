<h2 class="nav-tab-wrapper">
	<?php foreach ( $tabs as $slug => $title ): ?>
		<a href="<?php echo esc_attr( admin_url( 'admin.php?page=' . rawurlencode( $slug ) ) ) ?>"
		   class="nav-tab<?php echo $active_tab === $slug ? esc_attr( ' nav-tab-active' ) : '' ?>">
			<?php echo $title ?>
		</a>
	<?php endforeach; ?>
</h2>