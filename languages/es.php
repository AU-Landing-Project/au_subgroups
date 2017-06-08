<?php

return array(
    'au_subgroups' => 'Subgrupos',
    'au_subgroups:subgroup' => 'Subgrupo',
    'au_subgroups:subgroups' => 'Subgrupos',
    'au_subgroups:parent' => 'Grupo padre',
    'au_subgroups:add:subgroup' => 'Crear un subgrupo',
    'au_subgroups:nogroups' => 'No se ha creado el subgrupo',
    'au_subgroups:error:notparentmember' => 'Los usuarios no pueden unirse a un subgrupo si no son miembros del grupo padre',
    'au_subtypes:error:create:disabled' => 'La creación de subgrupos se ha deshabilitado para este grupo',
    'au_subgroups:noedit' => 'No se puede editar este grupo',
    'au_subgroups:subgroups:delete' => 'Borrar grupo',
    'au_subgroups:delete:label' => '¿Qué debe pasar con el contenido de este grupo? Cualquier opción seleccionada se aplicará también a cualquier subgrupo que se elimine.',
    'au_subgroups:deleteoption:delete' => 'Eliminar todo el contenido dentro de este grupo',
    'au_subgroups:deleteoption:owner' => 'Transferir todo el contenido de los creadores originales',
    'au_subgroups:deleteoption:parent' => 'Transferir todo el contenido al grupo padre',
    'au_subgroups:subgroup:of' => 'Subgrupo de %s',
    'au_subgroups:setting:display_alphabetically' => '¿Visualizar los anuncios personales de grupos por orden alfabético?',
    'au_subgroups:setting:display_subgroups' => '¿Mostrar subgrupos en los anuncios del grupo estándar?',
    'au_subgroups:setting:display_featured' => '¿Mostrar barra lateral grupos destacados en las listas de grupos personales?',
    'au_subgroups:error:invite' => 'La acción ha sido cancelada - los usuarios siguientes no son miembros del grupo padre y no pueden ser invitados/agregados.',
    'au_subgroups:option:parent:members' => 'Los miembros del grupo padre',
    'au_subgroups:subgroups:more' => 'Ver todos los subgrupos',
    'subgroups:parent:need_join' => 'Unirse al grupo padre',
	
	// group options
	'au_subgroups:group:enable' => "Subgrupos: ¿Activar subgrupos para este grupo?",
	'au_subgroups:group:memberspermissions' => "Subgrupos: ¿Permitir a cualquier miembro crear subgrupos? (Si no, sólo los administradores del grupo podrán crear subgrupos)",
    
    /*
     * Widget
     */
    'au_subgroups:widget:order' => 'Ordenar los resultados por',
    'au_subgroups:option:default' => 'Hora de creación',
    'au_subgroups:option:alpha' => 'Alfabético',
    'au_subgroups:widget:numdisplay' => 'Número de subgrupos para mostrar',
    'au_subgroups:widget:description' => 'Lista de los subgrupos de este grupo',
	
	/*
	 * Move group
	 */
	'au_subgroups:move:edit:title' => 'Hacer de este grupo un subgrupo de otro grupo',
	'au_subgroups:transfer:help' => 'Puedes hacer de este grupo un subgrupo de cualquier otro grupo del que tengas permisos para editar. Si los usuarios no son miembros del nuevo grupo al que lo vas a asociar, se eliminaran del subgrupo y recibirán una invitación para añadirse en el nuevo grupo con todos sus subgrupos que tenga. Esta acción también va a transferir cualquier subgrupo de este grupo.</b>',
	'au_subgroups:search:text' => 'Buscar Grupos',
	'au_subgroups:search:noresults' => 'No se han encontrado grupos',
	'au_subgroups:error:timeout' => 'El tiempo de espera para esta busqueda ha finalizado',
'au_subgroups:error:generic' => 'Ha ocurrido un error con esta busqueda',
	'au_subgroups:move:confirm' => 'Estas seguro o segura que quieres transformarlo en un subgrupo de otro grupo?',
	'au_subgroups:error:permissions' => 'Tienes que tener permisos de edición para el grupo y todos sus subgrupos. Por cierto, un grupo no se puede mover como un subgrupo del mismo grupo.',
	'au_subgroups:move:success' => 'Has movido correctamente este grupo. Felicidades.',
	'au_subgroups:error:invalid:group' => 'Identificador de grupo invalido',
	'au_subgroups:invite:body' => 'Hola %s,

El administrador del grupo %s lo ha movido como subgrupo de otro grupo %s.
No hemos podido moverte a la nueva ubicación del subgrupo porque no estabas en el grupo que ahora lo contiene. 
Para poder solucionarlo te hemos mandado una invitación para entrar a formar parte de ese grupo y sus subgrupos. 

Haz clic aqui para ver tus invitaciones:

%s',

);
