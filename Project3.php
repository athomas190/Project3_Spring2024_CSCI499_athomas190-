<?php

////// Write the Database connection code below (Q1)
$servername = 'localhost'; //for XAMPP we use localhost
$username = 'root'; //default username in XAMPP
$password = ''; //default password in XAMPP
$dbname = 'Food Nutrition'; //Change this to whatever database name you set in PHPmyAdmin
$link = mysqli_connect($servername,$username,$password, $dbname);

///////// (Q1 Ends)

$operation_val = '';
if (isset($_POST['operation']))
{
    $operation_val = $_POST["operation"];
    #echo $operation_val;
}

function getId($link) {
    
    $queryMaxID = "SELECT MAX(id) FROM fooditems;";
    $resultMaxID = mysqli_query($link, $queryMaxID);
    $row = mysqli_fetch_array($resultMaxID, MYSQLI_NUM);
    return $row[0]+1;
}



if (isset($_POST['updatebtn']))
//// Write PHP Code below to update the record of your database (Hint: Use $_POST) (Q9)
//// Make sure your code has an echo statement that says "Record Updated" or anything similar or an error message
$record_id = $_POST['record_id']; // Assuming you have a hidden input field for record ID
$record_new_value = $_POST['new_value'];
$record_carbohydrates = $_POST['carbohydrate']; // Assuming you have a form input field for the new value

// SQL query to update the record
$sql = "UPDATE Food Nutrition SET carbohydrate= 3  WHERE carbohydate = 1";

$result = mysqli_query($link, $sql);    
echo"Record Updated";
//// (Q9 Ends)



if (isset($_POST['insertbtn']))
//// Write PHP Code below to insert the record into your database (Hint: Use $_POST and the getId() function from line 25, if needed) (Q10)
//// Make sure your code has an echo statement that says "Record Saved" or anything similar or an error message
{
$insert_item = $_POST['Item'];
$insert_amount = $_POST['Amount'];
$insert_unit = $_POST['Unit'];
$insert_calories = $_POST['Calories'];
$insert_protein = $_POST['Protein'];
$insert_carbohydrates = $_POST['Carbohydrates'];
$insert_fat = $_POST['Fat'];
$getId = getId($link);
echo "Record saved";   
}
//// (Q10 Ends)

if (isset($_POST['deletebtn']))
{//// Write PHP Code below to delete the record from your database (Hint: Use $_POST) (Q11)
//// Make sure your code has an echo statement that says "Record Deleted" or anything similar or an error message
$deleteid = $_POST['deleteid'];
$sql = "DELETE FROM fooditems WHERE id = $deleteid";
$result = mysqli_query($link, $sql);
echo "Record deleted";
}


//// (Q11 Ends)



?>


