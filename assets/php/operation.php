
<?php

require_once ("db.php");
require_once ("component.php");

$connection = create_db();

// create button click
if(isset($_POST['create'])){
    create_data();
}

if(isset($_POST['update'])){
    updateData();
}

if(isset($_POST['delete'])){
    deleteRecord();
}

if(isset($_POST['deleteall'])){
    deleteAll();

}

function create_data(){
    $book_name = text_box_value("book_name");
    $book_publisher = text_box_value("book_publisher");
    $book_price = text_box_value("book_price");

    if($book_name && $book_publisher && $book_price){

        $sql = "INSERT INTO books (book_name, book_publisher, book_price) ".
            "VALUES ('$book_name','$book_publisher','$book_price')";

        if(mysqli_query($GLOBALS['connection'], $sql)){
            textNode("success", "Record Successfully Inserted...!");
        }else{
            echo "Error";
        }

    }else{
        textNode("error", "Provide Data in the Textbox");
    }
}

function text_box_value($value){
    $text_box = mysqli_real_escape_string($GLOBALS['connection'], trim($_POST[$value]));
    if(empty($text_box)){
        return false;
    }else{
        return $text_box;
    }
}


// messages
function textNode($classname, $msg){
    $element = "<h6 class='$classname'>$msg</h6>";
    echo $element;
}


// get data from mysql database
function getData(){
    $sql = "SELECT * FROM books";
    $result = mysqli_query($GLOBALS['connection'], $sql);
    if(mysqli_num_rows($result) > 0){
        return $result;
    }
}

// update dat
function updateData(){
    $book_id = text_box_value("book_id");
    $book_name = text_box_value("book_name");
    $book_publisher = text_box_value("book_publisher");
    $book_price = text_box_value("book_price");

    if($book_name && $book_publisher && $book_price){
        $sql = "UPDATE books SET book_name='$book_name', book_publisher = '$book_publisher', book_price = '$book_price' WHERE id='$book_id';";
        if(mysqli_query($GLOBALS['connection'], $sql)){
            textNode("success", "Data Successfully Updated");
        }else{
            textNode("error", "Enable to Update Data");
        }
    }else{
        textNode("error", "Select Data Using Edit Icon");
    }
}

function deleteRecord(){
    $bookid = (int)text_box_value("book_id");

    $sql = "DELETE FROM books WHERE id=$bookid";

    if(mysqli_query($GLOBALS['connection'], $sql)){
        textNode("success","Record Deleted Successfully...!");
    }else{
        textNode("error","Enable to Delete Record...!");
    }

}

function deleteBtn(){
    $result = getData();
    $i = 0;
    if($result){
        while ($row = mysqli_fetch_assoc($result)){
            $i++;
            if($i > 3){
                buttonElement("btn-deleteall", "btn btn-danger" ,"<i class='fas fa-trash'></i> Delete All", "deleteall", "");
                return;
            }
        }
    }
}


function deleteAll(){
    $sql = "DROP TABLE books";
    if(mysqli_query($GLOBALS['connection'], $sql)){
        textNode("success","All Record deleted Successfully...!");
        create_db();
    }else{
        textNode("error","Something Went Wrong Record cannot deleted...!");
    }
}

// set id to textbox
function setID(){
    $get_id = getData();
    $id = 0;
    if($get_id){
        while ($row = mysqli_fetch_assoc($get_id)){
            $id = $row['id'];
        }
    }
    return ($id + 1);
}