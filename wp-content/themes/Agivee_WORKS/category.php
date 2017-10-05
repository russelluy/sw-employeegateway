    Jeremy222
	<?php
      $portfolio_cats_include = get_option('Ag_portfolio_cats_include');
      if(is_array($portfolio_cats_include)) {
        $portfolio_include = implode(",",$portfolio_cats_include);
      } 
      
      if(is_array($portfolio_cats_include)) {
        foreach ($portfolio_cats_include as $catinclude) {
          if(is_category($catinclude))
            include(TEMPLATEPATH . '/category-portfolio.php');
          } 
      } else {
        if(is_category($portfolio_cats_include)) {
          include(TEMPLATEPATH . '/category-portfolio.php'); 
        }
      }
    ?>