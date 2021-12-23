<h2 class="mb-0"><?php the_title(); ?></h2>
<p class='mt-0'><?php the_date(); ?></p>

<article>
    <?php the_excerpt(); ?>
</article>

<a href="<?php the_permalink() ?>">Lire plus à propos de "<?php the_title() ?>"</a>
