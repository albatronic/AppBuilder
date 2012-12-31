
<!doctype html>
 
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>jQuery UI Accordion - Sortable</title>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />
    <script src="http://code.jquery.com/jquery-1.8.3.js"></script>
    <script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
    <link rel="stylesheet" href="/resources/demos/style.css" />
    <style>
    /* IE has layout issues when sorting (see #5413) */
    .group { zoom: 1 }
    </style>
    <script>
    $(function() {
        $( "#accordion" )
            .accordion({
                header: "> div > h3"
            })
            .sortable({
                axis: "y",
                handle: "h3",
                stop: function( event, ui ) {
                    // IE doesn't register the blur when sorting
                    // so trigger focusout handlers to remove .ui-state-focus
                    ui.item.children( "h3" ).triggerHandler( "focusout" );
                }
            });
    });
    </script>
</head>
<body>
<?php if ($_POST['accion'] == 'Reordena') {?>
    <h2>Se supone que has reordenado el arcordeón, el nuevo orden es:</h2>
    <pre><?php print_r($_POST['acordeon']);?></pre>
<?php } else {?> 
    <h1>JUANITO, REORDENA EL ARCORDEON, AL FAVOR</h1>
<?php }?>

<form action="acordeon.php" method="POST">
    <div id="accordion">
        <?php for ($i=0;$i<10;$i++){?>
        <div class="group">
            <h3>Section <?php echo $i;?></h3>
            <div>
                <input name="acordeon[<?php echo $i;?>]" value="<?php echo $i;?>" type="hidden"/>
                <p>Este es el acordeon <?php echo $i;?></p>
            </div>
        </div>
        <?php } ?>
    </div>
    
    <input value="Reordena" name="accion" type="submit" />
</form>
 
</body>
</html>