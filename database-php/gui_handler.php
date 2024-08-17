<html>
<body>

<?php

if ($_POST['gui'] == 'create_database')
{
	include "create_db.php";
}

if ($_POST['gui'] == 'create_tables')
{
	include "create_tables.php";
}

if ($_POST['gui'] == 'default')
{
	include "load_default.php";
}

if ($_POST['gui'] == 'in_del_up')
{
	include "choose_op.php";
}

if ($_POST['gui'] == 'query')
{
	include "choose_query.php";
}

if ($_POST['gui'] == 'view')
{
	include "choose_view.php";
}

if ($_POST['gui'] == 'delete')
{
	include "delete_tables.php";
}
?>

</body>
</html>