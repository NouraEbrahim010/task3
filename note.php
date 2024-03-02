<?php
session_start();
require('configdb.php');
$query='SELECT * FROM notes ORDER BY created_at DESC';
$result=mysqli_query($conn,$query);
$notes=mysqli_fetch_all($result,MYSQLI_ASSOC);
mysqli_free_result($result);
?>


<!DOCTYPE html>
    <html lang="en">
        <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="bootstrap.min.css">
        <title>Notes</title>
        </head>
    <body>
        <div class="container">
        <h1>My Notes</h1>
        <br>
        <?php foreach($notes as $note) : ?>
            <div class="well">
                <small>Created on <?php echo $note['created_at']; ?></small>
               <h1><p><?php echo $note['body']; ?></p></h1> 
            </div>
            <br>
        <?php endforeach; ?>
        </div>
        <div class="container">
        <h1>Add Note</h1>
            <form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
                <div class="gorm-group">
                    <textarea id="note-input" placeholder="Enter your note here..." rows="10" cols="70"></textarea>
                    <button onclick="saveNote()" class="btn btn-primary" style="margin-bottom: 20px">Save Note</button>
                    <ul id="note-list"></ul>
        
            </form>
        </div>
        
        <script>
            function saveNote() {
            var note = document.getElementById("note-input").value;
            if (note.trim() !== "") {
                var existingNotes = JSON.parse(localStorage.getItem("notes")) || [];
                existingNotes.push(note);
                localStorage.setItem("notes", JSON.stringify(existingNotes));
                document.getElementById("note-input").value = "";
                displayNotes();
            } else {
                alert("Please enter a note.");
            }
        }
        
  function displayNotes() {
            var noteList = document.getElementById("note-list");
            var notes = JSON.parse(localStorage.getItem("notes")) || [];
            noteList.innerHTML = "";
            notes.forEach(function(note, index) {
                var listItem = document.createElement("li");
                listItem.className = "note-item";
                listItem.innerHTML = note + '<button onclick="deleteNote(' + index + ')">Delete</button>';
                noteList.appendChild(listItem);
            });
        }
        
  function deleteNote(index) {
            var notes = JSON.parse(localStorage.getItem("notes")) || [];
            notes.splice(index, 1);
            localStorage.setItem("notes", JSON.stringify(notes));
            displayNotes();
        }
        displayNotes();
        </script>
    </body>
    </html>
