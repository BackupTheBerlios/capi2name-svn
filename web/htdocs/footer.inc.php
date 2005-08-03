<?php
/*
    copyright            : (C) 2002-2005 by Jonas Genannt
    email                : jonas.genannt@capi2name.de
 ***************************************************************************/

/***************************************************************************
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU General Public License as published by  *
 *   the Free Software Foundation; either version 2 of the License, or     *
 *   any later version.                                   *
 *                                                                         *
 ***************************************************************************/
$template->set_filenames(array('overall_footer' => 'templates/'.$_SESSION['template'].'/footer.tpl'));
$template->assign_vars(array('L_LOGOUT' => $textdata[header_inc_logout]));
$template->pparse('overall_footer');
?>
