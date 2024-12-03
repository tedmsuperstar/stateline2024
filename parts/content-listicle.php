<h1 id="title"><?= get_the_title() ?></h1>
<div id="content">
    <?= get_the_content() ?>
</div>
<ul class="listicle">
    <?php
    //don't lazy-load the first two images. Page renders faster.
    $counter = 0;
    while (have_rows('product_block')) {
        the_row(); 
        $product = get_sub_field('product');
        $product_text = get_sub_field('product_text');
        
        ?>
        <li>
        <a title="<?=get_field('name',$product)?>" href="<?=get_field('url',$product)?>">
            <article class="product-card">
                
                <div><img <?php if($counter > 1){?>loading="lazy"<?php }?> alt="<?=get_field('name',$product)?>"
                        srcset="<?=get_field('image1x',$product)?> 1x, <?=get_field('image2x',$product)?> 2x"
                        src="<?=get_field('image2x',$product)?>"></div>
                <section>
                    <div>
                        <h2 class="location"><?=get_field('display_location',$product)?></h2>
                        <span  class="display-name"><?=get_field('name',$product)?></span>
                    </div>
                    <div >
                        <span class="display-price"><?=get_field('display_price',$product)?></span>
                    </div>
                </section>
                
            </article>
            </a>
            <div class="product-text"><?=$product_text?></div>
        </li>
    <?php 
    $counter++;
    } ?>
</ul>