<html>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <link rel="stylesheet" href="p3.css">
        <script>
            $(document.ready(function() {
                $("#testbtn").click(function(e) {
                    e.preventDefault();

                    $.ajax({
                        url: 'p3.php',
                        type: 'POST',
                        data: {
                            'operation_val' : $("#operation_val").val(),
                        },
                        success: function(data, status) {
                            $("#test").html(data)
                        }
                    });
                });
                $("#insertbtn").click(function(e) {
                    echo "here0";
                    e.preventDefault();

                    $.ajax({
                        url: 'p3.php',
                        type: 'POST',
                        data: {
                            'operation_val' : $("#operation_val").val(),
                        },
                        success: function(data, status) {
                            echo "here";
                        }
                    });
                });
            }));
            
        </script>
        <link rel="stylesheet" href="p3.css">
    </head>

    <body>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="cars">Choose an operation:</label>
            <select name="operation" id="operation" onchange="this.form.submit()">
                <option value="0" <?php print ($operation_val == 0) ? "selected" : '' ;?>><b>Select Operation</b></option>
                <option value="1" <?php print ($operation_val == 1) ? "selected" : '' ;?>>Show</option>
                <option value="2" <?php print ($operation_val == 2) ? "selected" : '' ;?>>Update</option>
                <option value="3" <?php print ($operation_val == 3) ? "selected" : '' ;?>>Insert</option>
                <option value="4" <?php print ($operation_val == 4) ? "selected" : '' ;?>>Delete</option>
            </select></br></br>
            <?php


            $query = "SELECT * FROM fooditems;";
            if($operation_val == 1){
                if($result = mysqli_query($link, $query)){
                    $fields_num = mysqli_num_fields($result);
                    echo "<table class=\"customTable\"><th>";
                    for($i=0; $i<$fields_num; $i++)
                    {
                        $field = mysqli_fetch_field($result);
                        if($i>0)
                        {
                            echo "<th>{$field->name}</th>";
                        }
                        else
                        {
                            echo "id";
                        }
                        
                    }
                    echo "</th>";
                    if($operation_val == 1){
                        while($row = mysqli_fetch_row($result))
                        {
                            ///// Finish the code for the table below using a loop (Q2)
                            echo "<tr>";
                                foreach($row as $cell)
                                {
                                    echo "<td> $cell </td>";

                                }
                                echo "</tr>";


                            ///////////// (Q2 Ends)
                        }
                    }                    
                    echo "</table>";
            }
        }
            

            ?>

            


            <div id="div_update" runat="server" class=<?php if($operation_val == 2) {echo "display-block";} else {echo "display-none";}?>>
            <!--Create an HTML table below to enter ID, amount, and calories in different text boxes. This table is used for updating records in your table. (Q3) --->
            <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Amount</th>
                <th>Calories</th>
            </tr>
        </thead>
        <div class= "customTable">

        <tbody>
            <tr>
                <td><input type="text" name="Id" id="id"></td>
                <td><input type="text" name="Amount" id="amount"></td>
                <td><input type="text" name="Calories" id="calories"></td>
            </tr>
        </tbody>
    </div>
    </table>
            <!--(Q3) Ends --->
            



            <!--Create a button below to submit and update record. Set the name and id of the button to be "updatebtn"(Q4) --->
            <button type="submit" name="updatebtn" id="updatebtn">Submit and Update Record</button>
            <!--(Q4) Ends --->
            </div>



            <div id="div_insert" runat="server" class=<?php if($operation_val == 3) {echo "display-block";} else {echo "display-none";}?>>
            <!--Create an HTML table below to enter item, amount, unit, calories, protein, carbohydrate and fat in different text boxes. This table is used for inserting records in your table. (Q5) --->
                
            <table>
          

                 <tr>
                      <th>Item</th>
                     <th>Amount</th>
                      <th>Unit</th>
                    <th>Calories</th>
                     <th>Protein</th>
                     <th>Carbohydrate</th>
                     <th>Fat</th>
                    </tr>
                  <tr>
             <td><input type="text" name= "Item"></td>
             <td><input type="text" name ="Amount"></td>
             <td><input type="text" name= "Unit" ></td>
             <td><input type="text" name="Calories"></td>
             <td><input type="text" name="Protien"></td>
             <td><input type="text" name="Carbohydrate"></td>
             <td><input type="text" name="Fat"></td>
           </tr>
                    </table>
           
            <!--(Q5) Ends --->

            <!--Create a button below to submit and insert record. Set the name and id of the button to be "insertbtn"(Q6) --->
            
            <button type="submit" name="insertbtn" id="insertbtn">Insert Record</button>

            <!--(Q6) Ends --->
            </div>

            <div id="div_delete" runat="server" class=<?php if($operation_val == 4) {echo "display-block";} else {echo "display-none";}?>>
            <!--Create an HTML table below to enter id a text box. This table is used for deleting records from your table. (Q7) --->
            <table>
               <tr>
                     <td>ID:</td>
                      <td><input type="text" id="delete_id" name="delete_id" placeholder="Enter ID"></td>
              </tr>
            
             </table>   

            <!--(Q7) Ends--->    

            <!--Create a button below to submit and insert record. Set the name and id of the button to be "deletebtn"(Q8) --->
            <button type="submit" name="deletebtn" id="deletebtn">Delete</button>
            <!--(Q8) Ends --->
            </div>
            
        </form>

    </body>




</html>



