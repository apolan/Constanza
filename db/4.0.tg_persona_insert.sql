DROP TRIGGER IF EXISTS wp_atlas.trg_persona_insert;

DELIMITER $$
CREATE  TRIGGER `wp_atlas`.`trg_persona_insert` BEFORE INSERT ON wp_atlas.wp_node FOR EACH ROW
BEGIN
	DECLARE personas VARCHAR(500);
	DECLARE lastActividad VARCHAR(500);
	DECLARE element VARCHAR(500);
	DECLARE sourcel int;

	DECLARE nombre VARCHAR(500);
	DECLARE profesion VARCHAR(500);
	

	-- Se busca un dueno
	IF NOT EXISTS (SELECT 1 FROM `wp_atlas`.`wp_actividad` WHERE name = New.actividad  )  THEN

		INSERT INTO `wp_atlas`.`wp_actividad`
			(
			`name`,
			`lugar`,
			`size`,
			`dt_creacion`)
		VALUES
			(
			New.actividad,
			New.lugar,
			15,
			New.dt_creacion
			);
	ELSE
		UPDATE  `wp_atlas`.`wp_actividad` up
		SET up.size = up.size + 5
		WHERE name = New.actividad ;
		
	END IF;
	
	
	
	IF NEW.type = 'Actividad' then 
		SET personas = NEW.personas;
		
	-- Se busca una actividad igual
		IF NOT EXISTS (SELECT 1 FROM `wp_atlas`.`wp_dueno` WHERE name = New.dueno  )  THEN

			INSERT INTO `wp_atlas`.`wp_dueno`
				(
				`name`,
				`correo`,
				`dt_creacion`)
			VALUES (
				new.dueno,
				'dummy@gmail.com',
				new.dt_creacion);

			
		END IF;

		
		IF NOT EXISTS (SELECT 1 FROM `wp_atlas`.`wp_lugar` WHERE name = New.lugar  )  THEN

			INSERT INTO `wp_atlas`.`wp_lugar`
				(
				`name`,
				`size`,
				`dt_creacion`)
			VALUES
				(
				New.lugar,
				20,
				New.dt_creacion
                );
		ELSE
			UPDATE  `wp_atlas`.`wp_lugar` up
			SET up.size = up.size + 1
			WHERE name = New.lugar ;
			
		END IF;
		


		
		-- SELECT
		-- 	ac.name
		-- INTO
		-- 	lastActividad
		-- FROM `wp_atlas`.`wp_actividad` ac
		-- WHERE date(new.dt_creacion) = date(ac.dt_creacion)
		-- AND new.dt_creacion <> ac.dt_creacion
		-- ORDER by ac.dt_creacion
		-- desc limit 1;
	
		-- IF lastActividad <> "" THEN
		-- 	INSERT INTO `wp_atlas`.`wp_relation`
		-- 		(
		-- 		`source`,
		-- 		`target`,
		-- 		`name`,
		-- 		`type`
		-- 		)
		-- 	VALUES(
		-- 		New.actividad,
		-- 		lastActividad,
		-- 		"Actividad",
		-- 		"Actividad"
		-- 		)
		-- 		;
		-- END IF;
		
		
		-- Creo una relacion siempre que se crea un nodo | lugar -> persona | actividad -> persona  | actividad -> lugar

		-- set sourcel = LAST_INSERT_ID();

		-- 0. actividad -> lugar
			INSERT INTO `wp_atlas`.`wp_relation`
				(
				`source`,
				`target`,
				`name`,
				`type`)
			VALUES(
				New.lugar,
				New.actividad,
				"Persona",
				"Lugar"
				)
			;

			-- -- 3. actividad -> dueno
		 INSERT INTO `wp_atlas`.`wp_relation`
		 	(
		 	`source`,
		 	`target`,
		 	`name`,
		 	`type`)
		 VALUES(
		 	New.actividad,
		 	New.dueno,
		 	"Persona",
		 	"Actividad"
		 	)
		 ;
			
		WHILE personas != '' DO

			SET element = SUBSTRING_INDEX(personas, '_', 1);
			SET nombre = SUBSTRING_INDEX(element, '|', 1); -- Nombre de la persona
			SET profesion = SUBSTRING_INDEX(element, '|', -1);

			IF NOT EXISTS (SELECT 1 FROM `wp_atlas`.`wp_persona` WHERE name = nombre  )  THEN

				INSERT INTO `wp_atlas`.`wp_persona`
					(
					`name`,
					`profesion`,
					`size`,
					`actividad`,
					`dt_creacion`)
				VALUES (
					nombre,
					profesion,
					10,
					New.actividad,
					New.dt_creacion
					);
			END IF;

			-- 1. persona -> actividad
			INSERT INTO `wp_atlas`.`wp_relation`
				(
				`source`,
				`target`,
				`name`,
				`type`)
			VALUES(
				New.actividad,
				nombre,
				"Persona",
				"Actividad"
				)
			;
			-- -- 2. persona -> lugar
			-- INSERT INTO `wp_atlas`.`wp_relation`
			-- 	(
			-- 	`source`,
			-- 	`target`,
			-- 	`name`,
			-- 	`type`)
			-- VALUES(
			-- 	New.lugar,
			-- 	nombre,
			-- 	"Persona",
			-- 	"lugar"
			-- 	)
			-- ;
			-- 3. persona -> dueno
			INSERT INTO `wp_atlas`.`wp_relation`
				(
				`source`,
				`target`,
				`name`,
				`type`)
			VALUES(
				nombre,
				New.dueno,
				"Persona",
				"Dueno"
				)
			;
			

			IF LOCATE('_', personas) > 0 THEN
				SET personas = SUBSTRING(personas, LOCATE('_', personas) + 1);
			ELSE
				SET personas = '';
			END IF;
		END WHILE;
	END IF;
END$$
DELIMITER ;