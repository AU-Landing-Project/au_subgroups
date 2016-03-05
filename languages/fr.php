<?php

return array(
	'au_subgroups' => "Sous-groupes",
	'au_subgroups:subgroup' => "Sous-groupe",
	'au_subgroups:subgroups' => "Sous-groupes",
	'au_subgroups:parent' => "Groupe parent",
	'au_subgroups:add:subgroup' => 'Créer un sous-groupe',
	'au_subgroups:nogroups' => "Aucun Sous-groupe n'a été créé",
	'au_subgroups:error:notparentmember' => "Les membres ne peuvent pas rejoindre un sous-groupe s'ils ne sont pas membres du groupe parent",
	'au_subtypes:error:create:disabled' => "La création de sous-groupe a été désactivée pour ce groupe",
	'au_subgroups:noedit' => "Impossible de modifier ce groupe",
	'au_subgroups:subgroups:delete' => "Supprimer le groupe",
	'au_subgroups:delete:label' => "Que faire des publications de ce groupe ? Votre choix sera également appliqué à tous les sous-groupes qui seront supprimés.",
	'au_subgroups:deleteoption:delete' => 'Supprimer toutes les publications de ce groupe',
	'au_subgroups:deleteoption:owner' => 'Transférer toutes les publications à leurs auteurs',
	'au_subgroups:deleteoption:parent' => 'Transférer toutes les publications dans le groupe parent',
	'au_subgroups:subgroup:of' => "Sous-groupe de %s",
	'au_subgroups:setting:display_alphabetically' => "Afficher la liste des groupes des membres dans l'ordre alphabétique ?",
	'au_subgroups:setting:display_subgroups' => 'Afficher les sous-groupes dans la liste des groupes ?',
	'au_subgroups:setting:display_featured' => 'Afficher les groupes en Une dans la barre latérale de la liste des groupes des membres ?',
	'au_subgroups:error:invite' => "Les membres suivants ne sont pas membres du groupe parent et ne peuvent pas être invités/ajoutés.",
	'au_subgroups:option:parent:members' => "Membres du groupe parent",
	'au_subgroups:subgroups:more' => "Afficher tous les sous-groupes",
	'subgroups:parent:need_join' => "Inscrire dans le groupe parent",
	
	// group options
	'au_subgroups:group:enable' => "Sous-groupes : permettre la création de sous-groupes dans ce groupe ?",
	'au_subgroups:group:memberspermissions' => "Sous-groupes : permettre à tous les membres de créer des sous-groupes ? (si non, seuls les responsables du groupe pourront créer des sous-groupes)",
	
	/*
	 * Widget
	 */
	'au_subgroups:widget:order' => 'Tri les résultats',
	'au_subgroups:option:default' => 'Date de création',
	'au_subgroups:option:alpha' => 'Alphabétique',
	'au_subgroups:widget:numdisplay' => 'Nombre de sous-groupes à afficher',
	'au_subgroups:widget:description' => 'Liste des sous-groupes de ce groupe',
	
	/*
	 * Move group
	 */
	'au_subgroups:move:edit:title' => "Déplacer en sous-groupe d'un autre groupe",
	'au_subgroups:transfer:help' => "Vous pouvez définir ce groupe comme le sous-groupe de tout autre groupe dont vous êtes responsable. Si les membres du groupe ne sont pas membres du nouveau groupe parent, ils seront retirés de ce groupe et recevront une invitation au groupe parent ainsi qu'à tous les autres groupes jusqu'à celui-ci. <b>Cette action déplace également tous les sous-groupes de ce groupe</b>",
	'au_subgroups:search:text' => "Rechercher des groupes",
	'au_subgroups:search:noresults' => "Aucun groupe trouvé",
	'au_subgroups:error:timeout' => "La recherche a excedé la durée maximale autorisée",
	'au_subgroups:error:generic' => "Une erreur s'est produite lors de la recherche",
	'au_subgroups:move:confirm' => "Etes-vous sûr de vouloir faire de ce groupe un sous-groupe d'un autre groupe ?",
	'au_subgroups:error:permissions' => "Vous devez avoir le droit de modifier ce groupe et tous les groupes parents auxquels il se rattache. Par ailleurs un groupe ne peut pas être déplacé comme sous-groupe de l'un de ses propres sous-groupes ou de soi-même.",
	'au_subgroups:move:success' => "Le groupe a bien été déplacé",
	'au_subgroups:error:invalid:group' => "Identifiant de groupe invalide",
	'au_subgroups:invite:body' => "Bonjour %s,

Le groupe %s a été déplacé et modifié en sous-groupe du groupe %s.
Comme vous n'êtes actuellement pas membre du groupe parent, vous avez avez été retiré des membres du sous-groupe. Vous avez été ré-invité dans le groupe, et si vous acceptez cette invitation vous serez automatiquement intégré dans le(s) groupe(s) parent(s).

Cliquez ci-dessous pour afficher vos invitations :
%s",

);
