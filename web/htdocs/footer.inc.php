<?
$template->set_filenames(array('overall_footer' => 'templates/'.$_SESSION['template'].'/footer.tpl'));
$template->assign_vars(array('L_LOGOUT' => $textdata[header_inc_logout]));
$template->pparse('overall_footer');
?>
