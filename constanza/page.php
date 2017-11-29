<?php get_header(); ?>

<?php
if (have_posts()) : while (have_posts()) : the_post();
        get_template_part('content', get_post_format());
        $pagename = get_query_var('pagename');
        $contentPage = get_the_content();

        if ($pagename == "recibos") {

            if (isset($_POST['actividadNode'])) {
                //echo 'Value post:  ' . $_POST['nameNode'];
                node_insert();
            } else {
                echo 'None post';
            }
            ?>
            <script>var page = <?php echo '"' . $pagename . '"' ?>;checkPage(page);</script>
            <div id="section-recibo" class="container text-center" style="background-image: url(<?php echo get_bloginfo('template_url') ?>/img/dust_scratches.png);">
                <?php
                $counter = 0;
                $args = array(
                    category_name => 'recibo'
                );
                $query = new WP_Query($args);
                $pathWP = get_bloginfo('template_url');
                if ($query->have_posts()) {
                    while ($query->have_posts()) {
                        $query->the_post();
                        echo '<h1 class="">' . get_the_title() . '</h1>';
                        echo '<p class="">' . get_the_content() . '</p>';
                    }
                }

                wp_reset_postdata();
                ?>


                <form id="myForm" name="myForm"  act    ion="<?php admin_url('admin-post.php') ?>" onsubmit="return validateForm1()" method="post">
                    <div class="form-group">
                        <div class="row ">
                            <div class="col-xs-4 text-right">
                                <label for = "sel1">Su nombre:</label>
                            </div>
                            <div class="col-xs-1" >
                                <button class="btn btn-purple" id="btn-nodeInsert" title="Agrege un nuevo usuario"  >+</button>
                            </div>
                            <div class="col-xs-4" >

                                <select class = "form-control" id = "duenoNode" name="duenoNode" >
                                    <?php
                                    $query = "SELECT * FROM wp_dueno wt";

                                    $result = $wpdb->get_results($query);
                                    $actividad = "nodes: [";
                                    foreach ($result as $k => $v) {
                                        echo '<option>' . $v->name . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="row center">
                            <div class="col-xs-4 text-right">
                                <label for="usr">¿Qué compró?</label>
                            </div>
                            <div class="col-xs-1" >
                            </div>
                            <div class="col-xs-4">
                                <input name="actividadNode" type="text" class="form-control" id="actividadNode">                            
                            </div>
                        </div>

                        <div class="row center">
                            <div class="col-xs-4 text-right">
                                <label for="usr">Lugar:</label>
                            </div>
                            <div class="col-xs-1" >
                                <button class="btn btn-purple" id="btn-nodeInsert" title="Agrege un nuevo lugar"  >+</button>
                            </div>
                            <div class="col-xs-4">
                                <input name="lugarNode" type="text" class="form-control" id="lugarNode" >                       
                            </div>
                        </div>
                        <hr>
                        <div id="menuBtn" class="row "> 
                            <div class="col-xs-12 align-center center-block">
                                <label for="usr">Ahora....agregar relaciónes e interacciones:</label>
                                <button type="button" class="btn btn-default"  id="btn-nodeInsert" alt="Agregar Relación" onclick="addRelation()" >+</button>
                                <p id="tag-rel"></p>
                            </div>

                            <div class="col-xs-12 align-center center-block">
                                <button  class="btn btn-success"  id="btn-nodeInsert" onclick="printRecibo()" >Imprimir Recibo</button>
                                <p id="tag-rel"></p>
                            </div>
                        </div>
                        <hr>                        
                    </div>

                    <div id="relacionesImg" class=" row col-xs-12">                        
                    </div>
                    <div id="personas" class="row">
                    </div>
                    <div id="">
                        <H3>GRACIAS</h3>
                        <h4>Vuelva Pronto</h4>
                    </div>

                </form>
            </div>
            <div id="section-navegar" class="row center sectionPage">    
                <?php
                $counter = 0;
                $args = array(
                    category_name => 'navegar'
                );
                $query = new WP_Query($args);
                $pathWP = get_bloginfo('template_url');

                if ($query->have_posts()) {
                    while ($query->have_posts()) {
                        $query->the_post();
                        echo '<div class="col-xs-6">';
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
                        <li class="li-line menu-title white"><a class="black" href="<?php echo get_permalink(get_page_by_title('graph')); ?>" >Navegar</a></li>
                    </ul>
                </div>
            </div>
            <?php
        } else if ($pagename == "graph") {

            $query = "
            SELECT *
            FROM wp_actividad wt";

            $result = $wpdb->get_results($query);
            $actividad = "nodes: [";
            foreach ($result as $k => $v) {
                $group = new DateTime($v->dt_creacion);
                $group = 1;
                //   $actividad = $actividad . '{name:"' . $v->name . '",lugar:"' . $v->lugar . '",type:"' . 'Actividad' . '",profesion:"' . '' . '",size:' . $v->size . ',date:"' . $v->dt_creacion . '"},';
                $actividad = $actividad . '{id:"' . $v->name . '",' . 'lugar:"' . $v->lugar . '",type:"' . 'Actividad' . '",profesion:"' . '' . '",size:' . $v->size . ',"group":' . $group . ',date:"' . $v->dt_creacion . '"},';
            }

            $query = "
            SELECT *
            FROM wp_persona wt";

            $result = $wpdb->get_results($query);


            foreach ($result as $k => $v) {
                //$group = new DateTime($v->dt_creacion);
                $group = 1;
                $actividad = $actividad . '{id:"' . $v->name . '",' . 'lugar:"' . '' . '",type:"' . 'Persona' . '",profesion:"' . $v->profesion . '",size:' . $v->size . ',"group":' . $group . ',date:"' . $v->dt_creacion . '"},';
            }

            $query = "
            SELECT *
            FROM wp_dueno wt";

            $result = $wpdb->get_results($query);


            foreach ($result as $k => $v) {
                //$group = new DateTime($v->dt_creacion);
                $group = 1;
                $actividad = $actividad . '{id:"' . $v->name . '",' . 'lugar:"' . '' . '",type:"' . 'Dueno' . '",profesion:"' . '' . '",size:' . '10' . ',"group":' . $group . ',date:"' . $v->dt_creacion . '"},';
            }

            $query = "
            SELECT *
            FROM wp_lugar wt";

            $result = $wpdb->get_results($query);


            foreach ($result as $k => $v) {
                //$group = new DateTime($v->dt_creacion);
                $group = 1;
                $actividad = $actividad . '{id:"' . $v->name . '",' . 'lugar:"' . '' . '",type:"' . 'Lugar' . '",profesion:"' . '' . '",size:' . $v->size . ',"group":' . $group . ',date:"' . $v->dt_creacion . '"},';
            }


            $actividad = $actividad . "],";

            $query = "
            SELECT *
            FROM wp_relation wt";

            $result = $wpdb->get_results($query);
            $edges = "links: [";
            foreach ($result as $k => $v) {
                $edges = $edges . '{source:"' . $v->source . '",target:"' . $v->target . '",name:"' . $v->name . '",id:' . $v->id . ',value:1' . ',type:"' . $v->type . '"},';
            }
            $edges = $edges . "]";

            //print_r($actividad);
            //print_r($edges);
            ?>
            <script>var page = <?php echo '"' . $pagename . '"' ?>;checkPage(page);</script>
            <div id = "status"></div>

            <script src="https://d3js.org/d3.v4.min.js"></script>

            <div id="section-graph" class="container">

                <div id="menu-sm" class="row">
                    <div  class="col-xs-6">
                        <?php
                        $counter = 0;
                        $args = array(
                            category_name => 'titulo'
                        );
                        $query = new WP_Query($args);
                        $pathWP = get_bloginfo('template_url');
                        if ($query->have_posts()) {
                            while ($query->have_posts()) {
                                $query->the_post();
                                echo '<h1 class="logo neon-1 white" onclick=>' . get_the_title() . '</h1>';
                                echo '</div>';
                                echo ' <div  class="col-xs-6">';
                                //echo '<h3 class="logo neon-1 center-block white">' . "El atlas: " . get_the_content() . '</h1>';
                            }
                        }

                        wp_reset_postdata();
                        ?>
                    </div>

                </div>
                <div id="btnMenu" >
                    <div   class="row ">
                        <div  style="margin-top: 0px" class="col-xs-2">
                        </div>
                        <div  style="margin-top: 0px" class="col-xs-8 center-block center">
                            <h2 class="white">Convenciones</h2>

                            <div class="panel center-block text ">    
                                <h3 class="white">Actividades</h3>
                                <div class="convention actividad center-block"></div>
                            </div>
                            <div class="panel center-block text">    
                                <h3 class="white">Lugares</h3>
                                <div class="convention lugar"></div>
                            </div>
                            <div class="panel center-block text">    
                                <h3 class="white">Dueños de Recibos</h3>
                                <div class="convention dueno"></div>
                            </div>
                            <div class="panel center-block text">    
                                <h3 class="white">Personas</h3>
                                <div class="convention persona"></div>
                            </div>
                        </div>
                        <div   class="col-xs-2">
                        </div>
                    </div>
                    <div  style="margin-top: 0px" class="row ">
                        <div  style="margin-top: 0px" class="col-xs-2">
                        </div>
                        <div  style="margin-top: 0px" class="col-xs-8 center-block center">
                            <h2 class="white">Filtro de Relaciones</h2>
                            <!-- 
                            <div class="panel center-block text">    
                                <h3 class="white">Personas</h3>
                                <button type="button" class="filter-btn" id="btn-flt-lnk-persona" value="Persona" onclick="filterMaster('rel-Persona');">On</button>
                            </div>
                            -->
                            <div class="panel center-block text">    
                                <h3 class="white">Actividades</h3>
                                <button type="button" class="filter-btn" id="btn-flt-lnk-actividad" value="Actividad" onclick="filterMaster('rel-Actividad')">On</button>
                            </div>
                            <div class="panel center-block text">    
                                <h3 class="white">Lugares</h3>
                                <button type="button" class="filter-btn" id="btn-flt-lnk-lugar" value="Actividad" onclick="filterMaster('rel-Lugar')">On</button>
                            </div>
                            <div class="panel center-block text">    
                                <h3 class="white">Dueños de Recibos</h3>
                                <button type="button" class="filter-btn" id="btn-flt-lnk-dueno" value="Actividad" onclick="filterMaster('rel-Dueno')">On</button>
                            </div>

                        </div>
                        <div  style="margin-top: 0px" class="col-xs-2">
                        </div>
                    </div>
                    <!-- <div  style="margin-top: 0px" class="row ">
                        <div  style="margin-top: 0px" class="col-xs-2">
                        </div>
                        <div  style="margin-top: 0px" class="col-xs-8 center-block center">
                            <h2 class="white">Encontrar Relación:</h2>

                            <div class="panel center-block text">    
                                <h3 class="white">Por dueño específico</h3>

                                <select class = "form-control" id = "duenoNode" name="duenoNode" >
                    <?php
                    $query = "SELECT * FROM wp_dueno wt";

                    $result = $wpdb->get_results($query);

                    foreach ($result as $k => $v) {
                        echo '<option>' . $v->name . '</option>';
                    }
                    ?>
                                </select>

                            </div>
                            <div class="panel center-block text">    
                                <button type="button" class="filter-btn" id="btn-flt-byDueno"  onclick="findByDueno()">Buscar</button>
                            </div>
                            <div class="panel center-block text">    
                                <button type="button" class="filter-btn" id="btn-flt-Clear"  onclick="findByClear()">Limpiar</button>

                            </div>

                        </div>
                        <div  style="margin-top: 0px" class="col-xs-2">
                        </div>
                    </div>
                    -->

                </div>
                <div id="dashboard" class="panel" >
                    <div class="row">
                        <h1>Name: </h1>
                        <h2>Type:</h2>
                        <h3>Date:</h3>
                        <h4>Profesion:</h4>

                    </div>
                    <div id="relaciones" class="row">

                    </div>
                </div>
                <div id="grapsvg"  class="row">
                    <svg width="1000" height="720"></svg>
                </div>

            </div>

            <script>
                var data = {<?php echo $actividad . $edges ?>};

                //	data stores
                var graph, store;



                //	svg selection and sizing
                var svg = d3.select("svg"),
                        width = +svg.attr("width"),
                        height = +svg.attr("height")
                        ;
                //	d3 color scales
                var color = d3.scaleOrdinal(d3.schemeCategory10);
                var link = svg.append("g").selectAll(".link"),
                        node = svg.append("g").selectAll(".node");
                //	force simulation initialization
                var simulation = d3.forceSimulation()
                        .force("link", d3.forceLink()
                                .id(function (d) {
                                    return d.id;
                                }))
                        .force("charge", d3.forceManyBody()
                                .strength(function (d) {
                                    return -100;
                                }))
                        .force("center", d3.forceCenter(width / 2, height / 2));
                //	filtered types
                typeFilterList = [];
                //	filter button event handlers

                function filterMaster(action) {
                    var id = "";
                    var act = "";

                    if (action === 'rel-Persona') {
                        id = "Persona";
                        act = "link";

                        offLabel("btn-flt-lnk-persona");
                    } else if (action === 'rel-Actividad') {
                        id = "Actividad";
                        act = "link";

                        offLabel("btn-flt-lnk-actividad");
                    } else if (action === 'rel-Lugar') {
                        id = "Lugar";
                        act = "link";

                        offLabel("btn-flt-lnk-lugar");
                    } else if (action === 'rel-Dueno') {
                        id = "Dueno";
                        act = "link";

                        offLabel("btn-flt-lnk-dueno");
                        /*} else if (action === 'nod-Persona') {
                         id = "Persona";
                         act = "node";
                         
                         offLabel("btn-flt-nod-persona");
                         } else if (action === 'nod-Actividad') {
                         id = "Actividad";
                         act = "node";
                         offLabel("btn-flt-nod-actividad");
                         */} else {
                        console.log("Filter not define");
                        return;
                    }

                    if (typeFilterList.includes(id)) {
                        typeFilterList.splice(typeFilterList.indexOf(id), 1);
                        console.log("remove " + id);

                    } else {
                        typeFilterList.push(id);
                        console.log("add " + id);
                    }

                    filter(id, act);
                    update();
                }


                //	data read and store

                var nodeByID = {};
                data.nodes.forEach(function (n) {
                    nodeByID[n.id] = n;
                    //console.log("id:" + n.id);
                });
                data.links.forEach(function (l) {
                    //console.log(nodeByID[l.source].group + " " + nodeByID[l.target].group);
                    l.sourceGroup = nodeByID[l.source].group.toString();
                    l.targetGroup = nodeByID[l.target].group.toString();
                });
                graph = data;
                store = $.extend(true, {}, data);
                update();
                //	general update pattern for updating the graph
                function update() {
                    //	UPDATE
                    node = node.data(graph.nodes, function (d) {
                        return d.id;
                    });
                    //	EXIT
                    node.exit().remove();
                    //	ENTER
                    var newNode = node.enter().append("circle")
                            .attr("class", "node")
                            .attr("r", function (d) {
                                return d.size
                            })
                            .attr("fill", function (d) {
                                if (d.type === "Actividad") {
                                    return "gray";
                                } else if (d.type === "Lugar") {
                                    return "red";
                                } else if (d.type === "Persona") {
                                    return "blue";
                                } else if (d.type === "Dueno") {
                                    return "yellow";

                                } else
                                    return color(d.group);
                            })
                            .on("mouseover", function (d) {
                                //console.log("mouse over:" + d.id + " " + d.size);
                                //console.log(d3.select(this));
                                d3.select(this).transition()
                                        .duration(750)
                                        .attr("r", d.size * 2);
                            })
                            .on("mouseout", function (d) {
                                //console.log("mouse over:" + d.id + " " + d.size);
                                //console.log(d3.select(this));
                                d3.select(this).transition()
                                        .duration(750)
                                        .attr("r", d.size);
                            }).on("click", function (d) {
                        console.log("Click:" + d.id + " " + d.size);
                        //console.log(d3.select(this));
                        $("#dashboard h1").text(d.id);
                        $("#dashboard h2").text(d.type);
                        $("#dashboard h3").text(d.date.substring(0, 10));
                        $("#dashboard h4").text(d.profesion);


                        d3.select(this).transition()
                                .duration(750)
                                .attr("r", d.size);
                    })

                            .call(d3.drag()
                                    .on("start", dragstarted)
                                    .on("drag", dragged)
                                    .on("end", dragended)
                                    )

                    newNode.append("title")
                            .text(function (d) {
                                return "group: " + d.group + "\n" + "id: " + d.id;
                            });
                    //	ENTER + UPDATE
                    node = node.merge(newNode);
                    //	UPDATE
                    link = link.data(graph.links, function (d) {
                        return d.id;
                    });
                    //	EXIT
                    link.exit().remove();
                    //	ENTER
                    newLink = link.enter().append("line")
                            .attr("class", "link");
                    newLink.append("title")
                            .text(function (d) {
                                return "source: " + d.source + "\n" + "target: " + d.target;
                            });
                    //	ENTER + UPDATE
                    link = link.merge(newLink);
                    //	update simulation nodes, links, and alpha
                    simulation
                            .nodes(graph.nodes)
                            .on("tick", ticked);
                    simulation.force("link")
                            .links(graph.links);
                    simulation.alpha(1).alphaTarget(0).restart();
                }

                //	drag event handlers
                function dragstarted(d) {
                    if (!d3.event.active)
                        simulation.alphaTarget(0.3).restart();
                    d.fx = d.x;
                    d.fy = d.y;
                }

                function dragged(d) {
                    d.fx = d3.event.x;
                    d.fy = d3.event.y;
                }

                function dragended(d) {
                    if (!d3.event.active)
                        simulation.alphaTarget(0);
                    d.fx = null;
                    d.fy = null;
                }

                //	tick event handler with bounded box
                function ticked() {
                    node
                            .attr("cx", function (d) {
                                return d.x = Math.max(d.size, Math.min(width - d.size, d.x));
                            })
                            .attr("cy", function (d) {
                                return d.y = Math.max(d.size, Math.min(height - d.size, d.y));
                            });
                    link
                            .attr("x1", function (d) {
                                return d.source.x;
                            })
                            .attr("y1", function (d) {
                                return d.source.y;
                            })
                            .attr("x2", function (d) {
                                return d.target.x;
                            })
                            .attr("y2", function (d) {
                                return d.target.y;
                            });
                }

                //	filter function


                function filter(type, action) {

                    // Links
                    if (action === "link" && (type === "Persona" || type === "Actividad" || type === "Lugar" || type === "Dueno")) {
                        //	add and remove links from data based on availability of nodes
                        store.links.forEach(function (l) {
                            if (!(typeFilterList.includes(l.type) || typeFilterList.includes(l.type)) && l.filtered) {
                                l.filtered = false;
                                graph.links.push($.extend(true, {}, l));
                            } else if ((typeFilterList.includes(l.type) || typeFilterList.includes(l.type)) && !l.filtered) {
                                l.filtered = true;
                                graph.links.forEach(function (d, i) {
                                    if (l.type === d.type) {
                                        graph.links.splice(i, 1);
                                    }
                                });
                            }
                        });
                    } else if (action === "node" && (type === "Persona" || type === "Actividad")) {
                        //if (type === "Actividad") {
                        //    filterMaster("rel-Persona");
                        //}
                        //filter(type, "link");

                        store.nodes.forEach(function (n) {
                            if (!typeFilterList.includes(n.type) && n.filtered) {
                                n.filtered = false;
                                graph.nodes.push($.extend(true, {}, n));
                            } else if (typeFilterList.includes(n.type) && !n.filtered) {
                                n.filtered = true;
                                graph.nodes.forEach(function (d, i) {
                                    if (n.id === d.id) {
                                        graph.nodes.splice(i, 1);
                                    }
                                });
                            }
                        });
                        filterMaster("rel-Persona");
                    }


                    /*
                     else{
                     store.nodes.forEach(function (n) {
                     if (!typeFilterList.includes(n.type) && n.filtered) {
                     n.filtered = false;
                     graph.nodes.push($.extend(true, {}, n));
                     } else if (typeFilterList.includes(n.type) && !n.filtered) {
                     n.filtered = true;
                     graph.nodes.forEach(function (d, i) {
                     if (n.id === d.id) {
                     graph.nodes.splice(i, 1);
                     }
                     });
                     }
                     });    
                     }*/

                }
            </script>
            <div id="section-surecibo" class="row center sectionPage">    
                <?php
                $counter = 0;
                $args = array(
                    category_name => 'imprimir'
                );
                $query = new WP_Query($args);
                $pathWP = get_bloginfo('template_url');

                if ($query->have_posts()) {
                    while ($query->have_posts()) {
                        $query->the_post();
                        echo '<div class="col-xs-6">';
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
                        <li class="li-line menu-title white"><a class="black" href="<?php echo get_permalink(get_page_by_title('recibos')); ?>" >Registre otro Recibo</a></li>
                    <!--  <li class="li-line menu-title white"><p onclick="printRecibo()" style=" cursor: pointer; padding-bottom: 0!important;margin-bottom: 4px!important;">Imprima su recibo</p></li>
                     -->   
                    </ul>
                </div>
            </div>


            <?php
        } else if ($pagename == "el-cierre") {
            ?>
            <script>var page = <?php echo '"' . $pagename . '"' ?>;</script>
            <div class="container" style="margin-top: 100px;">
                <div  class="row center-block">
                    <p class="white">Seleccione el dueño de recibo de relaciones que quiere imprimir.</p>
                </div>

                <div  class="row center">

                    <div class="col-xs-4" >

                        <select class = "form-control" id = "duenoNode" name="duenoNode" >
                            <?php
                            $query = "SELECT * FROM wp_dueno wt";

                            $result = $wpdb->get_results($query);
                            $actividad = "nodes: [";
                            foreach ($result as $k => $v) {
                                echo '<option>' . $v->name . '</option>';
                            }
                            ?>
                        </select>

                    </div>
                </div>
                <div  class="row center" style="margin-top: 100px">
                    <p class="white">Se imprimira el ultimo recibo creado por el dueño.</p>
                </div>
                <div id="btnQuien" class="row center" style="margin-top: 100px;">
                    <div class="center-block menu">
                        <ul class="ul-line">
                            <li id="link-constanza" class="li-line menu-title white" onclick="printRecibo()"><p>Imprimir recibo</p></li>
                            <script>
                                function findLastRecibo() {

            <?php
            $query = "SELECT * FROM wp_dueno wt";

            $result = $wpdb->get_results($query);
            $actividad = "nodes: [";
            foreach ($result as $k => $v) {
                echo '<option>' . $v->name . '</option>';
            }
            ?>
                                }
                            </script>
                        </ul>
                    </div>
                </div>

            </div>

            <div id="section-footer" class="row center" style="margin-top: 300px;   ">
                <div class="center-block menu">
                    <ul class="ul-line">
                        <li class="li-line menu-title white"><a class="black" href="<?php echo get_home_url(); ?>" >Inicio</a></li>
                        <li class="li-line menu-title white"><a class="black" href="<?php echo get_permalink(get_page_by_title('recibos')); ?>" >Registre otro Recibo</a></li>
                    </ul>
                </div>
            </div>
            <?php
        }

    endwhile;
endif;
?>

<?php get_footer(); ?>