SELECT distinct id_prueba, fechaSolicitud, fechaRespuesta, descripcionEstatus, descripcionPrueba, descripcionPrioridad, id_administrador,id_metrologo,
	id_solicitante, nombreUsuario, descripcionTipo
FROM  SolicitudPrueba s
LEFT JOIN Usuario u, TipoPrueba tp, Prioridad p, TipoUsuario tu, EstatusPrueba ep
WHERE s.id_estatusPrueba = ep.id_estatusPrueba
AND   s.id_tipoPrueba    = tp.id_tipoPrueba
AND   p.id_prioridad     = s.id_prioridad
AND   u.id_tipoUsuario   = tu.id_tipoUsuario




SELECT DISTINCT 
    id_prueba, 
    fechaSolicitud, 
    fechaRespuesta, 
    descripcionEstatus, 
    descripcionPrueba, 
    descripcionPrioridad, 
    s.id_administrador, 
    u_admin.nombreUsuario AS nombreAdmin, 
    tu_admin.descripcionTipo AS tipoAdmin,
    s.id_metrologo, 
    u_metro.nombreUsuario AS nombreMetro, 
    tu_metro.descripcionTipo AS tipoMetro,
    s.id_solicitante, 
    u_solic.nombreUsuario AS nombreSolic, 
    tu_solic.descripcionTipo AS tipoSolic
FROM  
    SolicitudPrueba s
LEFT JOIN 
    Usuario u_admin ON s.id_administrador = u_admin.id_usuario
LEFT JOIN 
    TipoUsuario tu_admin ON u_admin.id_tipoUsuario = tu_admin.id_tipoUsuario
LEFT JOIN 
    Usuario u_metro ON s.id_metrologo = u_metro.id_usuario
LEFT JOIN 
    TipoUsuario tu_metro ON u_metro.id_tipoUsuario = tu_metro.id_tipoUsuario
LEFT JOIN 
    Usuario u_solic ON s.id_solicitante = u_solic.id_usuario
LEFT JOIN 
    TipoUsuario tu_solic ON u_solic.id_tipoUsuario = tu_solic.id_tipoUsuario
LEFT JOIN 
    TipoPrueba tp ON s.id_tipoPrueba = tp.id_tipoPrueba
LEFT JOIN 
    Prioridad p ON s.id_prioridad = p.id_prioridad
LEFT JOIN 
    EstatusPrueba ep ON s.id_estatusPrueba = ep.id_estatusPrueba;

	
	