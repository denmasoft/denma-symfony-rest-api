DROP PROCEDURE IF EXISTS `NOMS`;
CREATE PROCEDURE `NOMS`(IN `varx` varchar(8))
BEGIN
SELECT
PF.FRACCION, P.CVE_PERMISO, P.DESC_PERMISO,
CASE WHEN PF.PARCIALIDAD = 1 THEN 'UNICAMENTE: '
			WHEN PF.PARCIALIDAD = 2 THEN 'EXCEPTO: ' ELSE '' END,
PF.DESCRIPCION_GRAL_PARC, P.ARTICULO_NO, CP.MINISTRY_NAME
FROM PERMISOS P
LEFT OUTER JOIN PERMISOS_FRACCIONES PF ON (P.ID_PERMISO = PF.ID_PERMISO)
LEFT OUTER JOIN CAT_SECRETARIAS CP ON (P.CVE_SECRETARIA = CP.MINISTRY_CD)
WHERE PF.FRACCION = varx
AND  SYSDATE() BETWEEN PF.INI_VIG AND PF.FIN_VIG
AND  SYSDATE() BETWEEN P.INI_VIG AND P.FIN_VIG

END