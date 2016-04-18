<?php
$data_prazo_inc2 = " DATE_ADD( pi.inicio , INTERVAL 
CASE WHEN pi.dias=0 THEN 0 ELSE  
		CASE WHEN MOD(pi.dias-1,5)=0 THEN
			CASE WHEN DAYOFWEEK( DATE_ADD( pi.inicio , INTERVAL 1 DAY ))=7 or DAYOFWEEK( DATE_ADD( pi.inicio , INTERVAL 1 DAY ))=1 THEN
				(pi.dias-1)/5*2+2+pi.dias
			ELSE
				CASE WHEN DAYOFWEEK( DATE_ADD( pi.inicio , INTERVAL 1 DAY )) IN (7,1,2) THEN
					(pi.dias-1)/5*2+pi.dias+2
				ELSE	
					(pi.dias-1)/5*2+pi.dias
				END	
			END
		ELSE
			CASE WHEN MOD(pi.dias-2,5)=0 THEN
				CASE WHEN DAYOFWEEK( DATE_ADD( pi.inicio , INTERVAL 2 DAY ))=7 or DAYOFWEEK( DATE_ADD( pi.inicio , INTERVAL 2 DAY ))=1 THEN
					(pi.dias-2)/5*2+2+pi.dias
				ELSE
					CASE WHEN DAYOFWEEK( DATE_ADD( pi.inicio , INTERVAL 2 DAY )) IN (7,1,2) THEN	
						(pi.dias-2)/5*2+pi.dias+2
					ELSE
						(pi.dias-2)/5*2+pi.dias
					END
				END				
			ELSE
				CASE WHEN MOD(pi.dias-3,5)=0 THEN
					CASE WHEN DAYOFWEEK( DATE_ADD( pi.inicio , INTERVAL 3 DAY ))=7 or DAYOFWEEK( DATE_ADD( pi.inicio , INTERVAL 3 DAY ))=1 THEN
						(pi.dias-3)/5*2+2+pi.dias
					ELSE
					    CASE WHEN DAYOFWEEK( DATE_ADD( pi.inicio , INTERVAL 3 DAY )) IN (7,1,2) THEN
							(pi.dias-3)/5*2+pi.dias+2
						ELSE
							(pi.dias-3)/5*2+pi.dias
						END	
					END
				ELSE
					CASE WHEN MOD(pi.dias-4,5)=0 THEN
						CASE WHEN DAYOFWEEK( DATE_ADD( pi.inicio , INTERVAL 4 DAY ))=7 or DAYOFWEEK( DATE_ADD( pi.inicio , INTERVAL 4 DAY ))=1 THEN
							(pi.dias-4)/5*2+2+pi.dias
						ELSE
							CASE WHEN DAYOFWEEK( DATE_ADD( pi.inicio , INTERVAL 4 DAY )) IN (7,1,2,3) THEN
								(pi.dias-4)/5*2+pi.dias+2
							ELSE
								(pi.dias-4)/5*2+pi.dias
							END
						END
					ELSE						
						pi.dias/5*2+pi.dias
					END
				END	
			END
		END	
	  END 
	  DAY ) ";
$sql_feriados = "(CASE WHEN (select (@dias_fer:=COUNT(fer.id_feriado)) from vsites_feriados as fer where date_format(pi.inicio, '%y-%m-%d')<=fer.data and date_format((@data_fer:=".$data_prazo_inc2."), '%y-%m-%d')>=fer.data) > 0 THEN (select (@dias_fer:=@dias_fer+COUNT(fer.id_feriado)) from vsites_feriados as fer where date_format(@data_fer, '%y-%m-%d')<=fer.data and date_format(DATE_ADD( @data_fer , INTERVAL @dias_fer DAY ), '%y-%m-%d')>=fer.data and (fer.id_empresa='0' or fer.id_empresa='1')) ELSE (0) END) ";
$data_prazo_inc ="DATE_ADD( pi.inicio , INTERVAL 
CASE WHEN pi.dias=0 THEN 0 ELSE  
		CASE WHEN MOD(pi.dias+".$sql_feriados."-1,5)=0 THEN
			CASE WHEN DAYOFWEEK( DATE_ADD( pi.inicio , INTERVAL 1 DAY ))=7 or DAYOFWEEK( DATE_ADD( pi.inicio , INTERVAL 1 DAY ))=1 THEN
				(pi.dias+@dias_fer-1)/5*2+2+pi.dias+@dias_fer
			ELSE
				CASE WHEN DAYOFWEEK( DATE_ADD( pi.inicio , INTERVAL 1 DAY )) IN (7,1,2) THEN
					(pi.dias+@dias_fer-1)/5*2+pi.dias+@dias_fer+2
				ELSE	
					(pi.dias+@dias_fer-1)/5*2+pi.dias+@dias_fer
				END	
			END
		ELSE
			CASE WHEN MOD(pi.dias+@dias_fer-2,5)=0 THEN
				CASE WHEN DAYOFWEEK( DATE_ADD( pi.inicio , INTERVAL 2 DAY ))=7 or DAYOFWEEK( DATE_ADD( pi.inicio , INTERVAL 2 DAY ))=1 THEN
					(pi.dias+@dias_fer-2)/5*2+2+pi.dias+@dias_fer
				ELSE
					CASE WHEN DAYOFWEEK( DATE_ADD( pi.inicio , INTERVAL 2 DAY )) IN (7,1,2) THEN	
						(pi.dias+@dias_fer-2)/5*2+pi.dias+@dias_fer+2
					ELSE
						(pi.dias+@dias_fer-2)/5*2+pi.dias+@dias_fer
					END
				END				
			ELSE
				CASE WHEN MOD(pi.dias+@dias_fer-3,5)=0 THEN
					CASE WHEN DAYOFWEEK( DATE_ADD( pi.inicio , INTERVAL 3 DAY ))=7 or DAYOFWEEK( DATE_ADD( pi.inicio , INTERVAL 3 DAY ))=1 THEN
						(pi.dias+@dias_fer-3)/5*2+2+pi.dias+@dias_fer
					ELSE
					    CASE WHEN DAYOFWEEK( DATE_ADD( pi.inicio , INTERVAL 3 DAY )) IN (7,1,2) THEN
							(pi.dias+@dias_fer-3)/5*2+pi.dias+@dias_fer+2
						ELSE
							(pi.dias+@dias_fer-3)/5*2+pi.dias+@dias_fer
						END	
					END
				ELSE
					CASE WHEN MOD(pi.dias+@dias_fer-4,5)=0 THEN
						CASE WHEN DAYOFWEEK( DATE_ADD( pi.inicio , INTERVAL 4 DAY ))=7 or DAYOFWEEK( DATE_ADD( pi.inicio , INTERVAL 4 DAY ))=1 THEN
							(pi.dias+@dias_fer-4)/5*2+2+pi.dias+@dias_fer
						ELSE
							CASE WHEN DAYOFWEEK( DATE_ADD( pi.inicio , INTERVAL 4 DAY )) IN (7,1,2,3) THEN
								(pi.dias+@dias_fer-4)/5*2+pi.dias+@dias_fer+2
							ELSE
								(pi.dias+@dias_fer-4)/5*2+pi.dias+@dias_fer
							END
						END
					ELSE						
						(pi.dias+@dias_fer)/5*2+pi.dias+@dias_fer
					END
				END	
			END
		END	
	  END 
	  DAY )";
$data_prazo_inc='pi.data_prazo';	  
?>