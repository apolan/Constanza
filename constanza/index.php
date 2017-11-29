<?php
get_header();
?>

<?php
node_activate();
?>
<script>var page = <?php echo '"' . $pagename . '"' ?>;</script>


<div id="section-home" class="row sectionPage ">
    <div id="welcome" class="row col-xs-12 img-responsive center-block">
        <img  id="on-img" src="<?php echo get_bloginfo('template_url') ?>/img/gif/welcome.gif" alt="Welcome " title="Loading" />
    </div>


</div>
<div class="row center-block">
    <div id="lights" class=" col-xs-12  text-center">
        <img id="switch" src="<?php echo get_bloginfo('template_url') ?>/img/switch.png" class="text-center"/>
        <div id="on" class="" onclick="lightsOff('on')"></div>
        <div id="off" class="" onclick="lightsOff('off')"></div> 
        <div></div>
    </div>
</div>

<!-- Section msj - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - --->
<div id="section-msj" class="row center sectionPage">
    <?php
    $counter = 0;
    $args = array(
        category_name => 'mensaje'
    );
    $query = new WP_Query($args);
    $pathWP = get_bloginfo('template_url');

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            echo '<div class="col-xs-5">';
            echo '<h1 class="black80 pull-right lights-2" >' . get_the_title() . '</h1>';
            echo '</div>';
            echo '<div class="col-xs-6">';
            echo '<p class="black80 lights">' . get_the_content() . '</p>';
            echo '</div>';
        }
    }

    wp_reset_postdata();
    ?>
</div>
<div id="btnLeer" class="row center" style="margin-top: 10px;">
    <div class="center-block menu">
        <ul class="ul-line">
            <li id="link-constanza" class="li-line menu-title white" onclick="nextPage()"><p>Navegar el Atlas</p></li>
        </ul>
    </div>
</div>

<div id="section-title" class="row center sectionPage">
    <div  class="col-xs-12 text-center  " >
        <?php
        $counter = 0;
        $args = array(
            category_name => 'titulo'
        );
        $query = new WP_Query($args);
        $pathWP = get_bloginfo('template_url');
        echo '<h3 class="logo neon-1 center-block white">' . "El atlas:" . '</h1>';
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                echo '<h1 class="logo black80 lights-1">' . get_the_title() . '</h1>';
                echo '<h2 class="logo black80 lights-1">' . get_the_content() . '</p>';
            }
        }

        wp_reset_postdata();
        ?>

    </div>
</div>
<div id="btnQuien" class="row center" style="margin-top: 100px;">
    <div class="center-block menu">
        <ul class="ul-line">
            <li id="link-constanza" class="li-line menu-title white" onclick="nextPage()"><p>¿Quién es Constanza?</p></li>
        </ul>
    </div>
</div>

<div id="section-publicidad" class="ad row">
    <div id="section-ad-1" > <!-- Ads BACKGROUND -->        
    </div>
    <?php
    $counter = 0;
    $args = array(
        category_name => 'pregunta',
        'orderby' => 'date',
        'order' => 'DESC'
    );
    $query = new WP_Query($args);
    $pathWP = get_bloginfo('template_url');
    echo '<div class="preguntas">';
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            echo '<div id="' . $counter . '_preg" class="pregunta row center">';
            echo '<div class="col-xs-5 pr">';
            echo '<h1 class="black80 pull-right lights-2" >' . get_the_title() . '</h1>';
            echo '</div>';
            echo '<div class="col-xs-6 rta" >';
            //echo '<p class="black80 pull-right" >' . get_the_content() . '</p>';
            echo '<h1 class= "yes black80 lights-3 clickable" onclick="answer(' . $counter . ',&quot;yes&quot;)">Si</h1> ';
            echo '<h1 class= "no black80 lights-3 clickable" onclick="answer(' . $counter . ',&quot;no&quot;)">No</h1> ';
            echo '</div>';
            echo '</div>';
            $counter++;
        }
        echo '</div>';
    }

    wp_reset_postdata();
    ?>
</div>

<div id="section-constanza" class="row sectionPage">    
    <?php
    $counter = 0;
    $args = array(
        category_name => 'Constanza'
    );
    $query = new WP_Query($args);
    $pathWP = get_bloginfo('template_url');
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            global $post;
            $post_slug = $post->post_name;
            $name = get_the_title();

            echo '<div class="col-xs-5">';
            echo '<h1 class="black80 pull-right lights-1" style="text-align:right;">' . get_the_title() . '</h1>';
            echo '</div>';
            echo '<div class="col-xs-6">';
            echo '<p class="black80 lights">' . get_the_content() . '</p>';
            echo '</div>';
        }
    }
    wp_reset_postdata();
    ?>            
</div>

<div id="section-definicion" class="row center sectionPage">    
    <?php
    $counter = 0;
    $args = array(
        category_name => 'definicion'
    );
    $query = new WP_Query($args);
    $pathWP = get_bloginfo('template_url');

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            echo '<div class="col-xs-5">';
            echo '<h1 class="black80 pull-right lights-2" >' . get_the_title() . '</h1>';
            echo '</div>';
            echo '<div class="col-xs-6">';
            echo '<p class="black80 lights">' . get_the_content() . '</p>';
            echo '</div>';
        }
    }

    wp_reset_postdata();
    ?>
</div>

<div id="section-footer" class="row center">

    <div class="center-block menu">
        <ul class="ul-line">
            <li class="li-line menu-title white"><a class="black" href="<?php echo get_home_url(); ?>" >Inicio</a></li>
            <li class="li-line menu-title white"><a class="black" href="<?php echo get_permalink(get_page_by_title('recibos')); ?>" >Registre un Recibo</a></li>
        </ul>
    </div>
</div>






<?php
get_footer();
