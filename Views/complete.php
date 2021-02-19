<?php
include_once ('../vendor/autoload.php');
use weTask\Product\Product;
$obj = new Product();
$data = $obj->complete();
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
                    $active_data = 0;
                    foreach ($data as $d){
                        if($d['status'] == 1) {?>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><input type="checkbox" checked id="status" class="mr4" disabled name="status[]" value="<?php echo $d['id']?>">
                                <span class="strikethrough"><?php echo $d['name']?></span>
                            </li>
                        </ul>
                    <?php } else{
                            $active_data++;
                    }
                    } ?>
                    <div class="card-header">
                        <table>
                            <tr>
                                <td id="edit_name"><?php echo ($active_data) . ' Item Left'?></td>
                                <td class="mr"><a href="store.php">All</a> </td>
                                <td class="mr"><button type="button" class="btn btn-link">Active</button></td>
                                <td class="mr"><a href="complete.php">Completed</a> </td>
                                <td class="mr2"><button type="button" class="btn btn-link" id="clear_complete">Clear Completed</button></td>
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
        // $('#todo_name').blur(function(){
        //    var name = $('#todo_name').val();
        //     $.ajax({
        //         url:"store.php",
        //         method:"POST",
        //         data:{name:name},
        //         success:function(data)
        //         {
        //             console.log(data);
        //             $('#user_table').html(data);
        //         }
        //     });
        // });

        $("#clear_complete").click(function() {
            var myClearStatus = new Array();
            $("input:checked").each(function() {
                myClearStatus.push($(this).val());
            });

            $.ajax({
                type: "POST",
                url: "clear_complete.php",
                dataType: 'html',
                data: { myField:$("textarea[name=status]").val(),
                    myClearStatus:myClearStatus },
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
        font-size: 15px !important;
    }
    input[type=checkbox]:checked + span.strikethrough{
        text-decoration: line-through;
    }
    .mr4{
        margin-right: 10px;
    }
    .mr{
        padding: 5px;
        width: 5%;
    }
    .mr2{
        padding: 5px;
        width: 24%;
    }
</style>
</body>
</html>