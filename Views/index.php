<?php
include_once ('../vendor/autoload.php');
use weTask\Product\Product;
$obj = new Product();
$data = $obj->index();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TODOS</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <div class="col-md-6">
    <h1>todos</h1>
        <form method="post" action="store.php">
        <div class="card" style="width: 45rem;">
            <div class="card-header">
                <input type="text" name="name" id="todo_name" class="form-control" aria-label="Amount (to the nearest dollar)">
            </div>
            <?php if(isset($data) && !empty($data)){
                foreach ($data as $d){ ?>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><input type="checkbox" id="status" class="mr4" name="status[]" value="<?php echo $d['id']?>">
                            <span id="edititem_<?php echo $d['id']?>" class="strikethrough">
                                <?php echo $d['name']?>
                            </span>
                            <span id="1edititem_<?php echo $d['id']?>">
                            </span>
                        </li>
                    </ul>
            <?php } ?>
                <div class="card-header">
                    <table>
                        <tr>
                            <td><?php echo count($data) . ' Item Left'?></td>
                            <td class="mr"><a href="store.php">All</a> </td>
                            <td class="mr"><button type="button" class="btn btn-link" id="active">Active</button></td>
                            <td class="mr"><a href="complete.php">Completed</a> </td>
                        </tr>
                    </table>
                </div>
            <?php } ?>
        </div>
    </form>

    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $('ul').find('li>span').dblclick(function(e){
            var x = $(e.target).closest('ul>li>span').attr('id');
            $("#"+1+x).empty();
            var val = $(e.target).closest('ul>li>span').text();
            $("#"+x).dblclick( function () {
                $("#"+1+x).empty();
                $("#" + 1 + x).show();
                $("#"+1+x).append('<input type="text" id="input_'+x+'" value="'+$.trim(val)+'">')
                $("#" + x).hide();
            });
            $("#"+1+x).dblclick( function () {
                $("#" + 1 + x).hide();
                $("#" + x).show();
            });
            $("#"+1+x).keydown( function (e) {
                if (e.keyCode == 13) {
                    var name = ($("#input_"+x).val());
                    var spitdata = (x.split('_'));
                    var id = spitdata[1];
                    if(name && id){
                        $.ajax({
                            type: "POST",
                            url: "update.php",
                            dataType: 'html',
                            data: { name:name, id:id },
                            success: function(data){
                                location.reload();
                                //$('#myResponse').html(data)
                            }
                        });
                    }
                    $("#" + 1 + x).hide();
                    $("#" + x).show();
                }
            });
        });
        $("#active").click(function() {
            var myStatus = new Array();
            $("input:checked").each(function() {
                myStatus.push($(this).val());
            });

            $.ajax({
                type: "POST",
                url: "active.php",
                dataType: 'html',
                data: { myField:$("textarea[name=status]").val(),
                    myStatus:myStatus },
                success: function(data){
                    location.reload();
                    //$('#myResponse').html(data)
                }
            });
            return false;
        });
    });

</script>
<style>
    body{
      font-size: 15px;
    }
    input[type=checkbox]:checked + span.strikethrough{
        text-decoration: line-through;
    }
    .mr4{
        margin-right: 10px;
    }
    .mr{
        padding: 5px;
        width: 10%;
    }
</style>
</body>
</html>