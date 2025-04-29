
<style>
     <?php echo get_site_option('header_css'); ?>
</style>
<div class="header-container">
    <div class="header-col1 header-column">   
        <h1  class="header-title">  
            <a class="header-txt" href="<?php echo get_site_option('title_link'); ?> "> <?php echo get_site_option('title_text'); ?> </a>
        </h1>

        <?php if (!empty($data->logos[1])): ?>
            <a class='header-image-container' href="<?php echo $data->logos[1]['link']; ?>">
                <img class="<?php echo $data->logos[1]['css_class']; ?>" src="<?php echo $data->logos[1]['url']; ?>" />
            </a>
        <?php endif; ?>
    </div>
    <div class="header-col2 header-column"> 

       <p class="header-subtext"> <?php echo get_site_option('header_text'); ?> </p>

    </div>
    <div class="header-col3 header-column"> 
``
        <?php if (!empty($data->logos[0])): ?>
            <a class='header-image-container' href="<?php echo $data->logos[0]['link']; ?>">
                <img class="<?php echo $data->logos[0]['css_class']; ?>" src="<?php echo $data->logos[0]['url']; ?>" />
            </a>
        <?php endif; ?>
    </div>
</div>

</div>


