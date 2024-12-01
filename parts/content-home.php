
<div id="content">
<ul class="article-list">
<?php

while (have_rows('article_list')) {
    the_row(); 
    $article = get_sub_field('article');
    
    ?>
    <li>
        <a href="<?=get_the_permalink($article)?>" class="article-card">
            <?=get_the_post_thumbnail($article, 'medium')?>
            <strong><?=get_the_title($article)?></strong>
        </a>
    </li>
<?php } ?>
</ul>
<?=get_the_content()?>
</div>
