DROP PROCEDURE IF EXISTS `NOMS`;
CREATE PROCEDURE `NOMS`(IN `varx` varchar(8))
BEGIN
SELECT
NF.FRACCION, N.NORMA,
CASE WHEN NF.CVE_UNI_EXC = 1 THEN 'Unicamente: '
	WHEN NF.CVE_UNI_EXC = 2 THEN 'Excepto: ' else '' end uni_exc,
NF.DESC_PARCIALIDAD, N.ART_NOM, S.NOMBRE_SECRETARIA
FROM  NOMS N, NOMS_FRACCIONES NF, CAT_SECRETARIAS S
WHERE NF.FRACCION = varx
AND N.ID_NOM = NF.ID_NOM
AND SYSDATE() BETWEEN N.INI_VIG AND N.FIN_VIG
AND SYSDATE() BETWEEN NF.INI_VIG AND NF.FIN_VIG
AND S.CVE_SECRETARIA = N.CVE_SECRETARIA
END