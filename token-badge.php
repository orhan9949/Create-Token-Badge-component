<?php
//require '';
require_once get_template_directory(). '/includes/theme/template-functions.php';
$arr = $args["coin_arr"];
$showPrice = $args["showPrice"] ?? false;
$showChange = $args["showChange"] ?? false;
?>

<span class="token-badge">

    <img src="<?php echo $arr->image ?>" alt="<?php echo $arr->name ?>" class="token-badge__image">

    <span class="token-badge__symbol"><?php echo $arr->symbol ?></span>

    <?php if ( $showPrice ): ?>

        <span class="token-badge__price"><?php echo cn_format_price( $arr->current_price, 2 ); ?></span>

    <?php endif; ?>

    <?php if ( $showChange ): ?>

        <span class="token-badge__change <?php echo ($arr->price_change_percentage_24h > 0)? 'token-badge__change-color--up' : 'token-badge__change-color--down' ; ?>"
        ><?php echo cn_format_percentage( $arr->price_change_percentage_24h )?></span>

    <?php endif; ?>

    <a class="token-badge__link" href="<?php echo $arr->link ?>"><?php echo $arr->name ?></a>

</span>

