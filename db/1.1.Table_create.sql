
-- Node
CREATE TABLE `wp_atlas`.`wp_node` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `type` varchar(20) NOT NULL,
  `usuario` varchar(16) DEFAULT '',
  `dt_creacion` timestamp NOT NULL ,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
COMMENT='Tabla encargada de representar los nodos del sistema.';



-- Relation
CREATE TABLE `wp_atlas`.`wp_realation` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `source` int(9) NOT NULL,
  `target` int(9) NOT NULL,
  `name` varchar(100) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
COMMENT='Tabla encargada de representar los nodos del sistema.';
