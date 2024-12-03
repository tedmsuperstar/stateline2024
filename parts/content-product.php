<h1 id="title"><?= get_the_title() ?></h1>
<div id="content">
    <?= get_the_content() ?>
</div>

<a title="<?=get_field('name')?>" href="<?=get_field('url')?>">
<article class="product-card">
    
    <div><img  alt="<?=get_field('name')?>"
            src="<?=get_field('image2x')?>"></div>
    <section>
        <div>
            <h2 class="location"><?=get_field('display_location')?></h2>
            <span class="display-name"><?=get_field('name')?></span>
        </div>
        <div >
            <span class="display-price"><?=get_field('display_price')?></span>
        </div>
    </section>
</article>
</a>
        
   