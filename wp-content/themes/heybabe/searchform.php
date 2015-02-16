<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
	<label>
		<span class="screen-reader-text">Zoeken</span>
		<input type="search" class="search-field" value="<?php echo get_search_query(); ?>" name="s" title="Zoeken" />
	</label>
	<input type="submit" class="search-submit" value="Search" />
</form>